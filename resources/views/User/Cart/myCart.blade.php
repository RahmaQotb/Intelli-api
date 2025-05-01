@extends('User.layout')
@section('title')
    My Cart
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
                <h2 class="section-title">My Cart</h2>
            </div>

            <div class="container">
                <div class="row" style="justify-content: space-evenly">
                    @if($cart && $cart->cart_items->isNotEmpty())
                        @foreach ($cart->cart_items as $item)
                            <div class="card col-3 shadow border">
                                <div class="image-holder card-header">
                                    @if($item->product)
                                        <img src="{{ $item->product->getFirstMediaUrl('images') }}" width="100px" alt="Books" class="product-image">
                                    @else
                                        <p>Product image not available</p>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <div class="product-detail">
                                        <h3 class="product-title">
                                            @if($item->product)
                                                <a href="{{--{{ route('product.show', $item->product->id) }}--}}">{{ $item->product->name }}</a>
                                            @else
                                                <p>Product not found</p>
                                            @endif
                                        </h3>
                                        <span class="item-price text-primary">
                                            @if($item->product)
                                                ${{ $item->product->price }}
                                            @else
                                                Price not available
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>Your cart is empty.</p>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection