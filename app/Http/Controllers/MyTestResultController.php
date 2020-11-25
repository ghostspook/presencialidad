<?php

namespace App\Http\Controllers;

use App\Models\TestResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MyTestResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $test_results = TestResult::where('user_id', Auth::user()->id)->get();
        $user = Auth::user();
        $displayNextTestResultDeadline = (
            $user->trackedAccount->account_type_id == 2 // profesores
            || $user->trackedAccount->account_type_id == 3 // administrativos
            || ($user->trackedAccount->group_id // group requires maintenance test
                && $user->trackedAccount->group->automatically_require_maintenance_test == 1)
        );
        $nextTestResultDeadline = $displayNextTestResultDeadline ?
            $user->userCard->most_recent_negative_test_result_at->addDays(env('MAX_DAYS_BEFORE_NEW_TEST_REQUIRED') - 5) :
            "";
        return view('mytestresults.index', [
                'test_results' => $test_results,
                'user' => $user,
                'displayNextTestResultDeadline' => $displayNextTestResultDeadline,
                'nextTestResultDeadline' => $nextTestResultDeadline,
        ]);
    }

    public function downloadFile($id)
    {
        $tr = TestResult::find($id);
        if (!$tr || $tr->user_id <> Auth::user()->id || !$tr->file)
        {
            return redirect()->to('/');
        }

        $f = $tr->file;
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
