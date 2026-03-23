<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\v1\Category\StoreCategoryRequest;
use App\Http\Requests\Api\v1\Category\UpdateCategoryRequest;
use App\Http\Resources\Api\v1\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return CategoryResource::collection(Category::paginate( $request->per_page ?? 10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $categoryAttr = collect($request->only(['category']))->toArray();

        return new CategoryResource(Category::create($categoryAttr)); 
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $categoryAttr = collect($request->only(['category']))->toArray();
        
        $category->update($categoryAttr);

        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete(); 
 
        return response()->json([
             "message" => "resource was successfully deleted", 
        ],200);
    }
}
