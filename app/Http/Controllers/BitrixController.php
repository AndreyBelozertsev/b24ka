<?php

namespace App\Http\Controllers;
use DateTime;
use App\Models\Staff;
use Illuminate\Http\Request;
use Bitrix24\SDK\Services\ServiceBuilderFactory;
use Bitrix24\SDK\Core\Credentials\ApplicationProfile;

class BitrixController extends Controller
{
    public function index(Request $request){

        //Bitrix init
        $appProfile = ApplicationProfile::initFromArray([
            'BITRIX24_PHP_SDK_APPLICATION_CLIENT_ID' => env('BITRIX24_PHP_SDK_APPLICATION_CLIENT_ID'),
            'BITRIX24_PHP_SDK_APPLICATION_CLIENT_SECRET' => env('BITRIX24_PHP_SDK_APPLICATION_CLIENT_SECRET'),
            'BITRIX24_PHP_SDK_APPLICATION_SCOPE' => env('BITRIX24_PHP_SDK_APPLICATION_SCOPE')
        ]);
        $B24 = ServiceBuilderFactory::createServiceBuilderFromPlacementRequest(Request::createFromGlobals(), $appProfile);

        //get last and first date
        $monthStart = (new DateTime())->modify('first day of this month')->format('Y-m-d');
        $monthEnd = (new DateTime('last day of this month'))->format('Y-m-d');
        // $monthStart = (new DateTime())->setDate((int)date('Y'), 4, 1)->format('Y-m-d');
        // $monthEnd = (new DateTime())->setDate((int)date('Y'), 4, 30)->format('Y-m-d');


        //get the users
        $users = [];
        $users_raw_raw = [];
        $users_raw[] = $B24->core->call('user.current')->getResponseData()->getResult();
        if( isset($users_raw[0]['UF_DEPARTMENT'])) {
            $intersection = array_intersect($users_raw[0]['UF_DEPARTMENT'], [11, 13, 355, 349]);
            $users_access_ids = ['51289'];
            if (!empty($intersection) || in_array($users_raw[0]['ID'], $users_access_ids)) {
                $users_raw = $B24->core->call('user.get', [
                    'filter' => ['UF_DEPARTMENT' => 407],
                    'select' => ['ID', 'NAME', 'LAST_NAME','WORK_POSITION']
                ]);
                $users_raw = $users_raw->getResponseData()->getResult();
            }
        }

        //getDate
        $total = 0;
        $total_deal_receive = 0;
        $total_deal_success = 0;
        foreach($users_raw as $user){
            $user_app = Staff::where('bitrix_id', $user['ID'])->first();
            if(!$user_app){
                continue;
            }
            $plan = $user_app->plans()
                ->where('start_at', '>=',         $monthStart)
                ->where('start_at', '<',         $monthEnd)
                ->first();
            if(!$plan){
                continue;
            }
            $users[$user['ID']]['plan'] = $plan->summ;
            $users[$user['ID']]['plan_conversion'] = $plan->conversion;
            $users[$user['ID']]['salary'] = $plan->salary;
            $users[$user['ID']]['options'] = $plan->options;
            $users[$user['ID']]['name'] = $user['LAST_NAME'] . ' ' . $user['NAME'];

            $args_success = [
                'ASSIGNED_BY_ID' => $user['ID'],
                'STAGE_ID' => 'WON',
                'CATEGORY_ID' => 0,
                '>=CLOSEDATE' => $monthStart,
                '<=CLOSEDATE' => $monthEnd,
            ];

            $args_receive = [
                'ASSIGNED_BY_ID' => $user['ID'],
                '!@STAGE_ID' => ['5','6','7','16','17'],
                'CATEGORY_ID' => 0,
                '>=DATE_CREATE' => $monthStart,
                '<=DATE_CREATE' => $monthEnd,
            ];
            $select = ['ID','TITLE', 'OPPORTUNITY','STAGE_ID', 'CLOSEDATE'];
            $deal_receive = 0; 
            $deal_success = 0;   
            $summ_receive = 0;
            $summ_success = 0;
            $summ = 0; 
            foreach($B24->getCRMScope()->deal()->batch->list(['ID' => 'ASC'],$args_receive,$select,10000) as $deal){
                $summ_receive += $deal->OPPORTUNITY;
                $deal_receive++;
            }
            foreach($B24->getCRMScope()->deal()->batch->list(['ID' => 'ASC'],$args_success,$select,10000) as $deal){
                $summ_success += $deal->OPPORTUNITY;
                $deal_success++;
            }
            $total += $summ_success;
            $total_deal_receive += $deal_receive;
            $total_deal_success += $deal_success;
            $users[$user['ID']]['deal_receive'] = $deal_receive;
            $users[$user['ID']]['summ_receive'] = $summ_receive;
            $users[$user['ID']]['deal_success'] = $deal_success;
            $users[$user['ID']]['summ_success'] = $summ_success;
            $users[$user['ID']]['plan_percent'] = ($summ_success/$plan->summ)*100;
            if($deal_receive != 0){
                $users[$user['ID']]['conversion'] = ($deal_success/$deal_receive)*100;
            }else{
                $users[$user['ID']]['conversion'] = 0;
            }
            if($plan->kpi_model_id == 1){
                $users[$user['ID']]['sallary_count'] = $this->calculateManagerSalary1($plan->summ, $summ_success, $plan->options);
            }

            if($plan->kpi_model_id == 2){
                $users[$user['ID']]['sallary_count'] = $this->calculateManagerSalary2($plan->summ, $summ_success, $plan->options);
            }
        }
        $date = new DateTime($monthStart);
        setlocale(LC_TIME, 'ru_RU.UTF-8'); // Устанавливаем русскую локаль
        $date = strftime('%B %Y', $date->getTimestamp());

        $date = new DateTime($monthStart);
        $months = [
            1 => 'январь', 2 => 'февраль', 3 => 'март', 
            4 => 'апрель', 5 => 'май', 6 => 'июнь',
            7 => 'июль', 8 => 'август', 9 => 'сентябрь',
            10 => 'октябрь', 11 => 'ноябрь', 12 => 'декабрь'
        ];


        return view('b24api/index', [
            'period' =>  $months[(int)$date->format('n')] . ' ' . $date->format('Y'),
            'users' => $users,
            'total_summ' => $total,
            'total_deal_receive' => $total_deal_receive,
            'total_deal_success' => $total_deal_success
        ]);
    }

