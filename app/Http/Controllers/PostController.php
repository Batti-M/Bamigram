<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Services\ImageService;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }
    
    public function index()
    {
        return Inertia::render(
            'Explore',
            [
                'posts' => Post::latest()->get(),
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Posts/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $attributes = $request->validate([
            'img_url' => ['file', 'image', 'max:6048'],
            'description' => ['sometimes', 'string', 'max:255'], // 'nullable
            'body' => ['required', 'min:3'],
        ]);

        if (!request()->hasFile('img_url')) {
            return redirect()->back()->with('error', 'Please upload an image.');
        }

        $attributes['user_id'] = request()->user()->id;

        $path = $this->imageService->handleImageUpload($request->file('img_url'));

        $attributes = array_merge($attributes, ['img_url' => $path]);
     
        Post::create($attributes);

        return redirect()->route('home')->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::with(['author', 'likedBy', 'comments' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }, 'comments.user'])->find($id);

        $timeUpdatedComments = $post->comments->map(function ($comment) {
            $comment->created_at = $comment->created_at->diffForHumans();
            return $comment;
        });

        $followerCount = $post->author->followers->toArray();

        return Inertia::render('Posts/Show', [
            'post' => $post,
            'created' => $post->created_at->diffForHumans(),
            'followers' => $followerCount,
            'comments' => $timeUpdatedComments
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('Posts/Edit', [
            'post' => Post::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $attributes = $request->validate([
            'body' => ['required', 'min:3'],
        ]);

        $post = Post::find($id);

        $post->update($attributes);

        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}
