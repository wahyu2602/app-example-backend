<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = Post::get();
        if ($post->isEmpty()) {
            return response()->json([
                'massage' => 'Data not found!'
            ], Response::HTTP_NOT_FOUND);
        }
        return response()->json($post, Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required',
            'short_description' => 'required',
            'description' => 'required'
        ]);

        $post = Post::create([
            'user_id' => auth()->user()->id,
            'title' => $validate['title'],
            'short_description' => $validate['short_description'],
            'description' => $validate['description'],
            'time' => now()
        ]);

        return response()->json([
            'massage' => 'Post success created!',
            'post' => $post
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        if (!$post->where('id', $post)->get()) {
            return response()->json(['massage' => 'data not found!'], Response::HTTP_NOT_FOUND);
        }

        $post->where('id', $post)->get();

        return response()->json($post, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
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
        $validate = $request->validate([
            'title' => 'required',
            'short_description' => 'required',
            'description' => 'required'
        ]);

        if (!$post->where('id', $post)->get()) {
            return response()->json(['massage' => 'data not found!'], Response::HTTP_NOT_FOUND);
        }

        $post->where('id', $post)->update([
            'title' => $validate['title'],
            'short_description' => $validate['short_description'],
            'description' => $validate['description']
        ]);

        return response()->json($post, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->where('id', $post)->delete();

        return response()->json([
            'massage' => 'Post susscess deleted!',
        ], Response::HTTP_OK);
    }
}
