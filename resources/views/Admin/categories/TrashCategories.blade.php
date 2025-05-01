@extends('Admin.layout')

@section('css')
    <link id="app-css" rel="stylesheet"
        href="{{ session('locale', 'en') == 'ar' ? asset('assets/Admin/compiled/css/table-datatable.rtl.css') : asset('assets/Admin/compiled/css/table-datatable.css') }}" />
@endsection
@section('js')
    <script src="{{ asset('assets/Admin/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/Admin/static/js/pages/simple-datatables.js') }}"></script>
@endsection

@section('body')
    @include('success')
    @include('errors')

    <div class="card">
        <div class="card-body">

            <table id="table1" class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Category ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Created_at</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->description}}</td>
                            <td>{{ $category->created_at }}</td>
                            <td>
                                <form method="POST" action="{{ route("restore" , $category->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success">Restore</button>

                                </form>
                            </td>
                            <td>
                            <form action="{{route("forceDelete",$category->id)}}" method="POST">
                                @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete Permanently</button>
                            </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
