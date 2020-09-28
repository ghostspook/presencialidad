<?php

namespace App\Http\Controllers;

use App\Models\Answer;
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
            $userCard->state = UserCard::PENDING_COVERED_TEST_1;
            $userCard->save();

            $t = Transition::create([ 'user_id' => Auth::user()->id,
                                 'state' => $userCard->state,
                                 'actor' => Auth::user()->name ]);
            Answer::create([
                'transition_id' => $t->id ,
                'answers_text' => json_encode($inputs),
                ]);

            return redirect()->route('questionnarieone');
        }
        else
        {
            return redirect()->back()->withErrors(['acceptance' => 'Debe seleccionar el botón.']);
        }
    }
}
