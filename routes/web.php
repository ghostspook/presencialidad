<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EnrollmentController;

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

Route::get('login/google', [LoginController::class, 'redirectToProvider'])->name('login');
Route::get('login/google/callback', [LoginController::class, 'handleProviderCallback']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('cuentanohabilitada', [LoginController::class, 'displayCuentaNoHabilitada'])->name('cuentanohabilitada');

Route::get('/', [HomeController::class, 'index']);
Route::get('/aceptacion', [ EnrollmentController::class, 'index'])->name('enrollment');
Route::post('/enrollsubmit', [ EnrollmentController::class, 'enrollSubmit'] );
