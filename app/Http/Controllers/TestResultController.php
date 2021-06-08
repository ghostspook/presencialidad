<?php

namespace App\Http\Controllers;

use App\Models\TestResult;
use App\Models\TestResultComment;
use App\Models\TestResultFile;
use App\Models\Transition;
use App\Models\UserCard;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class TestResultController extends Controller
{
    public function listUsersPendingTests()
    {
        return view('userspendingtests');
    }

    public function dataTable(Request $request)
    {
        $cards = UserCard::where('state', UserCard::PENDING_COVERED_TEST_1)
                ->orWhere('state', UserCard::PENDING_COVERED_TEST_2)
                ->orWhere('requires_maintenance_test', 1)
                ->get();

        return Datatables::of($cards)
            ->addColumn('action', function($c) {
                return '<a href="'.route('newtestresult', $c->user_id).'">'
                    .$c->user->name.'</a>';
            })
            ->addColumn('email', function($c) {
                return $c->user->email;
            })
            ->addColumn('group_name', function($c) {
                if ($c->user->trackedAccount->group_id)
                {
                    return $c->user->trackedAccount->group->name;
                }
                return '-';
            })
            ->addColumn('state', function($c) {
                if ($c->requires_maintenance_test){
                    return "Requiere prueba mantenimiento";
                }
                return $c->user->userCard->getStateText();
            })
            ->make(true);
    }

    public function newTestResult($userId, Request $request)
    {
        $inputs = $request->all();
        if (array_key_exists('returnTo', $inputs) && $inputs['returnTo'] == 'cuenta') {
            $returnTo = 'cuenta';
        } else {
            $returnTo = '';
        }
        $card = UserCard::firstWhere('user_id', $userId);
        return view('newtestresult', ['card' => $card, 'returnTo' => $returnTo]);
    }

    public function newTestResultSubmit(Request $request)
    {

        $request->validate([
            'test_type' => 'required',
            'result' => 'required',
            'test_date' => 'required|date',
        ]);

        $input = $request->all();

        if ($input['test_type'] != '1' && $input['test_type'] != '2' && $input['test_type'] != '3' && $input['test_type'] != '4') {
            return redirect()->back()->withErrors([ 'test_type' => 'Respuesta no permitida' ]);
        }

        if ($input['result'] != '1' && $input['result'] != '2') {
            return redirect()->back()->withErrors([ 'result' => 'Respuesta no permitida' ]);
        }

        if ($input['test_date'] > Carbon::now())
        {
            return redirect()->back()->withErrors([ 'test_date' => 'La fecha de la prueba no puede ser en el futuro.' ]);
        }

        $input = $request->all();
        $c = UserCard::firstWhere('user_id', $input['user_id']);
        $from_state = $c->state;

        TestResult::create(['user_id' => $input['user_id'],
                            'test_type' => $input['test_type'],
                            'result' => $input['result'],
                            'test_date' => $input['test_date'],
                            'added_by' => Auth::user()->name ]);

        if ($input['test_type'] == 1 || $input['test_type'] == 3) // PRUEBA RÁPIDA O CUANTITATIVA
        {
            if($input['result'] == 1) // NEGATIVO
            {
                $c->most_recent_negative_test_result_at = $input['test_date'];
                $c->next_test_result_due_date = $c->most_recent_negative_test_result_at->addDays(env('MAX_DAYS_BEFORE_NEW_TEST_REQUIRED'));
                if ($c->state == UserCard::PENDING_COVERED_TEST_1)
                {
                    if ($c->required_initial_test_count == 2)
                    {
                        $c->state = UserCard::PENDING_COVERED_TEST_2;
                    } else {
                        $c->state = UserCard::PENDING_QUESTIONNAIRE_2;
                    }
                } elseif ($c->state == UserCard::PENDING_COVERED_TEST_2) {
                    $c->state = UserCard::PENDING_QUESTIONNAIRE_2;
                } elseif ($c->state == UserCard::PENDING_NON_COVERED_TEST) {
                    $c->state = UserCard::PENDING_QUESTIONNAIRE_2;
                }
            }
            else // PRUEBA SALIÓ POSITIVA
            {
                if ($c->state == UserCard::PENDING_NON_COVERED_TEST) {
                    $c->state = UserCard::MANDATORY_QUARANTINE;
                    $c->mandatorily_quarantined_at = $input['test_date'];
                } else {
                    $c->state = UserCard::PENDING_PCR_TEST;
                }
            }

        } else { // PRUEBA PCR O DE ANTÍGENOS
            if($input['result'] == 1) // NEGATIVO
            {
                $c->most_recent_negative_test_result_at = $input['test_date'];
                $c->next_test_result_due_date = $c->most_recent_negative_test_result_at->addDays(env('MAX_DAYS_BEFORE_NEW_TEST_REQUIRED'));
                $c->state = UserCard::PENDING_QUESTIONNAIRE_2;
            } else // PRUEBA SALIÓ POSITIVA
            {
                $c->state = UserCard::MANDATORY_QUARANTINE;
                $c->mandatorily_quarantined_at = $input['test_date'];
            }
        }

        $c->requires_maintenance_test = 0;
        $c->save();

        Transition::create([ 'user_id' => $c->user_id,
                             'state' => $c->state,
                             'actor' => $c->user->name,
                             'from_state' => $from_state ]);

        if ($input['returnTo'] && $input['returnTo'] == 'cuenta') {
            $returnTo = route('trackedaccounts_show', ['id' => $c->user->id ]);
        } else {
            $returnTo = route('enterTestResults');
        }

        return redirect()->to($returnTo);
    }

    function show($id)
    {
        $testResult = TestResult::find($id);
        return view('testresults.show', [ 'tr' => $testResult ]);
    }

    function uploadFile(Request $request)
    {
        $inputs = $request->all();
        $file = $request->file('test_file');

        $path = 'test-results/'.time().'-tr-'.$inputs['id'];

        $t = Storage::disk('do_spaces')->put($path , file_get_contents($file));

        TestResultFile::create([
            'test_result_id' => $inputs['id'],
            'filename' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType(),
            'created_by' => Auth::user()->name,
            'path' => $path
        ]);

        return redirect()->route('testresults_show', [ 'id' => $inputs['id'] ]);
    }

    function downloadFile($id)
    {
        $f = TestResult::find($id)->file;
        $contents = Storage::disk('do_spaces')->get($f->path);

        $headers = [
            'Content-Type' => $f->mime_type,
            'Content-Description' => 'File Transfer',
            'Content-Disposition' => "attachment; filename=".$f->filename,
            'filename'=> $f->filename,
        ];

        return response($contents, 200, $headers);
    }

    function postComment(Request $request)
    {
        $input = $request->all();

        TestResultComment::create([
            'test_result_id' => $input['test_result_id'],
            'comment_text' => $input['comment_text'],
            'added_by' => Auth::user()->name,
        ]);

        return redirect()->route('testresults_show', [ 'id' => $input['test_result_id'] ]);
    }
}
