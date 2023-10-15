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
        $postList = Post::with(['categories'])->get();
        return view('post.posts-list', ['postList' => $postList]);
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
    public function update(Request $request, string $slug)
    {
        $result = Post::where('slug', $slug)->update(['accepted' => 1, 'deleted_at' => null]);
        if ($result) {
            return redirect()->route('admin.index')->with('success', "$slug has accepted");
        }
        return redirect()->route('admin.index')->with('error', "Accepting $slug was failed");
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

    public function forceDel(string $slug)
    {
        $result = Post::where('slug', $slug)->forceDelete();
        if ($result) {
            return redirect()->route('admin.index')->with('success', "$slug has deleted permanently");
        }
        return redirect()->route('admin.index')->with('error', "Failed");
    }
}
