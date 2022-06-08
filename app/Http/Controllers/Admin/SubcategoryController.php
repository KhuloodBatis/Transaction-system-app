<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryResource;

class SubcategoryController extends Controller
{
    public function store(Request $request, Category $subcategory)
    {
        $request->validate([
            'title'     => ['required', 'string'],
            'parent_id' => ['required', 'exists:categories,id']
        ]);
        $subcategory = Category::create([
            'title'     => $request->title,
            'parent_id' => $request->parent_id
        ]);
        return  response()->json([
            'status' => 'successful',
            'message' => new CategoryResource($subcategory),
        ]);
    }
}
