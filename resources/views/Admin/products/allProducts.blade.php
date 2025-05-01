@extends('Admin.layout')

@section('css')
    <link id="app-css" rel="stylesheet"
        href="{{ session('locale', 'en') == 'ar' ? asset('assets/Admin/compiled/css/table-datatable.rtl.css') : asset('assets/Admin/compiled/css/table-datatable.css') }}" />
@endsection
@section('js')
    <script src="{{ asset('assets/Admin/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/Admin/static/js/pages/simple-datatables.js') }}"></script>
@endsection

@section('body')
@include("success")
@include("errors")

    <div class="card">
        <div class="card-body">

            <table id="table1" class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Product ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Image</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->quantity }}</td>
                            {{-- <td><img src="{{ asset("storage/{$product->image}") }}" width="100px" alt=""></td> --}}
                            <td> <img src="{{$product->getFirstMediaUrl('images');}}" alt="" srcset="" width="100px"></td>
                            <td>
                                <a class="btn btn-success" href="{{ url("admin/products/show/$product->id") }}">Show</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection