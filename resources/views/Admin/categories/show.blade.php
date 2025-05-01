@extends("Admin.layout")
@section('body')
@include("success")

{{-- Category Name:{{$category->name}}<br> --}}
{{-- Category Description:{{$category->desc}}<br> --}}
{{-- Product Price:{{$product->price}}<br>
Product Quantity:{{$product->quantity}}<br>
Product Image:<br>
<img src="{{url(asset("storage/$product->image"))}}" alt="" srcset="" > --}}
   
{{-- <form action="{{url("products/$product->id")}}" method="post">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Delete</button>
</form> --}}
{{-- <h1> --}}
    {{-- <a class="btn btn-success" href="{{url("products/edit/$product->id")}}" >Edit</a>   --}}

    <table class="table table-bordered border-success">
        <thead>
          <tr>
            <th> #ID</th>
            <th> Name</th>
            <th>Description</th>
                    
          </tr>
          </thead>
          <tbody>
            <tr class="table-active">
                
            </tr>
            <tr class="table-active" scope="row">
              
            </tr>
            <tr>
              <th scope="row">{{$category->id}}</th>
              <td >{{$category->name}}</td>
              <td>{{$category->description}}</td>
            </tr>
          </tbody>
      </table>
      <br>
      <h1> 
        <form action="{{url("admin/categories/$category->id")}}" method="post">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">Delete</button>
      </form>
    
        <a class="btn btn-primary" href="{{url("admin/categories/edit/$category->id")}}" >Edit</a>  
    
@endsection