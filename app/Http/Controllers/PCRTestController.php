<?php

namespace App\Http\Controllers;

use App\Models\TestResult;
use App\Models\Transition;
use App\Models\UserCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PCRTestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pcrtest.create');
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
            'result' => 'required',
            'test_date' => 'required|date',
        ]);

        $input = $request->all();

        if ($input['result'] != '1' && $input['result'] != '2') {
            return redirect()->back()->withErrors([ 'result' => 'Respuesta no permitida' ]);
        }

        $c = Auth::user()->userCard;
        $t = TestResult::create([
                            'user_id' => Auth::user()->id,
                            'test_type' => 2, //PCR
                            'result' => $input['result'],
                            'test_date' => $input['test_date'],
                            'added_by' => Auth::user()->name
        ]);

        if ($t->result == 1) // NEGATIVO
        {
            $c->state = UserCard::PENDING_QUESTIONNAIRE_2;
            $c->most_recent_negative_test_result_at = $t->test_date;
        }
        else
        {
            $c->state = UserCard::MANDATORY_QUARANTINE;
            $c->mandatorily_quarantined_at = $t->test_date;
        }
        $c->save();

        Transition::create([
            'user_id' => $c->user_id,
            'state' => $c->state,
            'actor' => Auth::user()->name
            ]);

        return redirect('/');
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
