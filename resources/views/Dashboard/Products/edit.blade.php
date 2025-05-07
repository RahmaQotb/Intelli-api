@extends('Dashboard.layouts.layouts')

@section('title')
    Edit Product - VOLNA
@endsection

@section('content')
    <form method="POST" action="{{ route('dashboard.products.update', $product->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="page-heading">
            <h3>Products</h3>
        </div>
        @include('messages.errors')
        @include('messages.success')
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Product</h4>
                </div>

                <div class="card-body">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input autocomplete="off" type="text" class="form-control" name="name" id="name" value="{{ $product->name }}">
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea autocomplete="off" class="form-control" name="description" id="description">{{ $product->description }}</textarea>
                            </div>


                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input autocomplete="off" type="number" class="form-control" name="quantity" id="quantity" value="{{ $product->quantity }}">
                            </div>

                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select name="category_id" class="form-select" id="category_id">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="sub_category_id">Sub Category</label>
                                <select name="sub_category_id" class="form-select" id="sub_category_id">
                                    <option value=""></option>
                                    @foreach ($sub_categories as $sub_category)
                                        <option value="{{ $sub_category->id }}" {{ $product->sub_category_id == $sub_category->id ? 'selected' : '' }}>{{ $sub_category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="brand_id">Brand</label>
                                <select name="brand_id" class="form-select" id="brand_id">
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" class="form-select" id="status">
                                    <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>active</option>
                                    <option value="archieved" {{ $product->status == 'archieved' ? 'selected' : '' }}>archieved</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" accept="image/*" id="image" name="image" class="form-control">
                                @if($product->image)
                                    <div class="mt-2">
                                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" width="150">
                                        <p class="text-muted">Current image. Upload a new one to replace it.</p>
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="price">Price</label>
                                <input autocomplete="off" type="number" class="form-control" name="price" id="price" value="{{ $product->price }}">
                            </div>

                            <div class="form-group">
                                <label for="Discount">Discount</label>
                                <input autocomplete="off" type="number" class="form-control" name="discount_in_percentage" id="Discount" step="any" value="{{ $product->discount_in_percentage }}">
                            </div>

                            <div class="form-group">
                                <label for="condition">Condition</label>
                                <select name="condition" class="form-select" id="condition">
                                    <option value="Default" {{ $product->condition == 'Default' ? 'selected' : '' }}>Default</option>
                                    <option value="New" {{ $product->condition == 'New' ? 'selected' : '' }}>New</option>
                                    <option value="Hot" {{ $product->condition == 'Hot' ? 'selected' : '' }}>Hot</option>
                                </select>
                            </div>

                            

                            
                        </div>
                    </div>
                    <div class="d-flex mt-3 justify-content-center">
                        <button type="submit" class="btn btn-primary">Update Product</button>
                        <a href="{{ route('dashboard.products.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                    </div>
                </div>
            </div>
        </section>
    </form>

@endsection