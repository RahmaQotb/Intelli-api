@extends('Dashboard.layouts.layouts')

@section('title')
    Sub Categories - Dashboard
@endsection

@section('content')
    @section('css')
        {{--
        <link rel="stylesheet" href="{{asset('Dashboard/assets/extensions/simple-datatables/style.css')}}"> --}}
        <link rel="stylesheet" href="{{ asset('Dashboard/assets/compiled/css/table-datatable.css') }}">
        <style>
            .sub_category-img {
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
        <h3>Sub Categories</h3>
    </div>

    @include('messages.errors')
    @include('messages.success')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    All Sub Categories
                </h5>
            </div>
            <div style="display: flex; gap: 10px; margin-top: 5px; padding: 0 50px; justify-content: flex-end;">
                <a href="{{route('dashboard.sub_categories.create')}}" class="btn  btn-success" rel="noopener noreferrer">
                    Add Sub Category
                </a>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sub_categories as $sub_category)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $sub_category->name }}</td>
                                                <td>{{ \Illuminate\Support\Str::limit($sub_category->description, 50, '...') }}</td>
                                                <td>
                                                    <div style="display: flex; gap: 5px;">
                                                                    <span style="background-color: #e0e0e0;color:black; padding: 4px 8px; border-radius: 12px; font-size: 12px;"> {{e($sub_category->category->name)}}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <img src="{{ asset($sub_category->image) }}" alt="Category Image" class="sub_category-img">
                                                </td>
                                                <td> <!-- دمج التعديل والحذف هنا -->
                                                    <div style="display: flex; gap: 5px;">
                                                        <a href="{{ route('dashboard.sub_categories.edit', $sub_category->id) }}"
                                                            class="btn btn-sm btn-outline-primary">
                                                            Edit
                                                        </a>
                                                        <form action="{{ route('dashboard.sub_categories.destroy', $sub_category->id) }}" method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">No Sub Categories</td>
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