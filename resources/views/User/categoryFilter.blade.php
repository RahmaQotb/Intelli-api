@extends('User.layout')
@section('body')

    <section id="featured-products" class="product-store padding-large">
        <div class="container">
            <div class="section-header d-flex flex-wrap align-items-center justify-content-between">
                <h2 class="section-title">All Products</h2>
                {{-- <div class="btn-wrap"> --}}
                {{-- <a href="allProducts" class="d-flex align-items-center">View all products <i class="icon icon icon-arrow-io"></i></a> --}}
                {{-- </div>             --}}
            </div>
                <div class="swiper product-swiper overflow-hidden">
                    @foreach ($category as $cat)
                    <ul class="nav justify-content-end">
                        <li class="nav-item">
                          <a class="nav-link active" aria-current="page" href="#">{{$cat->name}}</a>
                      </ul>
                      @endforeach
                      
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                          @foreach ($products as $product)
                          @if($product->quantity)

                            <div class="product-item">
                                <div class="image-holder">
                                    <img src="{{ $product->getFirstMediaUrl('images') }}" alt="Books"
                                        class="product-image">
                                </div>
                                <div class="cart-concern">
                                    <div class="cart-button d-flex justify-content-between align-items-center">
                                        <button type="button" class="btn-wrap cart-link d-flex align-items-center">add to
                                            cart <i class="icon icon-arrow-io"></i>
                                        </button>
                                        <a href="{{ route('product.show', $product->id) }}">
                                        <button type="button" class="view-btn tooltipd-flex">
                                            <i class="icon icon-screen-full"></i>
                                            <span class="tooltip-text">Quick view</span>
                                        </button>
                                        </a>
                                        <button type="button" class="wishlist-btn">
                                            <i class="icon icon-heart"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="product-detail">
                                    <h3 class="product-title">
                                        <a href="single-product.html">{{$product->name}}</a>
                                    </h3>
                                    <span class="item-price text-primary">${{$product->price}}</span>
                                </div>
                            </div>
                        </div>
                        @else

                        <div class="product-item">
                          <div class="image-holder">
                              <img src="{{ $product->getFirstMediaUrl('images') }}" alt="Books"
                                  class="product-image">
                          </div>
                          <div class="cart-concern">
                              <div class="cart-button d-flex justify-content-between align-items-center">
                                  <button type="button" class="btn-wrap cart-link d-flex align-items-center">add to
                                      cart <i class="icon icon-arrow-io"></i>
                                  </button>
                                  <a href="{{ route('product.show', $product->id) }}">
                                  <button type="button" class="view-btn tooltipd-flex">
                                      <i class="icon icon-screen-full"></i>
                                      <span class="tooltip-text">Quick view</span>
                                  </button>
                                  </a>  
                                  <button type="button" class="wishlist-btn">
                                      <i class="icon icon-heart"></i>
                                  </button>
                              </div>
                          </div>
                          <div class="product-detail">
                              <h3 class="product-title">
                                  <a href="single-product.html">{{$product->name}}</a>
                              </h3>
                              <span class="item-price text-primary">Out of stock!</span>
                          </div>
                      </div>
                  </div>
                        @endif
                        @endforeach
                    
                    </div>
                </div>
                <div class="swiper-pagination"></div>
        </div>
    </section>
@endsection
