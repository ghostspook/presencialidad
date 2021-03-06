<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Answer;
use App\Models\UserCard;
use App\Models\Transition;

class QuestionnaireOneController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
        $userCard = UserCard::firstWhere('user_id', $userId);
        if ($userCard->state != UserCard::PENDING_QUESTIONNAIRE_1)
            return redirect('/');
        return view('questionnaireone');
    }

    public function questionnaireSubmit(Request $request)
    {
        $userId = Auth::user()->id;
        $userCard = UserCard::firstWhere('user_id', $userId);
        $from_state = $userCard->state;

        $inputs = $request->all();
        unset($inputs["_token"]);
        if (count($inputs) > 0)
        {
            $userCard->poses_risk_due_work_home_circumstance = array_key_exists('circumstance_1', $inputs) || array_key_exists('circumstance_2', $inputs) ? 1 : 0;
            $userCard->state = UserCard::ADVICED_NOT_TO_ATTEND;
            $userCard->save();
            $t = Transition::create([ 'user_id' => $userCard->user_id,
                                    'state' => $userCard->state,
                                    'actor' => $userCard->user->name,
                                    'from_state' => $from_state ]);
            Answer::create([
                            'transition_id' => $t->id ,
                            'answers_text' => json_encode($inputs),
                            ]);
            return redirect()->route('advicedNotToAttend');
        }
        else{
            $userCard->state = UserCard::PENDING_COVERED_TEST_1;
            $userCard->save();
            $t = Transition::create([ 'user_id' => $userCard->user_id,
                                      'state' => $userCard->state,
                                      'actor' => $userCard->user->name,
                                      'from_state' => $from_state ]);
            Answer::create([
                            'transition_id' => $t->id ,
                            'answers_text' => json_encode($inputs),
                            ]);
            return redirect()->to('/');
        }
    }
}
