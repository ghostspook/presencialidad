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
            case UserCard::ADVICED_NOT_TO_ATTEND:
                return redirect()->route('advicedNotToAttend');
            case UserCard::PENDING_COVERED_TEST_1:
                return redirect()->route('testOne');
            default:
                return view('home');
        }
    }
}
