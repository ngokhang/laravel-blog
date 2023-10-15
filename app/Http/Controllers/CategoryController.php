<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.manage-category', ['categories' => $categories]);
        // return $categories;
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
    public function store(CategoryRequest $request)
    {
        //
        $newCategory = $request->new_name_category;
        $newSlug = $request->new_slug_category;
        if (Category::where('name', $newCategory)->first()) {
            return redirect()->back()->with('error', 'Existed');
        }

        $res = Category::create([
            'name' => $newCategory,
            'slug' => $newSlug
        ]);

        if ($res) {
            return redirect()->back()->with('success', 'Added');
        }
        return redirect()->back()->with('error', 'Failed');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        //
        $newSlug = $request->new_slug_category;
        $newName = $request->new_name_category;
        $slug = $request->category;
        $res = Category::where('slug', $slug)->update([
            'slug' => $newSlug,
            'name' => $newName
        ]);
        if ($res) {
            return redirect()->back()->with('success', 'Successfully');
        }
        return redirect()->back()->with('error', 'Failed');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $res = Category::whereIn('slug', $request->category_slug)->delete();
        if ($res) {
            return redirect()->back()->with('success', 'Successfully');
        }
        return redirect()->back()->with('error', 'Failed');
    }
}
