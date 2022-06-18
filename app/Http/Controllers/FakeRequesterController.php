<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FakeRequesterController extends Controller
{
    /**
     * Make fake request
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function fakeRequest(Request $request): JsonResponse
    {
        $timeout = (int) $request->input('timeout');
    
        if ($timeout) {
            sleep($timeout);
        }
    
        $code = (int) $request->input('code');
        $code = array_key_exists($code, JsonResponse::$statusTexts) ? $code : 200;
    
        $response = (array) $request->post();
    
        if (!$response) {
            $response = ['data' => "{$code} - " . JsonResponse::$statusTexts[$code]];
        }
    
        return response()->json($response, $code);
    }
}
