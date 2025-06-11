<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\BrandAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrandController extends Controller
{
 
    /**
     * Display a listing of all brands.
     */
    public function index()
    {
        return view('Dashboard.Brand.index', ['brands' => Brand::with('brand_admin')->get()]);
    }

    /**
     * Show the form for creating a new brand.
     */
    public function create()
    {
        return view('Dashboard.Brand.create');
    }

    /**
     * Store a newly created brand in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand_name' => 'required|string|unique:brands,name|max:255',
            'description' => 'nullable|string',
            'logo' => 'required|file|mimes:jpeg,png,jpg,svg|max:2048',
            'cover' => 'required|file|mimes:jpeg,png,jpg,svg|max:4096',
            'organization_license' => 'required|string',
            'commercial_registry_extract' => 'required|string',
            'tax_registry' => 'required|string',
        ]);

        try {
            
            $validated['logo'] = 'Uploads/' . $request->file('logo')->storePublicly('Logos', 'public');
            $validated['cover'] = 'Uploads/' . $request->file('cover')->storePublicly('Covers', 'public');

            $brand = Brand::create([
                'name' => $validated['brand_name'],
                'slug' => Str::slug($validated['brand_name']),
                'description' => $validated['description'],
                'logo' => $validated['logo'],
                'cover' => $validated['cover'],
                'organization_license' => encrypt($validated['organization_license']),
                'commercial_registry_extract' => encrypt($validated['commercial_registry_extract']),
                'tax_registry' => encrypt($validated['tax_registry']),
            ]);

            return redirect()->route('dashboard.brands.admin.create', $brand)
                ->with('success', 'Brand created. Please assign an admin.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Failed to upload files or save brand.']);
        }
    }

    /**
     * Show the form for creating a brand admin.
     */
    public function createAdmin()
    {
        $brand_admin = Auth::guard('brand_admin')->user();
        $brand = Brand::find($brand_admin->brand_id);
        return view('Dashboard.Brand.BrandAdmin.create', compact('brand'));
    }

    /**
     * Store a newly created brand admin in storage.
     */
    public function storeAdmin(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:brand_admins,name|max:255',
            'email' => 'required|email|unique:brand_admins,email|max:255',
            'password' => 'required|min:8|confirmed',
            'is_super_brand_admin' => 'required|boolean',
        ]);

        try {
        $brand_admin = Auth::guard('brand_admin')->user();
        // dd($brand_admin);
        $brand = $brand_admin->brand_id;

                BrandAdmin::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'brand_id' => $brand,
                    'is_super' => $request->boolean('is_super_brand_admin'),
                ]);

            return redirect()->route('dashboard.brands.admin.create', $brand)
                ->with('success', 'Admin assigned to brand.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Failed to assign admin.']);
        }
    }

    /**
     * Display the specified brand.
     */
    public function show(Brand $brand)
    {
        $brand->load('brand_admin');
        return view('Dashboard.Brand.show', compact('brand'));
    }

    /**
     * Remove the specified brand from storage.
     */
    public function destroy(Brand $brand)
    {
        try {
            $brand->delete();
            return redirect()->route('dashboard.brands.index')
                ->with('success', 'Brand deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete brand.']);
        }
    }
}
