<?php

use App\Http\Controllers\AdvicedNotToAttendController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuthorizationController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\QuestionnaireOneController;
use App\Http\Controllers\TestResultController;
use App\Http\Controllers\QuestionnaireTwoController;
use App\Http\Controllers\PreemptiveQuarantineController;
use App\Http\Controllers\TrackedAccountController;
use App\Http\Middleware\AdvicedNotToAttend;
use App\Http\Middleware\Authorized;
use App\Http\Middleware\CanEnterTestResults;
use App\Http\Middleware\PendingEnrollment;
use App\Http\Middleware\PendingQuestionnaireOne;
use App\Http\Middleware\PendingQuestionnaireTwo;
use App\Http\Middleware\PreemptiveQuarantine;

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
Route::get('aceptacion', [ EnrollmentController::class, 'index'])->name('enrollment')->middleware('auth:web', PendingEnrollment::class);
Route::post('enrollsubmit', [ EnrollmentController::class, 'enrollSubmit'])->middleware('auth:web', PendingEnrollment::class);
Route::get('cuestionariohabilitante', [ QuestionnaireOneController::class, 'index'])->name('questionnarieone')->middleware('auth:web', PendingQuestionnaireOne::class);
Route::post('questionnaireonesubmit', [ QuestionnaireOneController::class, 'questionnaireSubmit'])->name('questionnaireOneSubmit')->middleware('auth:web', PendingQuestionnaireOne::class);
Route::get('recomendacion', [AdvicedNotToAttendController::class, 'index'])->name('advicedNotToAttend')->middleware('auth:web', AdvicedNotToAttend::class);
Route::post('submitdontfollowadvice', [ AdvicedNotToAttendController::class, 'submitDecisionToAttend'])->name('submitDontFollowAdvice')->middleware('auth:web', AdvicedNotToAttend::class);
Route::get('pruebas/pendientes', [TestResultController::class, 'listUsersPendingTests'])->name('enterTestResults')->middleware('auth:web', CanEnterTestResults::class);
Route::get('usuarios/{userId}/resultados/nuevo', [TestResultController::class, 'newTestResult'])->name('newtestresult')->middleware('auth:web', CanEnterTestResults::class);
Route::post('usuarios/resultados/nuevo/submit', [ TestResultController::class, 'newTestResultSubmit'])->name('newtestresultsubmit')->middleware('auth:web', CanEnterTestResults::class);
Route::get('cuestionardeautorizacion', [ QuestionnaireTwoController::class, 'index'])->name('questionnarieTwo')->middleware('auth:web', PendingQuestionnaireTwo::class);
Route::post('questionnairetwosubmit', [ QuestionnaireTwoController::class, 'questionnaireSubmit'])->name('questionnaireTwoSubmit')->middleware('auth:web', PendingQuestionnaireTwo::class);
Route::get('autorizaciones/vigente', [ AuthorizationController::class, 'showValidAuthorization'])->name('showValidAuthorization')->middleware('auth:web', Authorized::class);
Route::get('cuarentenapreventiva', [PreemptiveQuarantineController::class, 'index'])->name('preemptiveQuarantine')->middleware('auth:web', PreemptiveQuarantine::class);
Route::get('cuentas', [TrackedAccountController::class, 'index'])->name('trackedaccounts_index')->middleware('auth:web', CanEnterTestResults::class);
Route::get('cuentas/{id}', [TrackedAccountController::class, 'show'])->name('trackedaccounts_show')->middleware('auth:web', CanEnterTestResults::class);
Route::post('cuentas/store', [TrackedAccountController::class, 'store'])->name('trackedaccount_store')->middleware('auth:web', CanEnterTestResults::class);
Route::post('transitions/create', [TrackedAccountController::class, 'transitionToState'])->name('trackedaccount_transition')->middleware('auth:web', CanEnterTestResults::class);


