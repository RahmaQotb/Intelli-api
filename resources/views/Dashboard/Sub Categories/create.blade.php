@extends('Dashboard.layouts.layouts')

@section('title')
    Sub Category - VOLNA
@endsection
@section('content')
    <form method="POST" action="{{ route('dashboard.sub_categories.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="page-heading">
            <h3>Sub Category</h3>
        </div>
        @include('messages.errors')
        @include('messages.success')
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Sub Category</h4>
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
        
                            
                        </div>
                        <div class="col-md-6">
                            
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" accept="image/*" id="image" name="image" class="form-control" placeholder="">
                            </div>
        
                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select name="category_id" class="form-select" id="category_id">
                                    @foreach ($categories as $category )
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex mt-2 justify-content-center">
                        <button class="btn btn-primary">Create</button>
                        <a href="{{ route('dashboard.sub_categories.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                    </div>
                </div>
            </div>
    </form>
    </section>
@endsection
