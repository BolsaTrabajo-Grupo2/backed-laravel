<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ResponsibleController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CycleController;


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
    Route::resource('students', StudentController::class)->middleware('rol:RESP');
    Route::resource('responsible', ResponsibleController::class)->middleware('rol:ADM');
    Route::resource('offers', OfferController::class)->middleware('rol:RESP');
    Route::resource('companies', CompanyController::class)->middleware('rol:ADM');
    Route::get('/cycles', [CycleController::class, 'index'])->name('cycles.index')->middleware('rol:ADM');;
});

Route::fallback(function () {
    return redirect()->route('login');
});

require __DIR__.'/auth.php';
