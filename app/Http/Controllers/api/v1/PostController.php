<?php

namespace App\Http\Controllers\api\v1;

use Exception;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\api\v1\PostResource;
use App\Http\Resources\api\v1\PostCollection;
use App\Http\Controllers\api\v1\BaseController;

class PostController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::paginate();

        $data = new PostCollection($posts);

        return $this->sendResponse($data, 'Posts retrieved successfully.');
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
            'category_id' => 'required|integer',
            // 'user_id' => 'required|integer',
            'title' => 'required|string',
            'content' => 'required|string',
            'image' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->user()->id;
        // dd($validated['user_id']);

        // catch jika category_id tidak ditemukan
        try {
            $post = Post::create($validated);
            $data = new PostResource($post);
            return $this->sendResponse($data, 'A post has been successfully created.');
        } catch (Exception $e) {
            return $this->sendError('Fail to create post');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);

        if (is_null($post)) {
            return $this->sendError('Post not found.');
        }

        $data = new PostResource($post);

        return $this->sendResponse($data, 'Post retrieved successfully.');
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
        $validated = $request->validate([
            'category_id' => 'required|integer',
            'title' => 'required|string',
            'content' => 'required|string',
            'image' => 'nullable|string',
        ]);

        try {
            $post->update($validated);
            $data = new PostResource($post);
            return $this->sendResponse($data, 'Post updated successfully.');
        } catch (Exception $e) {
            return $this->sendError('Failed to update post.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        try {
            $post->delete();
            return $this->sendResponse([], 'The post successfully deleted.');
        } catch (Exception $e) {
            return $this->sendError('Post deleted successfully.', ['error' => 'eroradfasdf']);
        }
    }
}