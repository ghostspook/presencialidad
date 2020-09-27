<?php

use App\Http\Controllers\AdvicedNotToAttendController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuthorizationController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\QuestionnaireOneController;
use App\Http\Controllers\TestOneController;
use App\Http\Controllers\TestTwoController;
use App\Http\Controllers\TestResultController;
use App\Http\Controllers\QuestionnaireTwoController;
use App\Http\Controllers\PreemptiveQuarantineController;

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
Route::get('aceptacion', [ EnrollmentController::class, 'index'])->name('enrollment')->middleware('auth:web');
Route::post('enrollsubmit', [ EnrollmentController::class, 'enrollSubmit'])->middleware('auth:web');
Route::get('cuestionariohabilitante', [ QuestionnaireOneController::class, 'index'])->name('questionnarieone')->middleware('auth:web');
Route::post('questionnaireonesubmit', [ QuestionnaireOneController::class, 'questionnaireSubmit'])->name('questionnaireOneSubmit')->middleware('auth:web');
Route::get('recomendacion', [AdvicedNotToAttendController::class, 'index'])->name('advicedNotToAttend')->middleware('auth:web');
Route::get('pruebarapida1', [TestOneController::class, 'index'])->name('testOne')->middleware('auth:web');
Route::get('pruebarapida2', [TestTwoController::class, 'index'])->name('testTwo')->middleware('auth:web');
Route::get('pruebas/pendientes', [TestResultController::class, 'listUsersPendingTests'])->name('enterTestResults')->middleware('auth:web');
Route::get('usuarios/{userId}/resultados/nuevo', [TestResultController::class, 'newTestResult'])->name('newtestresult')->middleware('auth:web');
Route::post('usuarios/resultados/nuevo/submit', [ TestResultController::class, 'newTestResultSubmit'])->name('newtestresultsubmit')->middleware('auth:web');
Route::get('cuestionardeautorizacion', [ QuestionnaireTwoController::class, 'index'])->name('questionnarieTwo')->middleware('auth:web');
Route::post('questionnairetwosubmit', [ QuestionnaireTwoController::class, 'questionnaireSubmit'])->name('questionnaireTwoSubmit')->middleware('auth:web');
Route::get('autorizaciones/vigente', [ AuthorizationController::class, 'showValidAuthorization'])->name('showValidAuthorization')->middleware('auth:web');
Route::get('cuarentenapreventiva', [PreemptiveQuarantineController::class, 'index'])->name('preemptiveQuarantine')->middleware('auth:web');


