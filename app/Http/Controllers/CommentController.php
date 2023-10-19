<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(CommentRequest $request, Post $post)
    {
        $contentComment = $request->comment;
        $res = Comment::create([
            'user_id' => Auth::user()->id,
            'post_id' => $post->id,
            'content' => $contentComment,
        ]);
        if ($res) {
            return redirect()->back()->with('success', 'Comment successfully');
        }
        return redirect()->back()->with('error', 'Comment failed');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
        return $comment;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
