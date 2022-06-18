<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class IndexController extends Controller
{
    /**
     * Show index page application
     * 
     * @param Request $request
     */
    public function index(Request $request)
    {
        $sessionUUID = session()->get('uuid');
        $oneDayExpiration = 60 * 60 * 24;
        $expireAt = time() + $oneDayExpiration;
    
        if (!$sessionUUID || !Cache::has($sessionUUID)) {
            $sessionUUID = $sessionUUID ?: (string) Str::uuid();
            session()->put('uuid', $sessionUUID);
            session()->save();
            
            Cache::put($sessionUUID, json_encode(['expireAt' => $expireAt]), $oneDayExpiration);
        }
    
        $fakeRequester = $_SERVER['HTTP_HOST'] . '/fakerequest?code=200&timeout=1';
        $webhook = $_SERVER['HTTP_HOST'] . "/webhook/{$sessionUUID}/200";
        $flush = $_SERVER['HTTP_HOST'] . '/webhook/flush';
        $cache = json_decode(Cache::get($sessionUUID), true);
        $requests = [];
    
        if ($cache) {
            $requests = array_key_exists('requests', $cache) 
                ? $cache['requests']
                : [];
    
            $expireAt = array_key_exists('expireAt', $cache)
                ? $cache['expireAt']
                : $expireAt;
        }
    
        $data = [
            'expireAt' => $expireAt,
            'FakeRequester' => [
                'url' => $fakeRequester,
            ],
            'Webhook' => [
                'url' => $webhook,
                'flush' => $flush,
                'requests' => $requests
            ]
            
        ];
    
        return view('welcome', $data);
    }
}
