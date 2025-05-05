@extends('Dashboard.layouts.layouts')

@section('title')
    Admin - VOLNA
@endsection
@section('content')
    <form method="POST" action="{{ route('dashboard.admin.add') }}" enctype="multipart/form-data">
        @csrf
        <div class="page-heading">
            <h3>Admin</h3>
        </div>
        @include('messages.errors')
        @include('messages.success')
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Admin</h4>
                </div>

                <div class="card-body">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input autocomplete="off" type="text" class="form-control" name="name" id="name" placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" autocomplete="off" class="form-control" name="email" id="email" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" autocomplete="off" class="form-control" name="password" id="password" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Password Confirmation</label>
                                <input type="password" autocomplete="off" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="">
                            </div>


                        </div>
                    </div>
                    <div class="d-flex mt-2 justify-content-center">
                        <button class="btn btn-primary">Create</button>
                    </div>
                </div>
            </div>
    </form>
    </section>
@endsection
