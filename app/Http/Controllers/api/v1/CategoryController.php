<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\api\v1\BaseController;
use App\Http\Resources\api\v1\CategoryCollection;
use App\Http\Resources\api\v1\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::with('posts')->get();

        $data = new CategoryCollection($categories);

        return $this->sendResponse($data, 'Category retrived successfully.');
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
            'name' => 'required|string',
        ]);

        $validated['user_id'] = auth()->user()->id;

        $category = Category::create($validated);

        $data =  new CategoryResource($category);

        return $this->sendResponse($data, 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);

        if (is_null($category)) {
            return $this->sendError('Category not found.');
        }

        $data = new CategoryResource($category->loadMissing('posts'));

        return $this->sendResponse($data, 'Category retrieved successfully.');
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
            'name' => 'required|string',
        ]);

        $category->update($validated);

        $data = new CategoryResource($category);

        return $this->sendResponse($data, 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return $this->sendResponse([], 'Category deleted successfully.');
        } catch (\Exception $e) {
            return $this->sendError('fail', ['error' => 'eroradfasdf']);
        }
    }
}