<?php

use App\Http\Controllers\FakeRequesterController;
use App\Http\Controllers\IndexController;
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

Route::get('/', [IndexController::class, 'index']);

// Fake Request routes
Route::any('/fakerequest', [FakeRequesterController::class, 'fakeRequest']);

// Webhook routes
Route::get('/webhook/requests', [WebhookController::class, 'requests']);
Route::get('/webhook/generate', [WebhookController::class, 'generate']);
Route::any('/webhook/clear', [WebhookController::class, 'clear']);
Route::any('/webhook/{uuid}/{code?}', [WebhookController::class, 'store']);

