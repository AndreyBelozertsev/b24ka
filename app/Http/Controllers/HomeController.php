<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Bitrix24\SDK\Core\Credentials\ApplicationProfile;
use Bitrix24\SDK\Services\ServiceBuilderFactory;
//use Symfony\Component\HttpFoundation\Request as ;

class HomeController extends Controller
{
    public function index(){
        $authUrl = "https://kobbauto.bitrix24.ru/oauth/authorize/?client_id=local.67dd63b67cc4e1.50885023&redirect_uri=".urlencode('https://crm.kobbauto-technical.ru/')."&response_type=code";
        

        $tokenUrl = "https://kobbauto.bitrix24.ru/oauth/token/?grant_type=authorization_code&client_id=local.67dd63b67cc4e1.50885023&client_secret=Ixtr5lNT7PeKLrOvmq2WLwL6LYS2bD3WCRGNd6pDOA7HTrEIcT&redirect_uri=".urlencode('https://crm.kobbauto-technical.ru/')."&code=d7dfec67007713fe0066a4240000cd9b0000073fd9eb86661afd02876c2a6c73252b2a";
    }
}
