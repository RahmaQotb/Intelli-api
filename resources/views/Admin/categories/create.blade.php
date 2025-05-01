@extends('Admin.layout')
@section('body')
@include('errors')
@include('success')
<form method="POST" action="{{route('Store')}}" enctype="multipart/form-data">
@csrf
<div class="form-group">
  <label for="exampleInputEmail1">Category Name</label>
  <input type="text" name="name" class="form-control text-white" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter name">
</div>

<div class="form-group">
    <label for="exampleInputEmail1">Category Description</label>
    <textarea type="text" name="description" class="form-control text-white" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter desc"></textarea>
  </div>
{{-- 
  <div class="form-group">
    <label for="exampleInputEmail1">Category Name</label>
   <select name="category_id" id="">
    @foreach ($categories as $category)
    <option value="{{$category->id}}">{{$category->name}}</option>    
    @endforeach
    
   </select> --}}
  
<button type="submit" class="btn btn-primary">Submit</button>
</form>


@endsection