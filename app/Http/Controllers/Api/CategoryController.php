<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function getCategories()
    {
        $categories = Category::with('subCategories')->get();

        if ($categories->isEmpty()) {
            return response()->json([
                "success" => false,
                "message" => "No Categories Found",
                "data" => null
            ], 404);
        }

        return response()->json([
            "success" => true,
            "message" => "Categories Retrived Successfully",
            "data" => CategoryResource::collection($categories),
        ], 200);
    }
    public function getCategoryById($id)
    {
        $category = Category::with('subCategories')->find($id);

        if (!$category) {
            return response()->json([
                "success" => false,
                "message" => "Category Not Found",
                "data" => null
            ], 404);
        }

        return response()->json([
            "success" => true,
            "message" => "Category Retrieved Successfully",
            "data" => new CategoryResource($category),
        ], 200);
    }
}
