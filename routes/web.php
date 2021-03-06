<?php

use App\Http\Controllers\AccessReportController;
use App\Http\Controllers\AdvicedNotToAttendController;
use App\Http\Controllers\AnswerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuthorizationController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\ExtensionController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MandatoryQuarantineController;
use App\Http\Controllers\MyTestResultController;
use App\Http\Controllers\MyVaccionationController;
use App\Http\Controllers\PCRTestController;
use App\Http\Controllers\QuestionnaireOneController;
use App\Http\Controllers\TestResultController;
use App\Http\Controllers\QuestionnaireTwoController;
use App\Http\Controllers\PreemptiveQuarantineController;
use App\Http\Controllers\QrScannerController;
use App\Http\Controllers\TrackedAccountController;
use App\Http\Controllers\VaccinationController;
use App\Http\Middleware\AdvicedNotToAttend;
use App\Http\Middleware\Authorized;
use App\Http\Middleware\CanAnswerQuestionnaire2;
use App\Http\Middleware\CanEnterTestResults;
use App\Http\Middleware\CanManageGroups;
use App\Http\Middleware\CanReadAccessReport;
use App\Http\Middleware\CanScanQr;
use App\Http\Middleware\MandatoryQuarantine;
use App\Http\Middleware\PendingEnrollment;
use App\Http\Middleware\PendingPCRTest;
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
Route::get('resultados', [ MyTestResultController::class, 'index'])->name('myTestResults_index')->middleware('auth:web');
Route::get('resultados/{id}/descargar', [ MyTestResultController::class, 'downloadFile'])->name('myTestResults_download')->middleware('auth:web');
Route::get('vacunas', [ MyVaccionationController::class, 'index'])->name('myvaccinations.index')->middleware('auth:web');
Route::get('vacunas/{id}/descargar', [ MyVaccionationController::class, 'downloadFile'])->name('myvaccinations.download')->middleware('auth:web');
Route::get('recomendacion', [AdvicedNotToAttendController::class, 'index'])->name('advicedNotToAttend')->middleware('auth:web', AdvicedNotToAttend::class);
Route::post('submitdontfollowadvice', [ AdvicedNotToAttendController::class, 'submitDecisionToAttend'])->name('submitDontFollowAdvice')->middleware('auth:web', AdvicedNotToAttend::class);
Route::get('pruebas/pendientes', [TestResultController::class, 'listUsersPendingTests'])->name('enterTestResults')->middleware('auth:web', CanEnterTestResults::class);
Route::get('pruebas/pendientes/datatables', [TestResultController::class, 'dataTable'])->name('pendingTests_datatables')->middleware('auth:web', CanEnterTestResults::class);
Route::get('usuarios/{userId}/resultados/nuevo', [TestResultController::class, 'newTestResult'])->name('newtestresult')->middleware('auth:web', CanEnterTestResults::class);
Route::post('usuarios/resultados/nuevo/submit', [ TestResultController::class, 'newTestResultSubmit'])->name('newtestresultsubmit')->middleware('auth:web', CanEnterTestResults::class);
Route::get('usuarios/{userId}/vacunaciones/nueva', [VaccinationController::class, 'create'])->name('vaccination_create')->middleware('auth:web', CanEnterTestResults::class);
Route::post('usuarios/vacunaciones/nuevo/submit', [ VaccinationController::class, 'store'])->name('vaccination_store')->middleware('auth:web', CanEnterTestResults::class);
Route::get('cuestionardeautorizacion', [ QuestionnaireTwoController::class, 'index'])->name('questionnarieTwo')->middleware('auth:web', CanAnswerQuestionnaire2::class);
Route::get('vacunaciones/{id}', [VaccinationController::class, 'show'])->name('vaccination_show')->middleware('auth:web', CanEnterTestResults::class);
Route::get('vacunaciones/{id}/descargar', [ VaccinationController::class, 'downloadFile'])->name('vaccination_download')->middleware('auth:web');
Route::post('vacunaciones/uploadfile', [VaccinationController::class, 'uploadFile'])->name('vaccination_uploadfile')->middleware('auth:web', CanEnterTestResults::class);
Route::post('questionnairetwosubmit', [ QuestionnaireTwoController::class, 'questionnaireSubmit'])->name('questionnaireTwoSubmit')->middleware('auth:web', CanAnswerQuestionnaire2::class);
Route::get('autorizaciones/vigente', [ AuthorizationController::class, 'showValidAuthorization'])->name('showValidAuthorization')->middleware('auth:web', Authorized::class);
Route::get('cuarentenapreventiva', [PreemptiveQuarantineController::class, 'index'])->name('preemptiveQuarantine')->middleware('auth:web', PreemptiveQuarantine::class);
Route::get('cuentas', [TrackedAccountController::class, 'index'])->name('trackedaccounts_index')->middleware('auth:web', CanEnterTestResults::class);
Route::get('cuentas/datatables', [TrackedAccountController::class, 'dataTable'])->name('trackedaccounts_datatables')->middleware('auth:web', CanEnterTestResults::class);
Route::get('cuentas/{id}', [TrackedAccountController::class, 'show'])->name('trackedaccounts_show')->middleware('auth:web', CanEnterTestResults::class);
Route::get('pruebas/{id}', [TestResultController::class, 'show'])->name('testresults_show')->middleware('auth:web', CanEnterTestResults::class);
Route::post('pruebas/comentario', [ TestResultController::class, 'postComment'])->name('testresults_postcomment')->middleware('auth:web', CanEnterTestResults::class);
Route::get('pruebas/{id}/download', [TestResultController::class, 'downloadFile'])->name('testresults_download')->middleware('auth:web', CanEnterTestResults::class);
Route::post('pruebas/uploadfile', [TestResultController::class, 'uploadFile'])->name('testresults_uploadfile')->middleware('auth:web', CanEnterTestResults::class);
Route::post('cuentas/store', [TrackedAccountController::class, 'store'])->name('trackedaccount_store')->middleware('auth:web', CanEnterTestResults::class);
Route::post('transitions/create', [TrackedAccountController::class, 'transitionToState'])->name('trackedaccount_transition')->middleware('auth:web', CanEnterTestResults::class);
Route::get('respuesta/{id}', [AnswerController::class, 'show'])->name('answer_show')->middleware('auth:web', CanEnterTestResults::class);
Route::get('pruebapcr', [PCRTestController::class, 'index'])->name('pcrtest_create')->middleware('auth:web', PendingPCRTest::class);
Route::get('cuarentenamandatoria', [MandatoryQuarantineController::class, 'index'])->name('mandatoryQuarantine')->middleware('auth:web', MandatoryQuarantine::class);
Route::get('qrscanner', [QrScannerController::class, 'index'])->name('qrScanner')->middleware('auth:web', CanScanQr::class);
Route::get('qrscanner/checkauthorization/{code}', [QrScannerController::class, 'checkAuthorization'])->name('checkAuthorization')->middleware('auth:web', CanScanQr::class);
Route::get('controldeacceso', [AccessReportController::class, 'index'])->name('accessReport_index')->middleware('auth:web', CanReadAccessReport::class);
Route::post('controldeacceso/query', [AccessReportController::class, 'postQueryCriteria'])->name('accessReport_query')->middleware('auth:web', CanReadAccessReport::class);
Route::get('controldeacceso/{date}', [AccessReportController::class, 'showReport'])->name('accessReport_showReport')->middleware('auth:web', CanReadAccessReport::class);
Route::get('controldeacceso/{date}/datatables', [AccessReportController::class, 'dataTable'])->name('accessReport_datatables')->middleware('auth:web', CanReadAccessReport::class);
Route::get('groups', [GroupController::class, 'index'])->name('groups.index')->middleware('auth:web', CanEnterTestResults::class);
Route::get('groups/create', [GroupController::class, 'create'])->name('groups.create')->middleware('auth:web', CanManageGroups::class);
Route::post('groups', [GroupController::class, 'store'])->name('groups.store')->middleware('auth:web', CanManageGroups::class);
Route::get('groups/datatable', [GroupController::class, 'dataTable'])->name('groups.datatable')->middleware('auth:web', CanEnterTestResults::class);
Route::get('groups/{group}', [GroupController::class, 'show'])->name('groups.show')->middleware('auth:web', CanEnterTestResults::class);
Route::get('groups/{group}/edit', [GroupController::class, 'edit'])->name('groups.edit')->middleware('auth:web', CanManageGroups::class);
Route::put('groups/{group}', [GroupController::class, 'update'])->name('groups.update')->middleware('auth:web', CanManageGroups::class);
Route::get('groups/{id}/users', [GroupController::class, 'usersDataTable'])->name('groups.users.datatable')->middleware('auth:web', CanEnterTestResults::class);
Route::get('cuentas/{user_id}/extender', [ExtensionController::class, 'create'])->name('extensions.create')->middleware('auth:web', CanEnterTestResults::class);
Route::post('extensions', [ExtensionController::class, 'store'])->name('extensions.store')->middleware('auth:web', CanEnterTestResults::class);



