<?php

use App\Http\Controllers\TelegramBotController;
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

Route::post('/bot/1558303110:AAE_QHSjbQyaM6e-GlRb3YaTl6MDtfk4K7M', [TelegramBotController::class, 'index']);

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
