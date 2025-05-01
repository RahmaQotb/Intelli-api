@extends("Admin.layout")
@section('body')
@include("success")
<div class="card" style="width: 18rem;">
    <img src="{{ $product->getFirstMediaUrl('images') }}" class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title">{{$product->name}}</h5>
      <p class="card-text">Description:{{$product->description}}</p>
      <p class="card-text">Price:{{$product->price}}</p>
      <p class="card-text">Quantity:{{$product->quantity}}</p>

      <form action="{{url("admin/products/$product->id")}}" method="post">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
    <h1>
        <a class="btn btn-success" href="{{url("admin/products/edit/$product->id")}}" >Edit</a> 
           </div>
  </div>


@endsection