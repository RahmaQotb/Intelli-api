@extends('Admin.layout')

@section('body')
    @include('success')

    <div class="container mt-4">
        <h2 class="mb-4">Category Details</h2>

        <table class="table table-bordered border-success">
            <tr>
                <th>ID</th>
                <td>{{ $category->id }}</td>
            </tr>
            <tr>
                <th>Name</th>
                <td>{{ $category->name }}</td>
            </tr>
            <tr>
                <th>Slug</th>
                <td>{{ $category->slug }}</td>
            </tr>
            <tr>
                <th>Description</th>
                <td>{{ $category->description ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Image</th>
                <td>
                    @if ($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                            >
                    @else
                        No image uploaded.
                    @endif
                </td>
            </tr>
            <tr>
                <th>Created At</th>
                <td>{{ $category->created_at }}</td>
            </tr>
        </table>

    </div>
@endsection
