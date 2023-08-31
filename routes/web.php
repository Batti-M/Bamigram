<?php

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Notifications\NewFollowerGained;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\SocialAuthController;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::post('/posts/{post}/comments', [CommentController::class, 'store']);
 
Route::get('/auth/redirect', function () {
    return Socialite::driver('github')->redirect();
});
Route::get('/auth/callback', [SocialAuthController::class, 'createUserFromGithub']);
 

Route::post('/follow/{user}', [FollowController::class, 'follow'])->name('follow');
Route::delete('/unfollow/{user}', [FollowController::class, 'unfollow'])->name('unfollow');


Route::post('/like/{post}', [LikeController::class, 'like'])->name('like');
Route::delete('/unlike/{post}', [LikeController::class, 'unlike'])->name('unlike');


Route::get("/home", [HomeController::class, 'index'])->name('home');


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});


Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/explore', [PostController::class, 'index'])->name('explore');
    
    Route::resource('/posts', PostController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
