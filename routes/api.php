<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CycleApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login','\App\Http\Controllers\Api\LoginController::class@login');
Route::post('register','\App\Http\Controllers\Api\UserApiController::class@register');
Route::middleware('rol:STU,COMP')->group(function () {
    Route::get('user/profile ',\App\Http\Controllers\Api\UserApiController::class);
    Route::post('user/profile/update', \App\Http\Controllers\Api\UserApiController::class);
});

Route::middleware('rol:ADMIN,RESP,COMP')->group(function (){
    Route::apiResource('company',\App\Http\Controllers\Api\CompanyApiController::class);
});
