<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $postList = Post::with(['categories'])->where('accepted', 1)->get();
        return view('post.posts-list', ['postList' => $postList]);
    }
}
