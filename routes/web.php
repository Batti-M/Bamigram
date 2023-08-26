<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Notifications\NewFollowerGained;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\SocialAuthController;

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


Route::get("/home", function(){
   
    return Inertia::render("Home",[
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');


Route::get("/users", function(){
    
    Notification::send(auth()->user(), new NewFollowerGained());

    return Inertia::render("Users",[
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'), 
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('users');

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    

    Route::resource('/posts', PostController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
