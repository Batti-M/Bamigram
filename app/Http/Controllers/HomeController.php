<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class HomeController extends Controller
{
       
    public function index(Request $request){

        $user = $request->user()->load(['followers', 'following']);

        return Inertia::render("Home",[
            'users' => User::query()->when($request->input('search'), function($query, $search){
                $query->where('username', 'LIKE', "%{$search}%");
            })->paginate(12)->withQueryString(),
            'ownPosts' => $user->posts()->latest()->paginate(12)->withQueryString(),
        ]);
    }
}
