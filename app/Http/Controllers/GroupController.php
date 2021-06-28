<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
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

        return redirect()->route('grupos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        //
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
                return '<a href="'.route('groups.edit', ['group' => $g]).'">'
                    .$g->name.'</a>';
            })
            ->make(true);
    }
}
