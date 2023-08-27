<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class ProfileController extends Controller
{

    public function store(Request $request){
        if(!$request->hasFile('profile_photo_url')){
            dd($request->all());
            return redirect()->back()->with('error', 'No file selected');
        }
        $attributes = $request->validate([
            'profile_photo_url' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        $user = User::find(auth()->user()->id);
        if($user->profile_photo_url != null){
            Storage::disk('public/storage/')->delete($user->profile_photo_url);
        }
        
        $user->update([
            'profile_photo_url' => $request->profile_photo_url->store('images', 'public')
        ]);

        return redirect()->route('posts.index')->with('success', 'Profile photo updated successfully');
    }
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail, 
            'status' => session('status'), 
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
