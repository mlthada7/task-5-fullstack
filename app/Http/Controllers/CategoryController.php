<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate(6);

        return view('blog.category.index', [
            'title' => 'All Categories',
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('blog.category.create', [
            'title' => 'Create New Category'
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
            'name' => 'required|string|unique:categories,name',
        ]);

        $validated['user_id'] = auth()->user()->id;

        $category = Category::create($validated);

        return redirect()->route('categories.index')->with(['success' => "Category $category->name is successfully saved."]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        // return view('blog.category.show', [
        //     'title' => $category->title,
        //     'category' => $category
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        if (auth()->user()->id !== $category->user->id) {
            return redirect()->back()->with('status', 'Unauthorized');
        }

        return view('blog.category.edit', [
            'title' => "Edit $category->title",
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:categories,name',
        ]);

        $validated['user_id'] = auth()->user()->id;

        $category = Category::where('id', $category->id)->update($validated);

        return redirect()->route('categories.index')->with(['success' => "The category is successfully updated."]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with(['success' => "Category $category->name has been deleted!"]);
    }
}