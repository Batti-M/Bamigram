<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\NewFollowerGained;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function follow(User $user, Request $request)
    {
       
        $author = User::find($request->author['id']);

        if ($request->user()->isFollowing($author)) {
            return redirect()->back()->with('error', 'You are already following this user.');
        }


        // Follow the user
        $authenticatedUser = User::find(auth()->user()->id);
        $authenticatedUser->follow($author);

        // Send a notification to the user being followed
        //$user->notify(new NewFollowerGained());

        return redirect()->back()->with('success', 'You are now following this user.');
    }

    public function unfollow(User $user)
    {
        $authenticatedUser = User::find(auth()->user()->id);

        if(!$authenticatedUser->isFollowing($user)) {
            return redirect()->back()->with('error', 'You are not following this user.');
        }

        $authenticatedUser->unfollow($user);

        return redirect()->back()->with('success', 'You have unfollowed this user.');
    }
}
