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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $request->validate([
            'email' => 'required|unique:tracked_accounts',
        ]);

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
        $sqlQuery =
            "SELECT tracked_accounts.email as email,
                account_types.name as account_type_name,
                users.id as user_id,
                users.name as user_name,
                `groups`.name as group_name,
                user_cards.state as user_state,
                user_cards.next_test_result_due_date as next_test_result_due_date
            FROM tracked_accounts
                inner join account_types on tracked_accounts.account_type_id = account_types.id
                left join users on tracked_accounts.id =  users.tracked_account_id
                left join `groups` on tracked_accounts.group_id = `groups`.id
                left join user_cards on users.id = user_cards.user_id";

        $accounts = DB::select($sqlQuery);
        return Datatables::of($accounts)
            ->addColumn('action', function($a) {
                if ($a->user_id){
                    return '<a href="'.route('trackedaccounts_show', $a->user_id).'">'
                    .$a->email.'</a>';
                }
                return $a->email;
            })
            ->addColumn('state_text', function($a) {
                if (!$a->user_state) {
                    return '-';
                }

                switch ($a->user_state)
                {
                    case UserCard::PENDING_ENROLLMENT:
                        return "Pendiente aceptación de términos";
                    case UserCard::PENDING_QUESTIONNAIRE_1:
                        return "Pendiente cuestionario 1";
                    case UserCard::ADVICED_NOT_TO_ATTEND:
                        return "Recomendación de no asistir";
                    case UserCard::PENDING_COVERED_TEST_1:
                        return "Pendiente prueba rápida 1";
                    case UserCard::PENDING_COVERED_TEST_2:
                        return "Pendiente prueba rápida 2";
                    case UserCard::PENDING_PCR_TEST:
                        return "Pendiente prueba PCR";
                    case UserCard::PENDING_QUESTIONNAIRE_2:
                        return "Pendiente cuestionario 2";
                    case UserCard::PREEMPTIVE_QUARANTINE:
                        return "Aislamiento preventivo";
                    case UserCard::AUTHORIZED:
                        return "Autorizado/a";
                    case UserCard::PENDING_PCR_TEST:
                        return 'Pendiente prueba PCR';
                    case UserCard::MANDATORY_QUARANTINE:
                        return 'Cuarentena mandatoria';
                    default:
                        return "?";
                }
            })
            ->addColumn('next_test_due_for', function($a) {
                return (!$a->next_test_result_due_date)
                    ? '-'
                    : Carbon::createFromTimeString($a->next_test_result_due_date)
                        ->addDays(-5)->format('Y-m-d');
            })
            ->make(true);
    }
}
