<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserCard;

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

        $inputs = $request->all();
        unset($inputs["_token"]);
        if (count($inputs) > 0)
        {
            $userCard->state = UserCard::ADVICED_NOT_TO_ATTEND;
            $userCard->save();
            return redirect()->route('advicedNotToAttend');
        }
        else{
            $userCard->state = UserCard::PENDING_COVERED_TEST_1;
            $userCard->save();
            return redirect()->route('testOne');
        }
    }
}
