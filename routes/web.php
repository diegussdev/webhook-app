<?php

use App\Http\Controllers\FakeRequesterController;
use App\Http\Controllers\WebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (Request $request) {
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
});

// Fake Request routes
Route::any('/fakerequest', [FakeRequesterController::class, 'fakeRequest']);

// Webhook routes
Route::get('/webhook/requests', [WebhookController::class, 'requests']);
Route::get('/webhook/generate', [WebhookController::class, 'generate']);
Route::any('/webhook/clear', [WebhookController::class, 'clear']);
Route::any('/webhook/{uuid}/{code?}', [WebhookController::class, 'store']);

