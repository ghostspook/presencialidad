<?php

namespace App\Http\Controllers;

use App\Models\AccountType;
use App\Models\TrackedAccount;
use App\Models\Transition;
use App\Models\User;
use App\Models\UserCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackedAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = TrackedAccount::orderBy('email')->get();
        $accountTypes = AccountType::all();

        return view('trackedaccounts.index', ['accounts' => $accounts, 'accountTypes' => $accountTypes]);
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
        $inputs = $request->all();
        TrackedAccount::create([ 'email' => $inputs['email'], 'account_type_id' => $inputs['account_type_id']]);
        return redirect()->route('trackedaccounts_index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('trackedaccounts.show', ['user' => $user ]);
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

    public function transitionToState(Request $request)
    {
        $inputs = $request->all();

        $c = UserCard::firstWhere('user_id', $inputs['user_id']);
        $c->state = $inputs['state'];
        $c->save();
        $t = Transition::create([
            'user_id' => $inputs['user_id'],
            'state' => $inputs['state'],
            'actor' => Auth::user()->name,
        ]);

        return redirect()->route('trackedaccounts_show', ['id' => $inputs['user_id']]);
    }
}
