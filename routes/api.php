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
Route::post('registerStudent',[\App\Http\Controllers\Api\StudentApiController::class, 'store']);
Route::middleware('rol:STU,COMP')->group(function () {
    Route::get('user/profile ',[\App\Http\Controllers\Api\UserApiController::class, 'show']);
    Route::post('user/profile/update', [\App\Http\Controllers\Api\UserApiController::class, 'update']);
});

Route::apiResource('company',\App\Http\Controllers\Api\CompanyApiController::class)->middleware('rol:ADM,RESP,COMP');
Route::delete('student/delete/{id}',[\App\Http\Controllers\Api\UserApiController::class, 'delete'])->middleware('rol:ADM,RESP,STU');
Route::apiResource('responsible',\App\Http\Controllers\Api\UserApiController::class)->middleware('rol:RESP');
Route::get('validate/{id}',[\App\Http\Controllers\Api\OfferApiController::class, 'validate'])->middleware('rol:ADM,RESP');
Route::apiResource('students', \App\Http\Controllers\Api\StudentApiController::class)->middleware('rol:ADM,STU');
Route::apiResource('users', \App\Http\Controllers\Api\UserApiController::class)->middleware('rol:ADM');
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('offers', \App\Http\Controllers\Api\OfferApiController::class)->middleware('rol:ADM,COMP');
});

Route::get('cycles', [CycleApiController::class, 'getAll']);
