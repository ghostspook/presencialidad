<?php

namespace App\Http\Controllers;

use App\Models\UserCard;
use App\Models\Vaccination;
use App\Models\VaccinationFile;
use App\Models\VaccineType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VaccinationController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($userId, Request $request)
    {
        $inputs = $request->all();
        if (array_key_exists('returnTo', $inputs) && $inputs['returnTo'] == 'cuenta') {
            $returnTo = 'cuenta';
        } else {
            $returnTo = '';
        }
        $card = UserCard::firstWhere('user_id', $userId);
        $vaccineTypes = VaccineType::all();
        return view('vaccinations.create', [
            'card' => $card,
            'returnTo' => $returnTo,
            'vaccineTypes' => $vaccineTypes,
        ]);
    }

    function show($id)
    {
        $v = Vaccination::find($id);
        return view('vaccinations.show', [ 'v' => $v ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'vaccine_type_id' => 'required',
            'vaccinated_date' => 'required|date',
        ]);

        $input = $request->all();

        if ($input['vaccinated_date'] > Carbon::now())
        {
            return redirect()->back()->withErrors([ 'vaccinated_date' => 'La fecha de vacunación no puede ser en el futuro.' ]);
        }

        $v = Vaccination::create([
            'user_id' => $input['user_id'],
            'vaccine_type_id' => $input['vaccine_type_id'],
            'vaccinated_date' => $input['vaccinated_date'],
            'added_by' => Auth::user()->name,
            'comments' => $input['comments'],
        ]);

        $tentativeNextTestDate = $v->vaccinated_date->addDays(env('MAX_DAYS_BEFORE_NEW_TEST_REQUIRED'));

        $card = UserCard::firstWhere('id', $input['user_id']);
        if (!$card->next_test_result_due_date) {
            $card->next_test_result_due_date = $tentativeNextTestDate;
        } else if ($tentativeNextTestDate->isAfter($card->next_test_result_due_date)) {
            $card->next_test_result_due_date = $tentativeNextTestDate;
        }

        if ($card->next_test_result_due_date->isFuture())
        if ($card->state == UserCard::PENDING_COVERED_TEST_1
            || $card->state == UserCard::PENDING_COVERED_TEST_2
            || $card->state == UserCard::PENDING_NON_COVERED_TEST)
        {
            $card->state = UserCard::PENDING_QUESTIONNAIRE_2;
        }

        $card->requires_maintenance_test = !$card->next_test_result_due_date->addDays(-env('DAYS_BEFORE_NEXT_TEST_WARNING'))->isFuture();

        $card->save();

        $returnTo = route('trackedaccounts_show', ['id' => $input['user_id'] ]);

        return redirect()->to($returnTo);
    }

    function uploadFile(Request $request)
    {
        $inputs = $request->all();
        $file = $request->file('test_file');

        $path = 'vaccinations/'.time().'-v-'.$inputs['id'];

        $t = Storage::disk('do_spaces')->put($path , file_get_contents($file));

        VaccinationFile::create([
            'vaccination_id' => $inputs['id'],
            'filename' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType(),
            'created_by' => Auth::user()->name,
            'path' => $path
        ]);

        return redirect()->route('vaccination_show', [ 'id' => $inputs['id'] ]);
    }

    function downloadFile($id)
    {
        $f = Vaccination::find($id)->file;
        $contents = Storage::disk('do_spaces')->get($f->path);

        $headers = [
            'Content-Type' => $f->mime_type,
            'Content-Description' => 'File Transfer',
            'Content-Disposition' => "attachment; filename=".$f->filename,
            'filename'=> $f->filename,
        ];

        return response($contents, 200, $headers);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
