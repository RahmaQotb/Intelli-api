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
    @foreach ($orders as $order)
        
    
        <div class="card" style="width: 18rem;">
            <div class="card-body">
            <h5 class="card-title">{{$loop->iteration}}</h5>
            <h5 class="card-title">Product Name : {{$order->product->name}}</h5>
            <p class="card-text">Category : {{$order->product->category->name}}</p>
            </div>
            <ul class="list-group list-group-flush">
            <li class="list-group-item">Product Price : {{$order->price}}</li>
            <li class="list-group-item">Ordered Quantity : {{$order->quantity}}</li>
            <li class="list-group-item">Total Price of the Product : {{$order->price * $order->quantity}}</li>
            <li class="list-group-item"><a class="btn btn-success" href="{{ url("admin/products/show/$order->product_id") }}">Show</a></li>
        </ul>
            
        </div>
        @endforeach

        
@endsection