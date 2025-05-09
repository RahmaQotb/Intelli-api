<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        return response()->json([
            'status' => true,
            'message' => 'Brands retrieved successfully.',
            'data' => BrandResource::collection($brands)
        ], 200);
    }
}