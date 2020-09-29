<?php

namespace App\Http\Controllers;

use App\Models\UserCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (!Auth::check())
            return view('welcome');

        switch (Auth::user()->userCard->state) {
            case UserCard::PENDING_ENROLLMENT:
                return redirect()->route('enrollment');
            case UserCard::PENDING_QUESTIONNAIRE_1:
                return redirect()->route('questionnarieone');
            case UserCard::PENDING_COVERED_TEST_1:
                return view('testone');
            case UserCard::PENDING_COVERED_TEST_2:
                return view('testtwo');
            case UserCard::PENDING_QUESTIONNAIRE_2:
                return redirect()->route('questionnarieTwo');
            case UserCard::AUTHORIZED:
                return redirect()->route('showValidAuthorization');
            case UserCard::ADVICED_NOT_TO_ATTEND:
                return redirect()->route('advicedNotToAttend');
            case UserCard::PENDING_NON_COVERED_TEST:
                return view('noncoveredtest');
            case UserCard::PREEMPTIVE_QUARANTINE:
                return redirect()->route('preemptiveQuarantine');
            case UserCard::PENDING_PCR_TEST:
                return redirect()->route('pcrtest_create');
            case UserCard::MANDATORY_QUARANTINE:
                return redirect()->route('mandatoryQuarantine');
            default:
                return view('home');
        }
    }
}
