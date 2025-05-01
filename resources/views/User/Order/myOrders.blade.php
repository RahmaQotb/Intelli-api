@extends('User.layout')
@section('title')
    All Orders
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
                <h2 class="section-title">All Orders</h2>
                <div class="row">
                    <div class="col-md-12">
                      <hr>
                      <table class="u-full-width">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Required Date</th>
                            <th>Ordered At</th>
                            <th>Total Price</th>
                            <th>Details</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                
                          <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$order->require_date}}</td>
                            <td>{{$order->created_at}}</td>
                            <td>{{$order->total_price}}</td>
                            <td><a href="{{url("orders/$order->id")}}"  class="btn btn-success" rel="noopener noreferrer">Show</a></td>
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