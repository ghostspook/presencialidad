<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserCard;
use App\Models\Transition;
use App\Models\Authorization;
use Illuminate\Support\Carbon;

class QuestionnaireTwoController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
        $userCard = UserCard::firstWhere('user_id', $userId);
        if ($userCard->state != UserCard::PENDING_QUESTIONNAIRE_2)
            return redirect('/');
        return view('questionnairetwo');
    }

    public function questionnaireSubmit(Request $request)
    {
        $userId = Auth::user()->id;
        $userCard = UserCard::firstWhere('user_id', $userId);

        $inputs = $request->all();
        unset($inputs["_token"]);
        $inputs = array_filter($inputs, function($e) { return $e != "no"; });
        if (count($inputs) > 0)
        {
            $userCard->state = UserCard::PREEMPTIVE_QUARANTINE;
            $userCard->save();
            Transition::create([ 'user_id' => $userCard->user_id,
                                'state' => $userCard->state,
                                'actor' => $userCard->user->name ]);
            return redirect()->route('preemptiveQuarantine');
        }
        else{
            $a = Authorization::create([
                'user_id' => $userCard->user_id,
                'code' => mt_rand(1000000000000000,9999999999999999),
                'expires_at' =>  Carbon::now()->addDays($userCard->days_authorazation_valid)
            ]);

            $userCard->state = UserCard::AUTHORIZED;
            $userCard->authorization_id = $a->id;
            $userCard->save();
            Transition::create([ 'user_id' => $userCard->user_id,
                                'state' => $userCard->state,
                                'actor' => $userCard->user->name ]);
            return redirect()->to('/');
        }
    }
}
