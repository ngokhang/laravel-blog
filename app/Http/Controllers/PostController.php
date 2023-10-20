<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Models\Category;
use App\Models\CategoryPost;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::user()->id;
        $postList = Post::yourPost();
        return view('post.posts-list', ['postList' => $postList]);
        // return $postList;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('post.partials.form-create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePostRequest $request)
    {
        $newPost = new Post;
        $newPost->fill($request->all());
        $newPost->user()->associate(Auth::user())->save();
        $newPost->categories()->attach([$request->category_id]);

        if (Auth::user()->role == 'admin') {
            $newPost->accepted = 1;

            if ($request->hasFile('article_img')) {
                $file = $request->file('article_img');
                $fileName = $newPost->slug . '.' . $file->getClientOriginalExtension();
                $postId = Post::where("slug", $newPost->slug)->value('id');
                $file->move('uploads', $fileName);
                Image::updateOrCreate(
                    ['name' => $request->slug],
                    [
                        'path' => 'uploads/' . $fileName,
                        'post_id' => $postId
                    ]
                );
            }

            return ($newPost->save()) ? redirect()->route('post.index')->with('success', 'Created new post') : redirect()->back()->with('error', 'Error has occured');
        }


        if ($newPost->save()) {
            if ($request->hasFile('article_img')) {
                $file = $request->file('article_img');
                $fileName = $newPost->slug . '.' . $file->getClientOriginalExtension();
                $postId = Post::where("slug", $newPost->slug)->value('id');
                $file->move('uploads', $fileName);
                Image::updateOrCreate(
                    ['name' => $request->slug],
                    [
                        'path' => 'uploads/' . $fileName,
                        'post_id' => $postId
                    ]
                );
            }
            return redirect()->route('post.index')->with('success', 'Created new post and awaiting approval from admin');
        }
        return redirect()->back()->with('error', 'Error has occured');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->load(['categories.posts', 'comments' => function ($query) {
            $query->where('reply_to', null);
        }, 'comments.replies.user']);
        return view('post.post-detail', ['post' => $post]);
        // return $post;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $post = Post::with(['categories'])->where('id', $id)->first();
        $categories = Category::all();
        return view('post.partials.form-edit', ['categories' => $categories, 'post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreatePostRequest $request, Post $post)
    {

        $post->load(['categories'])->categories()->detach($post->categories()->first()->id);

        if ($request->hasFile('article_img')) {
            $file = $request->file('article_img');
            $fileName = $post->slug . '.' . $file->getClientOriginalExtension();
            $file->move('uploads', $fileName);
            Image::updateOrCreate(
                ['slug' => $request->slug],
                [
                    'path' => 'uploads/' . $fileName
                ]
            );
        }

        if (Auth::user()->role == 'admin') {
            $post->update([
                'title' => $request->title,
                'description' => $request->description,
                'slug' => $request->slug,
                'content' => $request->content,
                'user_id' => Auth::id(),
                'accepted' => 1
            ]);
            $post->categories()->attach([$request->category_id]);
            return ($post) ? redirect()->route('admin.index')->with('success', 'Updated new post') : redirect()->back()->with('error', 'Error has occured');
        }

        $post->update([
            'title' => $request->title,
            'description' => $request->description,
            'slug' => $request->slug,
            'content' => $request->content,
            'user_id' => Auth::id(),
            'accepted' => 0
        ]);
        $post->categories()->attach([$request->category_id]);
        return ($post) ? redirect()->route('dashboard')->with('success', 'Updated new post') : redirect()->back()->with('error', 'Error has occured');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
