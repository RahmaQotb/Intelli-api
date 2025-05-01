<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::All();
        return view("Admin.categories.index", compact("categories"));
    }

    public function create()
    {
        return view("Admin.categories.create");
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
            $path = $request->file('image')->storePublicly('category/images', 'public');
            $category->image = $path;
        }

        $category->save();

        return view('Admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view("Admin.categories.show", compact("category"));
    }

    // public function edit($id)
    // {
    //     $category = Category::findOrFail($id);
    //     return view("Admin.categories.edit", compact("category"));
    // }

    // public function update(Request $request, $id)
    // {
    //     $category = Category::findOrFail($id);

    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'slug' => 'required|string|unique:categories,slug,'.$id,
    //         'description' => 'nullable|string',
    //         'image' => 'nullable|image|max:2048',
    //     ]);

    //     if ($request->hasFile('image')) {
    //         if ($category->image) {
    //             Storage::disk('public')->delete($category->image);
    //         }
    //         $path = $request->file('image')->storePublicly('category/images', 'public');
    //         $validated['image'] = $path;
    //     }

    //     $category->update($validated);

    //     return redirect()->route('admin.categories.index')
    //         ->with('success', 'Category updated successfully.');
    // }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('Admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}