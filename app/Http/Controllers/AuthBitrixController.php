<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class AuthBitrixController extends Controller
{
    public function callback(Request $request){

    }

    public function index(Request $request){
        session_start();

        $httpClient = new Client([
            'timeout' => 30,
            'verify' => false, // Только для разработки!
        ]);
    }
}
