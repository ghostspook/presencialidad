<?php

namespace App\Http\Controllers;

use App\Http\BatchTransitioner;
use App\Models\AccountType;
use App\Models\Group;
use App\Models\TrackedAccount;
use App\Models\Transition;
use App\Models\TransitionComment;
use App\Models\User;
use App\Models\UserCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class TrackedAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accountTypes = AccountType::all();
        $groups = Group::all();

        return view('trackedaccounts.index', [
                'accountTypes' => $accountTypes,
                'groups' => $groups,
            ]);
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
        TrackedAccount::create([
                'email' => $inputs['email'],
                'account_type_id' => $inputs['account_type_id'],
                'group_id' => $inputs['group_id'] == '-' ? null : $inputs['group_id'],
            ]);
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
        $request->validate([
            'state' => [
                'required',
                Rule::in([ 1, 2, 4, 5, 10, 11 ]),
            ],
            'comment_text' => 'required',
        ]);

        $inputs = $request->all();

        $c = UserCard::firstWhere('user_id', $inputs['user_id']);
        $from_state = $c->state;
        $c->state = $inputs['state'];
        $c->save();
        $t = Transition::create([
            'user_id' => $inputs['user_id'],
            'state' => $inputs['state'],
            'actor' => Auth::user()->name,
            'from_state' => $from_state,
        ]);
        TransitionComment::create([
            'transition_id' => $t->id,
            'comment_text' => $inputs['comment_text']
        ]);

        return redirect()->route('trackedaccounts_show', ['id' => $inputs['user_id']]);
    }

    public function dataTable(Request $request)
    {
        $accounts = TrackedAccount::all();
        return Datatables::of($accounts)
            ->addColumn('action', function($a) {
                if ($a->user){
                    return '<a href="'.route('trackedaccounts_show', $a->user->id).'">'
                    .$a->email.'</a>';
                }
                return $a->email;
            })
            ->addColumn('type', function($a) {
                return $a->accountType->name;
            })
            ->addColumn('name', function($a) {
                if ($a->user)
                {
                    return $a->user->name;
                }
                else{
                    return '-';
                }
            })
            ->addColumn('groupname', function($a) {
                if ($a->group_id)
                {
                    return $a->group->name;
                }
                else{
                    return '-';
                }
            })
            ->addColumn('state', function($a) {
                if ($a->user && $a->user->userCard)
                {
                    return $a->user->userCard->getStateText();
                }
                else{
                    return '-';
                }
            })
            ->make(true);
    }
}
