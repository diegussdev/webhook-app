<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class WebhookController extends Controller
{
    /**
     * Return requests in cache
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function requests(Request $request): JsonResponse
    {
        
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
    }

    /**
     * Store request
     * 
     * @param Request $request
     * @param string|null $uuid
     * @param integer|null $code
     * @return Response
     */
    public function store(
        Request $request,
        string $uuid = null,
        int $code = 200
    ): Response {
        $hasUUID = Cache::has($uuid);
    
        if (!$hasUUID) {
            return response('', 200);
        }
    
        $code = array_key_exists($code, JsonResponse::$statusTexts) ? $code : 200;
    
        $requestUUID = (string) Str::uuid();
        $currentRequest = [
            'id' => $requestUUID,
            'origin' => $request->headers->get('origin'),
            'method' => $request->method(),
            'datetime' => time(),
            'query' => $request->query() ? json_encode($request->query()) : null,
            'body' => $request->post() ? json_encode($request->post()) : null,
            'headers' => $request->header() ? json_encode($request->header()) : null,
            'responseCode' =>  "{$code} - " . JsonResponse::$statusTexts[$code]
        ];
        
        $data = json_decode(Cache::get($uuid), true);
        $expireAt = (int) $data['expireAt'] - time();
    
        $data['requests'][$requestUUID] = $currentRequest;
        
        Cache::put($uuid, json_encode($data), $expireAt);
        return response('', $code);
    }

    /**
     * Clear webhook requests
     * 
     * @param Request $request
     * @return Response
     */
    public function clear(Request $request): Response
    {
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
    }
    

    /**
     * Generate fake request to webhook
     * 
     * @param Request $request
     * @return Response
     */
    public function generate(Request $request): Response
    {
        $sessionUUID = session()->get('uuid');

        if (!$sessionUUID) {
            return response('', 200);
        }
    
        $client = new \GuzzleHttp\Client();
    
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
            } catch (\Exception $e) {
                $data[$method] = [
                    'error' => $e->getMessage()
                ];
            }
        }
    
        return response('', 200);
    }
}
