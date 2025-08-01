<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Redirect the user to the Twitch authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('twitch')->redirect();
    }

    /**
     * Obtain the user information from Twitch.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $twitchUser = Socialite::driver('twitch')->user();

        $user = User::updateOrCreate([
            'twitch_id' => $twitchUser->getId(),
        ], [
            'name' => $twitchUser->getName(),
            'email' => $twitchUser->getEmail(),
            'avatar' => $twitchUser->getAvatar(),
            'twitch_token' => $twitchUser->token,
            'twitch_refresh_token' => $twitchUser->refreshToken,
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}