<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryResource;

class CategoryController extends Controller
{
    public function store(Request $request, Category $category)
    {
        $request->validate([
            'title'     => ['required', 'string'],
            'parent_id' => ['nullable', 'exists:categories,id']
        ]);
        $category = Category::create([
            'title'     => $request->title,
            'parent_id' => $request->parent_id
        ]); 

        return  response()->json([
            'status' => 'successful',
            'message' => new CategoryResource($category),
        ]);
    }

    public function show(Category $category)
    {
        return new CategoryResource($category);
    }
}
