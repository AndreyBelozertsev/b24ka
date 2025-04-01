<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Bitrix24\SDK\Core\Credentials\ApplicationProfile;
use Bitrix24\SDK\Services\ServiceBuilderFactory;

class BitrixController extends Controller
{
    public function index(Request $request){

        $appProfile = ApplicationProfile::initFromArray([
            'BITRIX24_PHP_SDK_APPLICATION_CLIENT_ID' => env('BITRIX24_PHP_SDK_APPLICATION_CLIENT_ID'),
            'BITRIX24_PHP_SDK_APPLICATION_CLIENT_SECRET' => env('BITRIX24_PHP_SDK_APPLICATION_CLIENT_SECRET'),
            'BITRIX24_PHP_SDK_APPLICATION_SCOPE' => env('BITRIX24_PHP_SDK_APPLICATION_SCOPE')
        ]);

        $b24Service = ServiceBuilderFactory::createServiceBuilderFromPlacementRequest(Request::createFromGlobals(), $appProfile);
        $monthStart = (new DateTime())->modify('first day of this month')->format('Y-m-d');
        return view('b24api/index', [
            'B24' => $b24Service,
            'monthStart' => $monthStart,
        ]);
    }

    public function install(Request $request){
        return view('b24api/install', []);
    }
}
