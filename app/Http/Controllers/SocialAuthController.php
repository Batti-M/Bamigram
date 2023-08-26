<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function createUserFromGithub()
    {

        $githubUser = Socialite::driver('github')->user();

        $user = User::updateOrCreate([
            'github_id' => $githubUser->id,
        ], [
            'name' => $githubUser->name,
            'username' => $githubUser->nickname,
            'email' => $githubUser->email,
            'github_token' => $githubUser->token,
            'github_refresh_token' => $githubUser?->refreshToken,
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }
}
