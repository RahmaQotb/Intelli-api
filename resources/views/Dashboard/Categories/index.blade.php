@extends('Dashboard.layouts.layouts')

@section('title')
    Categories - Dashboard
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
        </style>
    @endsection
    @section('scripts')
        <script src="{{ asset('Dashboard/assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
        <script src="{{ asset('Dashboard/assets/static/js/pages/simple-datatables.js') }}"></script>
    @endsection
    <div class="page-heading">
        <h3>Categories</h3>
    </div>

    @include('messages.errors')
    @include('messages.success')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    All Categories
                </h5>
            </div>
            <div style="display: flex; gap: 10px; margin-top: 5px; padding: 0 50px; justify-content: flex-end;">
                <a href="{{route('dashboard.categories.create')}}" class="btn  btn-success" rel="noopener noreferrer">
                    Add Category
                </a>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Sub Categories</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $category->name }}</td>
                                                <td>{{ \Illuminate\Support\Str::limit($category->description, 50, '...') }}</td>
                                                <td>
                                                    <div style="display: flex; gap: 5px;">
                                                        @php
                                                            if ($category->subCategories->isEmpty()) {
                                                                echo "-";
                                                            } else {
                                                                foreach ($category->subCategories as $sub_cat) {
                                                                    echo '<span style="background-color: #e0e0e0;color:black; padding: 4px 8px; border-radius: 12px; font-size: 12px;">' . e($sub_cat->name) . '</span>';
                                                                }
                                                            }
                                                        @endphp
                                                    </div>
                                                </td>
                                                <td>
                                                    <img src="{{ asset($category->image) }}" alt="Category Image" class="category-img">
                                                </td>
                                                <td> <!-- دمج التعديل والحذف هنا -->
                                                    <div style="display: flex; gap: 5px;">
                                                        <a href="{{ route('dashboard.categories.edit', $category->id) }}"
                                                            class="btn btn-sm btn-outline-primary">
                                                            Edit
                                                        </a>
                                                        <form action="{{ route('dashboard.categories.destroy', $category->id) }}" method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">No Categories</td>
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