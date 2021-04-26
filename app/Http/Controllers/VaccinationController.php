<?php

namespace App\Http\Controllers;

use App\Models\UserCard;
use App\Models\Vaccination;
use App\Models\VaccineType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        Vaccination::create([
            'user_id' => $input['user_id'],
            'vaccine_type_id' => $input['vaccine_type_id'],
            'vaccinated_date' => $input['vaccinated_date'],
            'added_by' => Auth::user()->name,
            'comments' => $input['comments'],
        ]);

        $returnTo = route('trackedaccounts_show', ['id' => $input['user_id'] ]);

        return redirect()->to($returnTo);
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
