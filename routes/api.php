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
Route::post('login',[\App\Http\Controllers\Api\LoginController::class, 'login']);
Route::post('registerCompany',[\App\Http\Controllers\Api\CompanyApiController::class, 'store']);
Route::post('registerStudent',[\App\Http\Controllers\Api\StudentApiController::class, 'register']);
Route::middleware('rol:STU,COMP')->group(function () {
    Route::get('user/profile ',[\App\Http\Controllers\Api\UserApiController::class, 'show']);
    Route::post('user/profile/update', [\App\Http\Controllers\Api\UserApiController::class, 'update']);
});

Route::apiResource('company',\App\Http\Controllers\Api\CompanyApiController::class)->middleware('rol:ADMIN,RESP,COMP');
Route::delete('student/delete/{id}',[\App\Http\Controllers\Api\UserApiController::class, 'delete'])->middleware('rol:ADMIN,RESP,STU');
Route::apiResource('responsible',\App\Http\Controllers\Api\UserApiController::class)->middleware('rol:RESP');
Route::get('validate/{id}',[\App\Http\Controllers\Api\OfferApiController::class, 'validate'])->middleware('rol:ADMIN,RESP');
Route::apiResource('students', \App\Http\Controllers\Api\StudentApiController::class)->middleware('rol:ADMIN,STU');
Route::apiResource('users', \App\Http\Controllers\Api\UserApiController::class)->middleware('rol:ADMIN');
Route::apiResource('offers', \App\Http\Controllers\Api\OfferApiController::class)->middleware('rol:ADMIN,COMP');
