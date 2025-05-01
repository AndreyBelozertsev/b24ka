<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PositionController extends Controller
{
    public function test(Request $request){
        Log::channel('requests')->info('Request logged:', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'request_data' => $request->all(),
        ]);
        dump($request);
    }
}
