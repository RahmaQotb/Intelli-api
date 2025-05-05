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
    <form method="POST" action="{{ route('dashboard.sub_categories.update',$sub_category->id) }}" enctype="multipart/form-data">
        @csrf
        {{-- @method('PUT') --}}
        <div class="page-heading">
            <h3>Sub Category</h3>
        </div>
        @include('messages.errors')
        @include('messages.success')
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Update Sub Category</h4>
                </div>

                <div class="card-body">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input autocomplete="off" type="text" class="form-control" name="name" id="name" value="{{$sub_category->name}}" placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea autocomplete="off" class="form-control" name="description" id="description"  placeholder="">{{$sub_category->description}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select name="category_id" class="form-select" id="category_id">
                                    @foreach ($categories as $category )
                                    <option @selected( $sub_category->category_id==$category->id) value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="col-md-6">

                            <div class="form-group">

                                <label for="image">Image</label>
                                <input type="file" accept="image/*" id="image" name="image" class="form-control" placeholder="">
                                @if($sub_category->image)
                                    <div class="mt-2">
                                        <img src="{{ asset($sub_category->image) }}" alt="{{ $sub_category->name }}" width="150">
                                        <p class="text-muted">Current image. Upload a new one to replace it.</p>
                                    </div>
                                @endif</div>
                            

                        </div>
                    </div>
                    <div class="d-flex mt-3 justify-content-center">
                        <button type="submit" class="btn btn-primary">Update Sub Category</button>
                        <a href="{{ route('dashboard.sub_categories.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                    </div>
                </div>
            </div>
    </form>
    </section>
@endsection
