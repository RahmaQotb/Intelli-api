<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Brand;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::get();
        return view('Dashboard.Products.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();
        $sub_categories = SubCategory::get();
        $brands = Brand::get();
        return view('Dashboard.Products.create',compact('categories','sub_categories','brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // dd($request);

    $validated = $request->validate([
        'name' => 'required|string|max:255|unique:products,name',
        'description' => 'nullable|string',
        'quantity' => 'required|integer|min:0',
        'category_id' => 'required|exists:categories,id',
        // 'brand_id' => 'required|exists:brands,id',
        'sub_category_id' => 'nullable|exists:sub_categories,id',
        'image' => 'required|image|mimes:jpeg,png,jpg,webp',
        'price' => 'required|numeric|min:0',
        'discount_in_percentage' => 'nullable|numeric|min:1',
        'condition' => 'required|in:Default,New,Hot,Best Seller,Special Offer',
        'status' => 'required|in:active,archieved',
    ]);
    $validated['brand_id']=1;

    $validated['slug'] = Str::slug($validated['name']);

    $validated['image'] = 'Uploads/' . $request->file('image')->storePublicly('Products', 'public');

    if($request->filled('discount_in_percentage')){
        $validated['total_price'] = $validated['price'] - ($validated['price'] * ($validated['discount_in_percentage']/100));
    }else{
        $validated['total_price'] = $validated['price'];
    }
    // dd($validated);
    $product = Product::create($validated);

    return back()->with('success', 'Product Added Successfully');
}

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::get();
        $sub_categories = SubCategory::get();
        $brands = Brand::get();
        
        return view('Dashboard.Products.edit', compact('product', 'categories', 'sub_categories','brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);
    $validated = $request->validate([
        'name' => 'required|string|max:255|unique:products,name,'.$id,
        'description' => 'nullable|string',
        'quantity' => 'required|integer|min:0',
        'category_id' => 'required|exists:categories,id',
        // 'brand_id' => 'required|exists:brands,id',
        'sub_category_id' => 'nullable|exists:sub_categories,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,webp',
        'price' => 'required|numeric|min:0',
        'discount_in_percentage' => 'nullable|numeric|min:1',
        'condition' => 'required|in:Default,New,Hot,Best Seller,Special Offer',
        'status' => 'required|in:active,archieved',
    ]);
    $validated['brand_id']=1;


    $validated['slug'] = Str::slug($validated['name']);
    // Handle image update
    if ($request->hasFile('image')) {
        // Delete old image
        if ($product->image) {
            Storage::disk('public')->delete(str_replace('Uploads/', '', $product->image));
        }
        $validated['image'] = 'Uploads/' . $request->file('image')->storePublicly('Products', 'public');
    }

    // Calculate total price if discount is applied
    if($request->filled('discount_in_percentage')) {
        $validated['total_price'] = $validated['price'] - ($validated['price'] * ($validated['discount_in_percentage']/100));
    } else {
        $validated['total_price'] = $validated['price'];
    }

    $product->update($validated);
    

    return back()->with('success', 'Product Updated Successfully');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $Product = Product::findOrFail($id);
        $Product->delete();
        if ($Product->image) {
            Storage::disk('public')->delete(str_replace('Uploads/', '', $Product->image));
        }
        return back()->with('success','Product Deleted Successfully');
    }
}
