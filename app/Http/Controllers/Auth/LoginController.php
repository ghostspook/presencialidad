<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\TrackedAccount;
use App\Models\UserCard;
use App\Models\Transition;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')
            ->with(['hd' => 'ide.edu.ec'])
            ->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $social_user = Socialite::driver('google')->user();

        if ($user = User::where('email', $social_user->email)->first()) {
            return $this->authAndRedirect($user); // Login y redirección
        } else {
            $account = TrackedAccount::firstWhere('email', $social_user->email);

            if (!$account) {
                return redirect()->route('cuentanohabilitada');
            }
            // En caso de que no exista creamos un nuevo usuario con sus datos.
            $user = User::create([
                'name' => $social_user->name,
                'email' => $social_user->email,
                'provider' => 'google',
                'tracked_account_id' => $account->id
            ]);

            $user_card = UserCard::create ([
                'user_id' => $user->id,
                'days_authorazation_valid' => $account->accountType->default_days_authorization_valid,
                'required_initial_test_count' => $account->group_id ? $account->group->default_required_initial_test_count : 2,
                'state' => UserCard::PENDING_ENROLLMENT,
            ]);

            Transition::create([ 'user_id' => $user->id,
                                 'state' => $user_card->state,
                                 'actor' => $user->name ]);

            return $this->authAndRedirect($user); // Login y redirección
        }
    }

    public function authAndRedirect($user)
    {
        Auth::login($user);

        return redirect()->to('/');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->to('/');
    }

    public function displayCuentaNoHabilitada()
    {
        return view('cuentanohabilitada');
    }
}
