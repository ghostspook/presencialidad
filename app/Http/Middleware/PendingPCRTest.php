<?php

namespace App\Http\Middleware;

use App\Models\UserCard;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendingPCRTest
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
        if (Auth::user()->userCard->state != UserCard::PENDING_PCR_TEST ) {
            return redirect('/');
        }

        return $next($request);
    }
}
