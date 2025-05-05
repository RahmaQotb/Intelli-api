<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::get();
        return view('Dashboard.Categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Dashboard.Categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name"=> "required|string|max:255|unique:categories,name",
            "description"=>"nullable|string",
            "image"=>"required|image|mimes:png,jpeg,webp,jpg",
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $validated['image'] = 'Uploads/'.$request->file('image')->storePublicly('Categories','public');

        Category::create($validated);

        return back()->with('success','Category Added Successfully');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('Dashboard.Categories.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
{
    $Category = Category::findOrFail($id);
    $validated = $request->validate([
        "name" => "required|string|max:255|unique:categories,name," . $Category->id,
        "description" => "nullable|string",
        "image" => "nullable|image|mimes:png,jpeg,webp,jpg",
    ]);

    $validated['slug'] = Str::slug($validated['name']);

    if ($request->hasFile('image')) {
        if ($Category->image) {
            Storage::disk('public')->delete(str_replace('Uploads/', '', $Category->image));
        }

        $validated['image'] = 'Uploads/' . $request->file('image')->storePublicly('Categories', 'public');
    }

    $Category->update($validated);

    return back()->with('success', 'Category Updated Successfully');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $Category = Category::findOrFail($id);
        $Category->delete();
        if ($Category->image) {
            Storage::disk('public')->delete(str_replace('Uploads/', '', $Category->image));
        }
        return back()->with('success','Category Deleted Successfully');
    }
}
