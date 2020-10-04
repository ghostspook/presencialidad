<?php

namespace App\Http\Middleware;

use App\Models\UserCard;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CanAnswerQuestionnaire2
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $userState = Auth::user()->userCard->state;
        if ($userState != UserCard::PENDING_QUESTIONNAIRE_2 && $userState != UserCard::AUTHORIZED) {
            return redirect('/');
        }

        return $next($request);
    }
}
