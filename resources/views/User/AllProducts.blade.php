@extends('User.layout')

@section('title')
    All Products
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
                <h2 class="section-title">All Products</h2>
            </div>

            <!-- Category Filter Links -->
            <ul class="nav justify-content-end">
                @foreach ($categories as $category)
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('categoryFilter', $category->id) }}">
                            {{ $category->name }}
                        </a>
                    </li>
                @endforeach
            </ul>

            <!-- Product List -->
            <div class="container">
                <div class="row" style="justify-content: space-evenly">
                    @foreach ($products as $product)
                        <div class="card col-3 shadow border">
                            <div class="image-holder card-header">
                                <img src="{{ $product->getFirstMediaUrl('images') }}" width="100px" alt="{{ $product->name }}" class="product-image">
                            </div>
                            <div class="card-body">
                                <div class="product-detail">
                                    <h3 class="product-title">
                                        <a href="{{ route('product.show', $product->id) }}">{{ $product->name }}</a>
                                    </h3>
                                    <span class="item-price text-primary">${{ $product->price }}</span>
                                </div>

                                <!-- Stock Information -->
                                @if ($product->quantity > 0)
                                    @if ($product->quantity <= 5)
                                        <div>
                                            <span class="item-price text-primary">Only {{ $product->quantity }} remain in stock</span>
                                        </div>
                                    @endif

                                    <!-- Add to Cart Button -->
                                    <div class="d-flex">
                                        <button type="button" class="btn btn-primary addCartBtn mx-2" value="{{ $product->id }}">
                                            Add to Cart <i class="icon icon-arrow-io"></i>
                                        </button>
                                        <button type="button" class="wishlist-btn">
                                            <i class="icon icon-heart"></i>
                                        </button>
                                    </div>
                                @else
                                    <!-- Out of Stock Message -->
                                    <div class="d-flex">
                                        <button type="button" class="wishlist-btn">
                                            <i class="icon icon-heart"></i>
                                        </button>
                                    </div>
                                    <span class="item-price text-primary">Out of stock!</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Pagination (if applicable) -->
            <div class="swiper-pagination"></div>
        </div>
    </section>
@endsection