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
Route::get('/active/{id}',[\App\Http\Controllers\Api\UserApiController::class,'active']);
//la ruta de abajo es para pillar el estudiante
Route::get('student/{id}', [\App\Http\Controllers\Api\StudentApiController::class, 'getStudent']);
Route::get('cycles', [CycleApiController::class, 'getAll']);
//la ruta para comprobar el email
Route::delete('offersDelete/{id}', [\App\Http\Controllers\Api\OfferApiController::class, 'delete']);
Route::put('/offersDeactivate/{id}', [\App\Http\Controllers\Api\OfferApiController::class, 'deactivate']);
Route::get('checkEmail/{email}',[\App\Http\Controllers\Api\UserApiController::class,'checkEmail']);
Route::get('checkCIF/{CIF}',[\App\Http\Controllers\Api\CompanyApiController::class,'checkCIF']);
Route::get('company/{id}', [\App\Http\Controllers\Api\CompanyApiController::class, 'getCompany']);
Route::get('/verificated/{id}',[\App\Http\Controllers\Api\StudentApiController::class, 'verificated']);
Route::get('/sendEmail/{email}',[\App\Http\Controllers\Api\UserApiController::class,'sendEmail']);
Route::get('/verificateOffer/{idOffer}',[\App\Http\Controllers\Api\OfferApiController::class,'verificate']);
Route::get('/spread/{idOffer}',[\App\Http\Controllers\Api\OfferApiController::class,'spread']);
Route::middleware('auth:sanctum')->group( function () {
    Route::get('companyCIF/{CIF}', [\App\Http\Controllers\Api\CompanyApiController::class, 'getCompanyCIF']);
    Route::get('userOffert/{id}',[\App\Http\Controllers\Api\StudentApiController::class,'showUserApplie'])->middleware('rol:COMP');
    Route::post('apply/{idOffer}',[\App\Http\Controllers\Api\StudentApiController::class,'signUp'])->middleware('rol:STU');
    Route::apiResource('company',\App\Http\Controllers\Api\CompanyApiController::class)->middleware('rol:ADM,RESP,COMP');
    Route::delete('student/delete/{id}',[\App\Http\Controllers\Api\UserApiController::class, 'delete'])->middleware('rol:ADM,RESP,STU');
    Route::apiResource('responsible',\App\Http\Controllers\Api\UserApiController::class)->middleware('rol:RESP');
    Route::get('validate/{id}',[\App\Http\Controllers\Api\OfferApiController::class, 'validate'])->middleware('rol:ADM,RESP');
    Route::apiResource('students', \App\Http\Controllers\Api\StudentApiController::class)->middleware('rol:ADM,STU');
    Route::apiResource('users', \App\Http\Controllers\Api\UserApiController::class)->middleware('rol:ADM');
    Route::apiResource('offers', \App\Http\Controllers\Api\OfferApiController::class)->middleware('rol:ADM,COMP,STU,RESP');
    Route::get('user/student ',[\App\Http\Controllers\Api\StudentApiController::class, 'show'])->middleware('rol:STU,RESP,ADM');
    Route::put('user/student/update/{id}', [\App\Http\Controllers\Api\StudentApiController::class, 'update'])->middleware('rol:STU,RESP,ADM');
    Route::get('user/company ',[\App\Http\Controllers\Api\CompanyApiController::class, 'show'])->middleware('rol:COMP,RESP,ADM');
    Route::put('user/company/update/{id}', [\App\Http\Controllers\Api\CompanyApiController::class, 'update'])->middleware('rol:COMP,RESP,ADM');
    Route::get('offerByCP/{cp}',[\App\Http\Controllers\Api\OfferApiController::class,'getOfferByCP'])->middleware('rol:STU,COMP');
    Route::get('studentEmail/{email}', [\App\Http\Controllers\Api\StudentApiController::class, 'getStudentByEmail']);
    Route::delete('studentDelete/{id}', [\App\Http\Controllers\Api\StudentApiController::class, 'delete']);
    Route::get('studentCicles/{id}',[\App\Http\Controllers\Api\StudentApiController::class,'getCycleByStudent']);
    Route::get('companyEmail/{email}', [\App\Http\Controllers\Api\CompanyApiController::class, 'getCompanyByEmail']);
    Route::delete('companyDelete/{id}', [\App\Http\Controllers\Api\CompanyApiController::class, 'delete']);
});