    public function install(Request $request){
        return view('b24api/install', []);
    }

    protected function calculateManagerSalary1($plan, $actualSales, $options) {

        $percentage = ($actualSales / $plan) * 100;
        $salary = 0;
        $processedRanges = [];
        
        // Сортируем options для обработки в правильном порядке
        $sortedOptions = [];
        foreach ($options as $key => $value) {
            if ($key === 100) {
                $sortedOptions['100+'] = (float)$value / 100;
            } elseif (strpos($key, '-') !== false) {
                $sortedOptions[$key] = (float)$value / 100;
            }
        }
        
        // Сортируем диапазоны по возрастанию
        uksort($sortedOptions, function($a, $b) {
            if ($a === '100+') return 1;
            if ($b === '100+') return -1;
            
            $aMin = explode('-', $a)[0];
            $bMin = explode('-', $b)[0];
            return $aMin <=> $bMin;
        });
        $previousUpperBound = 0;
        
        foreach ($sortedOptions as $range => $rate) {
            if ($range === '100+') {
                if ($percentage > 100) {
                    $overAchievement = $actualSales - $plan;
                    $salary += $overAchievement * $rate;
                    $processedRanges[] = "Свыше 100%: ".($rate*100)."% от ".number_format($overAchievement, 0, '', ' ') . " - " . number_format($overAchievement * $rate, 0, '', ' ');
                }
                continue;
            }
            
            list($min, $max) = explode('-', $range);
            $min = (float)$min;
            $max = (float)$max;


            $lowerBound = $plan * ($min / 100);
            $upperBound = $plan * ($max / 100);


            if ($percentage >= $min) {
                $applicableAmount = min($actualSales, $upperBound) - max($previousUpperBound, $lowerBound);
                if ($applicableAmount > 0) {
                    $salary += $applicableAmount * $rate;
                    $processedRanges[] = "$min-$max%: ".($rate*100)."% от ".number_format($applicableAmount, 0, '', ' ')  . " - " . number_format($applicableAmount * $rate, 0, '', ' ');
                }
                $previousUpperBound = $upperBound;
            }
        }
        
        return [
            'salary' => $salary,
            'calculation_details' => $processedRanges
        ];
    }

    protected function calculateManagerSalary2($plan, $actualSales, $options) {
        $percentage = ($actualSales / $plan) * 100;
        $salary = 0;
        $processedRanges = [];
        
        // Подготовка и сортировка опций
        $sortedOptions = [];
        foreach ($options as $key => $value) {
            if ($key === 100) {
                $sortedOptions['100+'] = (float)$value / 100;
            } elseif (strpos($key, '-') !== false) {
                $sortedOptions[$key] = (float)$value / 100;
            }
        }
        
        // Сортировка диапазонов по возрастанию
        uksort($sortedOptions, function($a, $b) {
            if ($a === '100+') return 1;
            if ($b === '100+') return -1;
            
            $aMin = explode('-', $a)[0];
            $bMin = explode('-', $b)[0];
            return $aMin <=> $bMin;
        });
        
        // Определяем какой диапазон применим
        $applicableRate = 0;
        foreach ($sortedOptions as $range => $rate) {
            if ($range === '100+') {
                if ($percentage > 100) {
                    $applicableRate = $rate;
                    $processedRanges[] = "Диапазон: свыше 100% - ставка ".($rate*100)."%";
                }
                break;
            }
            
            list($min, $max) = explode('-', $range);
            if ($percentage >= $min && $percentage <= $max) {
                $applicableRate = $rate;
                $processedRanges[] = "Диапазон: $min-$max% - ставка ".($rate*100)."%";
                break;
            }
        }
        
        // Если не попали ни в один диапазон (выполнение < минимального)
        if ($applicableRate === 0 && $percentage > 0) {
            $processedRanges[] = "Выполнение менее минимального порога - премия не начисляется";
            return [
                'salary' => 0,
                'calculation_details' => $processedRanges
            ];
        }
        
        // Расчет зарплаты (на всю сумму продаж)
        $salary = $actualSales * $applicableRate;
        $processedRanges[] = "Начислено: ".($applicableRate*100)."% от ".number_format($actualSales, 0, '', ' ')." = ".number_format($salary, 0, '', ' ');
        
        return [
            'salary' => $salary,
            'calculation_details' => $processedRanges
        ];
    }
}


