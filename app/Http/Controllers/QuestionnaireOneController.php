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
       dd($request->all());
    }
}
