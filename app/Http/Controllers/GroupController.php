<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\UserCard;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('groups.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('groups.create');
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
            'name' => 'required|unique:groups',
            'default_required_initial_test_count' => 'required',
            'automatically_require_maintenance_test' => 'required',
        ]);

        $input = $request->all();

        Group::create([
            'name' => $input['name'],
            'default_required_initial_test_count' => $input['default_required_initial_test_count'],
            'automatically_require_maintenance_test' => $input['automatically_require_maintenance_test'],
        ]);

        return redirect()->route('groups.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        return view('groups.show', ['group' => $group]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        return view('groups.edit', ['group' => $group]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        $request->validate([
            'name' => 'required',
            'default_required_initial_test_count' => 'required',
            'automatically_require_maintenance_test' => 'required',
        ]);

        $input = $request->all();

        $group->update([
            'name' => $input['name'],
            'default_required_initial_test_count' => $input['default_required_initial_test_count'],
            'automatically_require_maintenance_test' => $input['automatically_require_maintenance_test'],
        ]);

        return redirect()->route('groups.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        //
    }

    public function dataTable()
    {
        $groups = Group::all();

        return DataTables::of($groups)
            ->addColumn('action', function($g) {
                return '<a href="'.route('groups.show', ['group' => $g]).'">'
                    .$g->name.'</a>';
            })
            ->make(true);
    }
    public function usersDataTable($id)
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
                left join user_cards on users.id = user_cards.user_id
            WHERE `groups`.id = $id";

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
