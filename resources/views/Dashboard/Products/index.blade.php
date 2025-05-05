@extends('Dashboard.layouts.layouts')

@section('title')
    Products - Dashboard
@endsection

@section('content')
    @section('css')
        {{--
        <link rel="stylesheet" href="{{asset('Dashboard/assets/extensions/simple-datatables/style.css')}}"> --}}
        <link rel="stylesheet" href="{{ asset('Dashboard/assets/compiled/css/table-datatable.css') }}">
        <style>
            .category-img {
                width: 70px;
                height: auto;
                object-fit: contain;
                border-radius: 5px;
            }
            .size-badge {
                background-color: #eef2ff; /* Light indigo color */
                color: #180cfc; /* Indigo text */
                padding: 2px 6px; /* Smaller padding */
                border-radius: 8px; /* Slightly less rounded */
                font-size: 10px; /* Smaller font */
                margin-right: 3px;
                margin-bottom: 3px;
                display: inline-block;
                border: 1px solid #c7d2fe; /* Light border */
            }
            .category-badge {
                background-color: #e0e0e0;
                color: black;
                padding: 4px 8px;
                border-radius: 12px;
                font-size: 12px;
            }
        </style>
    @endsection
    @section('scripts')
        <script src="{{ asset('Dashboard/assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
        <script src="{{ asset('Dashboard/assets/static/js/pages/simple-datatables.js') }}"></script>
    @endsection
    <div class="page-heading">
        <h3>Products</h3>
    </div>

    @include('messages.errors')
    @include('messages.success')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    All Products
                </h5>
            </div>
            <div style="display: flex; gap: 10px; margin-top: 5px; padding: 0 50px; justify-content: flex-end;">
                <a href="{{route('dashboard.products.create')}}" class="btn  btn-success" rel="noopener noreferrer">
                    Add Product
                </a>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Discount</th>
                            <th>Final Price</th>
                            <th>Status</th>
                            <th>Category</th>
                            <th>Sub Category</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ \Illuminate\Support\Str::limit($product->description, 50, '...') ?? '-' }}</td>
                                                <td>{{ $product->quantity }}</td>
                                                <td>{{ $product->price }}</td>
                                                <td>{{ $product->discount_in_percentage?$product->discount_in_percentage . '%' : '-' }}</td>
                                                <td>{{ $product->total_price }}</td>
                                                <td>{{ $product->status }}</td>
                                                <td>
                                                    <div style="display: flex; gap: 5px;">
                                                        <span class="category-badge" style="background-color: #e0e0e0;color:black; padding: 4px 8px; border-radius: 12px; font-size: 12px;">{{e($product->category->name)}} </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($product->subCategory?->name)
                                                    <div style="display: flex; gap: 5px;">
                                                        <span class="category-badge" style="background-color: #e0e0e0;color:black; padding: 4px 8px; border-radius: 12px; font-size: 12px;">{{e($product->subCategory->name)}} </span>
                                                    </div>
                                                    @else
                                                    -
                                                    @endif
                                                    
                                                </td>
                                                <td>
                                                    <img src="{{ asset($product->image) }}" alt="Product Image" class="category-img">
                                                </td>
                                                <td> <!-- دمج التعديل والحذف هنا -->
                                                    <div style="display: flex; gap: 5px;">
                                                        <a href="{{ route('dashboard.products.edit', $product->id) }}"
                                                            class="btn btn-sm btn-outline-primary">
                                                            Edit
                                                        </a>
                                                        <form action="{{ route('dashboard.products.destroy', $product->id) }}" method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                        @empty
                            <tr>
                                <td colspan="14">No Product</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>

    </section>
@endsection
{{--

{{
$category->subCategories->map(function($sub_cat){
return $sub_cat->name;
})
}}



--}}
