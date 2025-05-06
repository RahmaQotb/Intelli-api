@extends('Dashboard.layouts.layouts')

@section('title')
    Products - VOLNA
@endsection
@section('content')
    <form method="POST" action="{{ route('dashboard.products.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="page-heading">
            <h3>Products</h3>
        </div>
        @include('messages.errors')
        @include('messages.success')
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Product</h4>
                </div>

                <div class="card-body">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input autocomplete="off" type="text" class="form-control" name="name" id="name" placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea autocomplete="off" class="form-control" name="description" id="description" placeholder=""></textarea>
                            </div>

                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input autocomplete="off" type="number" class="form-control" name="quantity" id="quantity" placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select name="category_id" class="form-select" id="category_id">
                                    @foreach ($categories as $category )
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="sub_category_id">Sub Category</label>
                                <select name="sub_category_id" class="form-select" id="sub_category_id">
                                    <option></option>
                                    @foreach ($sub_categories as $sub_category )
                                    <option value="{{$sub_category->id}}">{{$sub_category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="brand_id">Brand</label>
                                <select name="brand_id" class="form-select" id="brand_id">
                                    @foreach ($brands as $brand )
                                    <option value="{{$brand->id}}">{{$brand->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" accept="image/*" id="image" name="image" class="form-control" placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="price">Price</label>
                                <input autocomplete="off" type="number" class="form-control" name="price" id="price" placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="Discount">Discount</label>
                                <input autocomplete="off" type="number" class="form-control" name="discount_in_percentage" id="Discount" placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="condition">Condition</label>
                                <select name="condition" class="form-select" id="condition">
                                    <option value="Default">Default</option>
                                    <option value="New">New</option>
                                    <option value="Hot">Hot</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" class="form-select" id="status">
                                    <option value="active">active</option>
                                    <option value="archieved">archieved</option>
                                </select>
                            </div>

                                
                        </div>
                    </div>
                    <div class="d-flex mt-2 justify-content-center">
                        <button class="btn btn-primary">Create</button>
                        <a href="{{ route('dashboard.products.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                    </div>
                </div>
            </div>
    </form>
    </section>
@section('script')
<script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
</script>
@endsection
@endsection
