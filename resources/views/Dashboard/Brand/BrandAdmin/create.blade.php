@extends('Dashboard.layouts.layouts')

@section('title')
    Add Admin for {{ $brand->name }} - VOLNA
@endsection

@section('content')
<form method="POST" action="{{ route('dashboard.brands.admin.store', $brand) }}" enctype="multipart/form-data">
    @csrf
    <div class="page-heading">
        <h3>Add Admin for {{ $brand->name }}</h3>
    </div>
    @include('messages.errors')
    @include('messages.success')

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Create Brand Admin</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h5>Admin Info</h5>

                        <input type="hidden" name="brand_id" value="{{ $brand->id }}">

                        <div class="form-group">
                            <label for="name">Admin Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Admin Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Admin Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation" required>
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="is_super_brand_admin">Is Super Admin?</label>
                            <select name="is_super_brand_admin" id="is_super_brand_admin" class="form-select @error('is_super_brand_admin') is-invalid @enderror">
                                <option value="0" {{ old('is_super_brand_admin', 0) == 0 ? 'selected' : '' }}>No</option>
                                <option value="1" {{ old('is_super_brand_admin', 0) == 1 ? 'selected' : '' }}>Yes</option>
                            </select>
                            @error('is_super_brand_admin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex mt-4 justify-content-center">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="{{ route('dashboard.brands.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                </div>
            </div>
        </div>
    </section>
</form>
@endsection