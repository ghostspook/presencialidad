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
            default:
                return view('home');
        }
    }
}
