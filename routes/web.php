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

Route::get('/', function () {
    $sessionUUID = session()->get('uuid');
    $oneDayExpiration = 60 * 60 * 24;
    $expireAt = time() + $oneDayExpiration;

    if (!$sessionUUID || !Cache::has($sessionUUID)) {
        $sessionUUID = $sessionUUID ?: (string) Str::uuid();
        session()->put('uuid', $sessionUUID);
        session()->save();
        
        Cache::put($sessionUUID, json_encode(['expireAt' => $expireAt]), $oneDayExpiration);
    }

    $fakeRequester = $_SERVER['HTTP_HOST'] . '/fakerequest';
    $webhook = $_SERVER['HTTP_HOST'] . "/webhook/{$sessionUUID}";
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
            'availableQueryParams' => [
                'code' => 'HTTP_CODE',
                'timeout' => 'Seconds to wait for response'
            ],
            'info' => 'The request body will be returned in the response'
        ],
        'Webhook' => [
            'url' => $webhook,
            'urlToDefineHttpCodeResponse' => "{$webhook}/{HTTP_CODE_HERE}",
            'flush' => $flush,
            'resquests' => $requests
        ]
        
    ];

    return response()->json($data, 200);
});

Route::any('/webhook/flush', function () {
    $sessionUUID = session()->get('uuid');
    Cache::forget($sessionUUID);
    return response('', 200);
});


Route::any('/webhook/{uuid}/{code?}', function (Request $request, $uuid = null, $code = 200) {
    $hasUUID = Cache::has($uuid);

    if (!$hasUUID) {
        return response('', 404);
    }

    $currentRequest = [
        'origin' => $request->headers->get('origin'),
        'method' => $request->method(),
        'datetime' => time(),
        'query' => json_encode($request->query()),
        'body' => json_encode($request->post()),
        'headers' => json_encode($request->header()),
    ];
    
    $data = json_decode(Cache::get($uuid), true);

    $expireAt = (int) $data['expireAt'] - time();

    if (array_key_exists('requests', $data)) {
        array_unshift($data['requests'], $currentRequest);
    } else {
        $data['requests'][] = $currentRequest;
    }

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

// Generate fake webhook requests
Route::get('/generateWebhookRequests', function () {
    $sessionUUID = session()->get('uuid');

    if (!$sessionUUID) {
        return response('', 404);
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
            'Authorization' => 'Bearer MyTokenTest'
        ],
        'form_params' => [
            'id' => 123,
            'status' => 12345
        ]

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

    return response()->json($data);
});
