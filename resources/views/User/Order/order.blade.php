@extends('User.layout')
@section('title')
    Order Items
@endsection
@section('styles')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.7.4/axios.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="{{ asset('User/js/cart.js') }}"></script>
@endsection

@section('body')
    <section id="featured-products" class="product-store padding-large">
        <div class="container">
            <div class="section-header d-flex flex-wrap align-items-center justify-content-between">
                <section>
                    <div class="container">
                      <div class="row">
                        <div class="col-md-12">
                <h2 class="section-title">Orders Items</h2>
                <div class="row">
                    <div class="col-md-12">
                      <hr>
                      <table class="u-full-width">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total Price</th>

                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($order_items as $order_item)
                                
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$order_item->product->name}}</td>
                            <td>{{$order_item->product->description}}</td>
                            <td>{{$order_item->product->price}}</td>
                            <td>{{$order_item->quantity}}</td>
                            <td>{{$order_item->quantity*$order_item->product->price}}</td>
                          </tr>
                          @endforeach

                        </tbody>
                      </table>
                    </div>
                  </div>
                {{-- <div class="btn-wrap"> --}}
                {{-- <a href="allProducts" class="d-flex align-items-center">View all products <i class="icon icon icon-arrow-io"></i></a> --}}
                {{-- </div>             --}}
            </div>
        </div>
    </div>
    <div class="swiper-pagination"></div>
</div>
</section>
@endsection