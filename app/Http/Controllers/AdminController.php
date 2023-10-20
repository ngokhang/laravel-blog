<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $postList = Post::adminManagePost();
        return view('post.posts-list', ['postList' => $postList]);
        // return $postList;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $post->update(['accepted' => 1]);
        return $post->restore() ? redirect()->route('admin.index')->with('success', "$post->title has restore") : redirect()->route('admin.index')->with('error', "Failed");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $result = Post::where('slug', $slug)->delete();
        if ($result) {
            return redirect()->route('admin.index')->with('success', "$slug has been temporarily deleted");
        }
        return redirect()->route('admin.index')->with('error', "Failed");
    }
}
