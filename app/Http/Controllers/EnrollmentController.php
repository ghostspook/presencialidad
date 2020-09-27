<?php

namespace App\Http\Controllers;

use App\Models\UserCard;
use App\Models\Transition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class EnrollmentController extends Controller
{
    public function index()
    {
        return view('enroll');
    }

    public function enrollSubmit(Request $request)
    {
        $inputs = $request->all();
        if (array_key_exists('acceptance', $inputs))
        {
            $userId = Auth::user()->id;
            $userCard = UserCard::firstWhere('user_id', $userId);
            $userCard->state = UserCard::PENDING_QUESTIONNAIRE_1;
            $userCard->save();

            Transition::create([ 'user_id' => $userId,
                                 'state' => $userCard->state,
                                 'actor' => Auth::user()->name ]);

            return redirect()->route('questionnarieone');
        }
        else
        {
            return redirect()->back()->withErrors(['acceptance' => 'Debe aceptar los términos y condiciones para poder continuar.']);
        }

    }
}
