<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Bitrix24\SDK\Core\Credentials\ApplicationProfile;
use Bitrix24\SDK\Services\ServiceBuilderFactory;

class BitrixController extends Controller
{
    public function index(Request $request){


        echo "<pre>";
        dump($request);
        echo "</pre>";

        $appProfile = ApplicationProfile::initFromArray([
            'BITRIX24_PHP_SDK_APPLICATION_CLIENT_ID' => env('BITRIX24_PHP_SDK_APPLICATION_CLIENT_ID'),
            'BITRIX24_PHP_SDK_APPLICATION_CLIENT_SECRET' => env('BITRIX24_PHP_SDK_APPLICATION_CLIENT_SECRET'),
            'BITRIX24_PHP_SDK_APPLICATION_SCOPE' => 'crm'
        ]);

        $b24Service = ServiceBuilderFactory::createServiceBuilderFromPlacementRequest(Request::createFromGlobals(), $appProfile);

        return view('b24api/index', ['b24' => $b24Service]);
    }

    public function install(Request $request){
        return view('B24api/install', []);
    }
}
