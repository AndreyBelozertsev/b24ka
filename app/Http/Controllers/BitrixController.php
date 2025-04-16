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

        //get the users
        $users = [];
        $users_raw_raw = [];
        $users_raw[] = $B24->core->call('user.current')->getResponseData()->getResult();
        if( isset($users_raw[0]['UF_DEPARTMENT'])) {
            $intersection = array_intersect($users_raw[0]['UF_DEPARTMENT'], [11, 13, 355, 349]);
            if (!empty($intersection)) {
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
                ->where('start_at', '>=', (new DateTime())->modify('first day of this month')->format('Y-m-d'))
                ->where('start_at', '<', (new DateTime('last day of this month'))->format('Y-m-d'))
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
            $select = ['ID','TITLE', 'OPPORTUNITY','STAGE_ID'];
            $deal_receive = 0; 
            $deal_success = 0;   
            $summ_receive = 0;
            $summ_success = 0;
            $summ = 0; 
            foreach($B24->getCRMScope()->deal()->batch->list(['ID' => 'ASC'],$args_receive,$select,10000) as $deal){
                $summ_receive += $deal->OPPORTUNITY;
                $deal_receive++;
            }
            foreach($B24->getCRMScope()->deal()->batch->list([],$args_success,$select,10000) as $deal){
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
            if($deal_receive != 0){
                $users[$user['ID']]['summ_success'] = ($deal_success/$deal_receive)*100;
            }
            
        }

        return view('b24api/index', [
            'period' =>  $monthStart,
            'users' => $users
        ]);
    }

    public function install(Request $request){
        return view('b24api/install', []);
    }
}