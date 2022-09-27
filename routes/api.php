<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//WMS連携
Route::post('/wms/shipping', [App\Http\Controllers\WmsController::class, 'shipping']);
//GMO決裁通知
Route::post('/gmo/payment_recv', [App\Http\Controllers\GmoController::class, 'payment_recv']);