<?php

namespace App\Http\Controllers;

use App\Models\UserCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestResultController extends Controller
{
    public function listUsersPendingTests()
    {
        $u = Auth::user();
        if (!$u->can_enter_test_results)
            return redirect('/');

        $cards = UserCard::where('state', UserCard::PENDING_COVERED_TEST_1)->get();
        return view('userspendingtests', ['cards' => $cards]);
    }
}
