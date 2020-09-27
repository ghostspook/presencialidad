<?php

namespace App\Http\Controllers;

use App\Models\Authorization;
use App\Models\Transition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserCard;
use DateTime;
use Illuminate\Support\Carbon;

class AuthorizationController extends Controller
{
    public function showValidAuthorization()
    {
        $userCard = Auth::user()->userCard;

        if ($userCard->state != UserCard::AUTHORIZED)
            return redirect('/');

        $c = UserCard::firstWhere('user_id', Auth::user()->id);
        if (!$c->authorization_id)
        {
            return redirect('/');
        }
        else
        {
            $a = Authorization::find($c->authorization_id);
            if ($a->expires_at < Carbon::now()) {
                $c->authorization_id = null;
                $c->state = UserCard::PENDING_QUESTIONNAIRE_2;
                $c->save();
                Transition::create([
                    'user_id' => $c->user_id,
                    'state' => $c->state,
                    'actor' => 'system'
                    ]);
                return redirect('/');
            }

            return view('authorization', [ 'a' => $a ]);
        }

    }
}
