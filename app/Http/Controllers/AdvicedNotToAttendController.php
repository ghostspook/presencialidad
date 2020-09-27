<?php

namespace App\Http\Controllers;

use App\Models\UserCard;
use App\Models\Transition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdvicedNotToAttendController extends Controller
{
    public function index()
    {
        return view('advicednottoattend');
    }

    public function submitDecisionToAttend(Request $request)
    {
        $inputs = $request->all();
        if (array_key_exists('acceptance', $inputs))
        {
            $userCard = Auth::user()->userCard;
            $userCard->state = UserCard::PENDING_QUESTIONNAIRE_1;
            $userCard->save();

            Transition::create([ 'user_id' => Auth::user()->id,
                                 'state' => $userCard->state,
                                 'actor' => Auth::user()->name ]);

            return redirect()->route('questionnarieone');
        }
        else
        {
            return redirect()->back()->withErrors(['acceptance' => 'Debe seleccionar el botón.']);
        }
    }
}
