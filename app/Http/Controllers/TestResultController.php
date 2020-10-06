<?php

namespace App\Http\Controllers;

use App\Models\TestResult;
use App\Models\TestResultFile;
use App\Models\Transition;
use App\Models\UserCard;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TestResultController extends Controller
{
    public function listUsersPendingTests()
    {
        $cards = UserCard::where('state', UserCard::PENDING_COVERED_TEST_1)->orWhere('state', UserCard::PENDING_COVERED_TEST_2)->get();
        return view('userspendingtests', ['cards' => $cards]);
    }

    public function newTestResult($userId)
    {
        $card = UserCard::firstWhere('user_id', $userId);
        return view('newtestresult', ['card' => $card]);
    }

    public function newTestResultSubmit(Request $request)
    {

        $request->validate([
            'test_type' => 'required',
            'result' => 'required',
            'test_date' => 'required|date',
        ]);

        $input = $request->all();

        if ($input['test_type'] != '1' && $input['test_type'] != '2') {
            return redirect()->back()->withErrors([ 'test_type' => 'Respuesta no permitida' ]);
        }

        if ($input['result'] != '1' && $input['result'] != '2') {
            return redirect()->back()->withErrors([ 'result' => 'Respuesta no permitida' ]);
        }

        $input = $request->all();
        $c = UserCard::firstWhere('user_id', $input['user_id']);

        TestResult::create(['user_id' => $input['user_id'],
                            'test_type' => $input['test_type'],
                            'result' => $input['result'],
                            'test_date' => $input['test_date'],
                            'added_by' => Auth::user()->name ]);

        if ($input['test_type'] == 1) // PRUEBA RÁPIDA
        {
            if($input['result'] == 1) // NEGATIVO
            {
                $c->most_recent_negative_test_result_at = $input['test_date'];
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
                if ($c->state == UserCard::PENDING_COVERED_TEST_1 || $c->state == UserCard::PENDING_COVERED_TEST_2) {
                    $c->state = UserCard::PENDING_PCR_TEST;
                } elseif ($c->state == UserCard::PENDING_NON_COVERED_TEST) {
                    $c->state = UserCard::MANDATORY_QUARANTINE;
                    $c->mandatorily_quarantined_at = $input['test_date'];
                }
            }

            if ($input['test_type'] == 2) // PRUEBA PCR
            {
                if($input['result'] == 1) // NEGATIVO
                {
                    $c->most_recent_negative_test_result_at = $input['test_date'];
                    $c->state = UserCard::PENDING_QUESTIONNAIRE_2;
                } else // PRUEBA SALIÓ POSITIVA
                {
                    $c->state = UserCard::MANDATORY_QUARANTINE;
                    $c->mandatorily_quarantined_at = $input['test_date'];
                }
            }
            $c->save();

            Transition::create([ 'user_id' => $c->user_id,
                                 'state' => $c->state,
                                 'actor' => $c->user->name ]);
        }

        return redirect()->route('enterTestResults');
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
}
