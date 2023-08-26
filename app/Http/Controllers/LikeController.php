<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LikeController extends Controller
{
    public function like(Request $request, Post $post)
    {
        if ($request['like'] === true && !$post->likedBy->contains(auth()->user()->id)) {
            $post->likedBy()->attach(auth()->user()->id);
        }
    }

    public function unlike(Request $request, Post $post)
    {

   ;
        $post->likedBy()->detach(auth()->user()->id);
        return redirect()->back()->with('success', 'You have unliked this post.');
       
    }
}
