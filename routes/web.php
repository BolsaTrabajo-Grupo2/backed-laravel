<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ResponsibleController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CycleController;
use Illuminate\Support\Facades\View;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/auth/github' , [\App\Http\Controllers\GitHubController::class, 'redirect'])->name('github.login');
Route::get('/auth/github/callback' , [\App\Http\Controllers\GitHubController::class, 'callback']);
Route::get('auth/google', [App\Http\Controllers\Auth\LoginController::class,'redirectToGoogle']);
Route::get('auth/google/callback', [App\Http\Controllers\Auth\LoginController::class,'handleGoogleCallback']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth:sanctum')->group( function () {
    Route::resource('student', StudentController::class)->middleware('rol:RESP,ADM');
    Route::resource('responsible', ResponsibleController::class)->middleware('rol:ADM');
    Route::resource('offer', OfferController::class)->middleware('rol:RESP,ADM');
    Route::resource('company', CompanyController::class)->middleware('rol:ADM');
    Route::get('/cycles', [CycleController::class, 'index'])->name('cycles.index')->middleware('rol:ADM');
    Route::get('/mod-responsible/{id}',[CycleController::class, 'modResponsible'])->name('modResponsible')->middleware('rol:ADM');
    Route::put('/updateResponsible/{id}',[CycleController::class, 'updateResponsible'])->name('updateResponsible')->middleware('rol:ADM');
    Route::get('cycles/statistics',[CycleController::class, 'statics'])->name('staticsCycles')->middleware('rol:ADM');
    Route::get('/offersStudent/{id}', [StudentController::class, 'offers'])->name('offersStudent')->middleware('rol:ADM,RESP');
    Route::get('/offerShow/{id}/{idStudent}', [StudentController::class, 'offerShow'])->name('offerShow')->middleware('rol:ADM,RESP');
    Route::get('/acceptStudent/{id}',[StudentController::class, 'accept'])->name('acceptStudent')->middleware('rol:RESP, ADM');
    Route::get('/acceptCompany/{id}',[CompanyController::class, 'accept'])->name('acceptCompany')->middleware('rol:ADM');
    Route::get('/acceptOffer/{id}',[OfferController::class, 'verificate'])->name('verifiedOffer')->middleware('rol:RESP, ADM');
});


Route::fallback(function () {
    return redirect()->route('login');
});

Route::get('/reset-password/{email}', [\App\Http\Controllers\ResetPasswordController::class,'showResetForm'])->name('password.reseteo');
Route::post('/password', [\App\Http\Controllers\ResetPasswordController::class, 'reset'])->name('password.actualizar');

require __DIR__.'/auth.php';
