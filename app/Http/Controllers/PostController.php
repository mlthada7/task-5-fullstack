<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->paginate(6);
        return view('blog.post.index', [
            'title' => 'All Posts',
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('blog.post.create', [
            'title' => 'Create New Post',
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|unique:posts,title',
            'category_id' => 'required',
            'content' => 'required|string',
            'image' => 'required|image|file|max:2048'
        ]);

        $validated['user_id'] = auth()->user()->id;

        if ($request->file('image')) {
            $validated['image'] = $request->file('image')->store('post-image');
        }

        // dd($validated);

        Post::create($validated);

        return redirect()->route('posts.index')->with(['success' => "New post is successfully saved."]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('blog.post.show', [
            'title' => $post->title,
            'post' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if (auth()->user()->id !== $post->user->id) {
            return redirect()->back()->with('status', 'Unauthorized');
        }

        return view('blog.post.edit', [
            'title' => "Edit $post->title",
            'post' => $post,
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $rules = [
            'category_id' => 'required',
            'content' => 'required|string',
            'image' => 'image|file|max:2048'
        ];

        if ($request->title !== $post->title) {
            $rules['title'] = 'required|string|unique:posts,title';
        }

        $validated = $request->validate($rules);

        if ($request->file('image')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validated['image'] = $request->file('image')->store('post-image');
        }

        $validated['user_id'] = auth()->user()->id;

        $post->update($validated);

        return redirect()->route('posts.index')->with(['success' => "The post is successfully updated."]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if ($post->image) {
            Storage::delete($post->image);
        }

        $post->delete();

        return redirect()->route('posts.index')->with(['success' => 'Post has been deleted!']);
    }
}