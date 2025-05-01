@extends('User.layout')
@section('body')
    @include('success')
@if(!$product->quantity)
<div class="container mt-5 w-50" >
  <div class="card" style="width: 20rem;">
    <img src="{{ $product->getFirstMediaUrl('images') }}" class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title">{{$product->name}}</h5>
     <h6> <p class="card-text">Out of stock!</p></h6>
      <p class="card-text">Descripton: {{$product->description}}</p>
      <p class="card-text">{{$category->name}}</p>
      <a href="{{url("")}}" class="btn btn-outline-success"> Continue shopping</a>
    </div>
  </div>
</div>

    @else 
    <div class="container mt-3 w-50" >
      <div class="card" style="width: 20rem;">
        <img src="{{ $product->getFirstMediaUrl('images') }}" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title"><b>{{$product->name}} </b></h5>
         <h6> <p class="card-text">Price:${{$product->price}}</p></h6>
         <form action="{{url("addtocart/$product->id")}}" method="POST">
          @csrf
          <select name="qty">
            @for ($i = 1; $i <= $product->quantity; $i++)
            <option value="{{$i}}"> {{$i}}</option>                       
            @endfor
          </select>
          <button type="submit" class="btn btn-success m-3"> add to cart</button>  
        </form>
          <p class="card-text">Descripton: {{$product->description}}</p>
          <p class="card-text">{{$category->name}}</p>
          <a href="{{url("")}}" class="btn btn-outline-success"> Continue shopping</a>
        </div>
      </div>
    </div>
    @endif
  @endsection