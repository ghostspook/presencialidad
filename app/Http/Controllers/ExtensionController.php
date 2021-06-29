<?php

namespace App\Http\Controllers;

use App\Models\Extension;
use App\Models\User;
use App\Models\UserCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExtensionController extends Controller
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
    public function create($user_id)
    {
        $u = User::find($user_id);
        return view('extensions.create', ['user' => $u]);
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
            'user_id' => 'required|exists:users,id',
            'new_date' => 'required|date|after:today',
            'comments' => 'required',
        ]);

        $input = $request->all();

        $card = UserCard::firstWhere('user_id', $input['user_id']);
        $card->next_test_result_due_date = $input['new_date'];
        $card->save();

        Extension::create([
            'user_id' => $input['user_id'],
            'new_date' => $input['new_date'],
            'comments' => $input['comments'],
            'extended_by' => Auth::user()->name,
        ]);

        return redirect()->route('trackedaccounts_show', ['id' => $input['user_id']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Extension  $extension
     * @return \Illuminate\Http\Response
     */
    public function show(Extension $extension)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Extension  $extension
     * @return \Illuminate\Http\Response
     */
    public function edit(Extension $extension)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Extension  $extension
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Extension $extension)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Extension  $extension
     * @return \Illuminate\Http\Response
     */
    public function destroy(Extension $extension)
    {
        //
    }
}
