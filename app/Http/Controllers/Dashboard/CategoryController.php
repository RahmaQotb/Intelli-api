<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\Admin\Category\categoryService;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        return view("Admin.categories.index", compact("categories"));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories,slug',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $category = new Category($validated);

        if ($request->hasFile('image')) {
            $category->image = 'Uploads/' . $request->file('image')->storePublicly('Category/Image', 'public');
        }

        $category->save();

        return redirect()->route('Admin.categories.index')->with('success', 'Category created successfully.');
    }


    public function show($id)
    {
        $category = Category::findOrFail($id);

        return view("Admin.categories.show", compact("category"));
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);

        if ($category->image && Storage::disk('public')->exists(str_replace('Uploads/', '', $category->image))) {
            Storage::disk('public')->delete(str_replace('Uploads/', '', $category->image));
        }

        $category->delete();

        return redirect()->route('Admin.categories.index')->with('success', 'Category Deleted Successfully');
    }
}
