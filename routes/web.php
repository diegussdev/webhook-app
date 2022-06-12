<?php

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

Route::get('/webhook/requests', function () {
    $sessionUUID = session()->get('uuid');

    $cache = (array) json_decode(Cache::get($sessionUUID), true);
    $requests = [];

    if ($cache) {
        $requests = array_key_exists('requests', $cache) 
            ? $cache['requests']
            : [];
    }

    $data = [];
    foreach ($requests as $key => $request) {
        $data[$key] = view('request', ['key' => $key, 'request' => $request])->render();
    }

    return response()->json($data, 200);
});

// Generate fake webhook requests
Route::get('/webhook/generate', function () {
    $sessionUUID = session()->get('uuid');

    if (!$sessionUUID) {
        return response('', 200);
    }

    $client = new GuzzleHttp\Client();

    $methods = [
        'GET' => 200,
        'POST' => 201,
        'PUT' => 204,
        'PATCH' => 204,
        'DELETE' => 204
    ];
    
    $options = [
        'headers' => [
            'Authorization' => 'Bearer MyTokenTest',
            'Content-Type' => 'application/json'
        ],
        'body' => json_encode([
            'id' => 123,
            'status' => 12345
        ])
    ];

    $data = [];
    foreach ($methods as $method => $code) {
        $url = $_SERVER['HTTP_HOST'] . "/webhook/{$sessionUUID}/{$code}";

        try {
            $response = $client->request($method, $url, $options);
            $data[$method] = [
                'statusCode' => $response->getStatusCode()
            ];
        } catch (Exception $e) {
            $data[$method] = [
                'error' => $e->getMessage()
            ];
        }
    }

    return response('', 200);
});

Route::any('/webhook/clear', function () {
    $sessionUUID = session()->get('uuid');

    if (!Cache::has($sessionUUID)) {
        return response('', 200);
    }

    $data = json_decode(Cache::get($sessionUUID), true);
    $data['requests'] = [];
    $expireAt = (int) $data['expireAt'] - time();
    $data['requests'] = [];

    Cache::put($sessionUUID, json_encode($data), $expireAt);

    return response('', 200);
});


Route::any('/webhook/{uuid}/{code?}', function (Request $request, $uuid = null, $code = 200) {
    $hasUUID = Cache::has($uuid);

    if (!$hasUUID) {
        return response('', 200);
    }

    $requestUUID = (string) Str::uuid();
    $currentRequest = [
        'id' => $requestUUID,
        'origin' => $request->headers->get('origin'),
        'method' => $request->method(),
        'datetime' => time(),
        'query' => $request->query() ? json_encode($request->query()) : null,
        'body' => $request->post() ? json_encode($request->post()) : null,
        'headers' => $request->header() ? json_encode($request->header()) : null,
    ];
    
    $data = json_decode(Cache::get($uuid), true);
    $expireAt = (int) $data['expireAt'] - time();

    $data['requests'][$requestUUID] = $currentRequest;


    $code = array_key_exists($code, JsonResponse::$statusTexts) ? $code : 200;
    
    Cache::put($uuid, json_encode($data), $expireAt);
    return response('', $code);
});

Route::any('/fakerequest', function (Request $request) {    
    $timeout = (int) $request->input('timeout');
    
    if ($timeout) {
        sleep($timeout);
    }

    $code = $request->input('code');
    $code = array_key_exists($code, JsonResponse::$statusTexts) ? $code : 200;

    $response = (array) $request->post();

    if (!$response) {
        $response = ['data' => "{$code} - " . JsonResponse::$statusTexts[$code]];
    }

    return response()->json($response, $code);
});
