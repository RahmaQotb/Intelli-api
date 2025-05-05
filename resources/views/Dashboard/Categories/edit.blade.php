@extends('Dashboard.layouts.layouts')

@section('title')
    Category - VOLNA
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('Dashboard/assets/compiled/css/table-datatable.css') }}">
    <style>
        .category-img {
            width: 70px;
            height: auto;
            object-fit: contain;
            border-radius: 5px;
        }
    </style>
@endsection
@section('content')
    <form method="POST" action="{{ route('dashboard.categories.update',$category->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="page-heading">
            <h3>Category</h3>
        </div>
        @include('messages.errors')
        @include('messages.success')
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Update Category</h4>
                </div>

                <div class="card-body">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input autocomplete="off" type="text" class="form-control" name="name" id="name" value="{{$category->name}}" placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea autocomplete="off" class="form-control" name="description" id="description"  placeholder="">{{$category->description}}</textarea>
                            </div>


                        </div>
                        <div class="col-md-6">

                            <div class="form-group">

                                <label for="image">Image</label>
                                <input type="file" accept="image/*" id="image" name="image" class="form-control" placeholder="">
                                @if($category->image)
                                    <div class="mt-2">
                                        <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" width="150">
                                        <p class="text-muted">Current image. Upload a new one to replace it.</p>
                                    </div>
                                @endif
                            </div>


                        </div>
                    </div>
                    <div class="d-flex mt-3 justify-content-center">
                        <button type="submit" class="btn btn-primary">Update Category</button>
                        <a href="{{ route('dashboard.categories.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                    </div>
                </div>
            </div>
    </form>
    </section>
@endsection
