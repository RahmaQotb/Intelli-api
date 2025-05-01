@extends('Admin.layout')

@section('body')
    @include('errors')
    @include('success')

    <form method="POST" action="{{ route('Store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name">Category Name</label>
            <input 
                type="text" 
                name="name" 
                class="form-control text-white" 
                id="name" 
                placeholder="Enter name"
                value="{{ old('name') }}"
            >
        </div>

        <div class="form-group">
            <label for="slug">Slug</label>
            <input 
                type="text" 
                name="slug" 
                class="form-control text-white" 
                id="slug" 
                placeholder="Enter slug"
                value="{{ old('slug') }}"
            >
        </div>

        <div class="form-group">
            <label for="description">Category Description</label>
            <textarea 
                name="description" 
                class="form-control text-white" 
                id="description" 
                placeholder="Enter description"
            >{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="image">Category Image</label>
            <input 
                type="file" 
                name="image" 
                class="form-control-file text-white" 
                id="image"
            >
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
