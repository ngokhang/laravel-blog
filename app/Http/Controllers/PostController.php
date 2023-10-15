<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Models\Category;
use App\Models\CategoryPost;
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
        //
        $user = Auth::user()->id;
        $postList = Post::with(['categories'])->where('user_id', $user)->get();
        return view('post.posts-list', ['postList' => $postList]);
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
        $newPost->title = $request->title;
        $newPost->description = $request->description;
        $newPost->slug = $request->slug;
        $newPost->content = $request->content;
        $newPost->user_id = Auth::id();
        $category = Category::find($request->category_id);
        if ($request->hasFile('article_img')) {
            $file = $request->file('article_img');
            $fileName = $newPost->slug . '.' . $file->getClientOriginalExtension();
            $file->move('uploads', $fileName);
            Image::updateOrCreate(
                ['slug' => $request->slug],
                [
                    'path' => 'uploads/' . $fileName
                ]
            );
        }

        if (Auth::user()->role == 'admin') {
            $newPost->accepted = 1;
            $savePost = $newPost->save();
            $accosiateCategory = $category->posts()->save($newPost);
            return ($savePost && $accosiateCategory) ? redirect()->route('post.index')->with('success', 'Created new post') : redirect()->back()->with('error', 'Error has occured');
        }

        if ($newPost->save() && $category->posts()->save($newPost)) {
            return redirect()->route('post.index')->with('success', 'Created new post and awaiting approval from admin');
        }
        return redirect()->back()->with('error', 'Error has occured');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $post = Post::with(['user', 'categories', 'comments'])->where('slug', $slug)->first();
        $images = Image::where('slug', $slug)->first() ? Image::where('slug', $slug)->first()->path : '';
        return view('post.post-detail', ['post' => $post, 'article_img' => $images, 'comments' => $post->comments]);
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
    public function update(CreatePostRequest $request, string $slug)
    {
        $post = Post::where('slug', $slug)->first();
        CategoryPost::where('post_id', $post->id)->delete();
        $category = Category::find($request->category_id);

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
            $post = Post::where('slug', $slug)->first()
                ->update([
                    'title' => $request->title,
                    'description' => $request->description,
                    'slug' => $request->slug,
                    'content' => $request->content,
                    'user_id' => Auth::id(),
                    'accepted' => 1
                ]);
            $accosiateCategory = $category->posts()->update($post);
            return ($post && $accosiateCategory) ? redirect()->route('admin.index')->with('success', 'Updated new post') : redirect()->back()->with('error', 'Error has occured');
        }

        $res = $post->update([
            'title' => $request->title,
            'description' => $request->description,
            'slug' => $request->slug,
            'content' => $request->content,
            'user_id' => Auth::id(),
            'accepted' => 0
        ]);
        if ($res && $category->posts()->save($post)) {
            return redirect()->route('post.index')->with('success', 'Updated new post and awaiting approval from admin');
        }
        return redirect()->back()->with('error', 'Error has occured');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
