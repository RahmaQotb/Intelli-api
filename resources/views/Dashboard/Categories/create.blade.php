@extends('Dashboard.layouts.layouts')

@section('title')
    Category - VOLNA
@endsection
@section('content')
    <form method="POST" action="{{ route('dashboard.categories.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="page-heading">
            <h3>Category</h3>
        </div>
        @include('messages.errors')
        @include('messages.success')
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Category</h4>
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
        
                            
                        </div>
                    </div>
                    <div class="d-flex mt-2 justify-content-center">
                        <button class="btn btn-primary">Create</button>
                        <a href="{{ route('dashboard.categories.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                    </div>
                </div>
            </div>
    </form>
    </section>
@endsection
