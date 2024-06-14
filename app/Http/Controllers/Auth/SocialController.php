<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $userSocial = Socialite::driver($provider)->user();
        $user = User::where('email', $userSocial->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name' => $userSocial->getName(),
                'email' => $userSocial->getEmail(),
                'provider' => $provider,
                'provider_id' => $userSocial->getId(),
            ]);
        }

        Auth::login($user, true);
        return redirect('/home'); // Redirect to a desired location
    }
}
