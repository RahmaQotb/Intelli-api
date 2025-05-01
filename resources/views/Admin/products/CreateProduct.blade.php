@extends('Admin.layout')
@section('body')
@include('errors')
@include('success')
<form method="POST" action="{{route('store')}}" enctype="multipart/form-data">
@csrf
<div class="form-group">
  <label for="exampleInputEmail1">Product Name</label>
  <input type="text" name="name" class="form-control text-white" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter name">
</div>

<div class="form-group">
    <label for="exampleInputEmail1">Product Description</label>
    <textarea type="text" name="description" class="form-control text-white" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter desc"></textarea>
  </div>

  <div class="form-group">
    <label for="exampleInputEmail1">Product Price</label>
    <input type="number" name="price" class="form-control text-white" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter price">
  </div>

  <div class="form-group">
    <label for="exampleInputEmail1">Product Quantity</label>
    <input type="text" name="quantity" class="form-control text-white" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Quantity">
  </div>

  <div class="form-group">
    <label for="exampleInputEmail1">Category Name</label>
   <select name="category_id" id="">
    @foreach ($categories as $category)
    <option value="{{$category->id}}">{{$category->name}}</option>    
    @endforeach
    
   </select>
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Product Image</label>
    <input type="file" name="image" class="form-control text-white" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
  </div>

<button type="submit" class="btn btn-primary">Submit</button>
</form>


@endsection