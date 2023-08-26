<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Events\CommentEvent;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //
   
    public function store(Request $request, Post $post)
    {
        
        $comment = Comment::create([
            'content' => $request->content,
            'post_id' => $post->id,
            'user_id' => auth()->id(),
        ]);
        event(new CommentEvent($comment));
        return redirect()->back();
    }
}