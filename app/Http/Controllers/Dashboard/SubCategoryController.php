<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;;

use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sub_categories = SubCategory::get();
        return view('Dashboard.Sub Categories.index',compact('sub_categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();
        return view('Dashboard.Sub Categories.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name"=> "required|string|max:255|unique:sub_categories,name",
            "description"=>"nullable|string",
            "image"=>"required|image|mimes:png,jpeg,webp,jpg",
            'category_id'=>"required|exists:categories,id"
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $validated['image'] = 'Uploads/'.$request->file('image')->storePublicly('Sub Categories','public');

        SubCategory::create($validated);

        return back()->with('success','Sub Category Added Successfully');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $sub_category = SubCategory::findOrFail($id);
        $categories = Category::get();
        return view('Dashboard.Sub Categories.edit',compact('sub_category','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
{
    $subCategory = SubCategory::findOrFail($id);
    $validated = $request->validate([
        "name" => "required|string|max:255|unique:sub_categories,name," . $subCategory->id,
        "description" => "nullable|string",
        "image" => "nullable|image|mimes:png,jpeg,webp,jpg",
        'category_id' => "required|exists:categories,id"
    ]);

    $validated['slug'] = Str::slug($validated['name']);

    if ($request->hasFile('image')) {
        if ($subCategory->image) {
            Storage::disk('public')->delete(str_replace('Uploads/', '', $subCategory->image));
        }

        $validated['image'] = 'Uploads/' . $request->file('image')->storePublicly('Sub Categories', 'public');
    }

    $subCategory->update($validated);

    return back()->with('success', 'Sub Category Updated Successfully');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $sub_Category = SubCategory::findOrFail($id);
        $sub_Category->delete();
        if ($sub_Category->image) {
            Storage::disk('public')->delete(str_replace('Uploads/', '', $sub_Category->image));
        }
        return back()->with('success','Sub Category Deleted Successfully');
    }
}
