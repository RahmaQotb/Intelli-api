@extends('Dashboard.layouts.layouts')

@section('title')
    {{ $brand->name }} Details - VOLNA
@endsection

@section('content')
<div class="page-heading">
    <h3>{{ $brand->name }}</h3>
</div>
@include('messages.errors')
@include('messages.success')

<section class="section">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Brand Details</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Brand Info</h5>
                    <p><strong>Name:</strong> {{ $brand->name }}</p>
                    <p><strong>Slug:</strong> {{ $brand->slug }}</p>
                    <p><strong>Description:</strong> {{ $brand->description ?? 'N/A' }}</p>
                    <p><strong>Status:</strong> {{ $brand->status ? 'Active' : 'Inactive' }}</p>
                    <p><strong>Logo:</strong> <img src="{{ Storage::url($brand->logo) }}" alt="Logo" width="100"></p>
                    <p><strong>Cover:</strong> <img src="{{ Storage::url($brand->cover) }}" alt="Cover" width="200"></p>
                </div>
                <div class="col-md-6">
                    <h5>Admin Info</h5>
                    @if($brand->brand_admin)
                        <p><strong>Name:</strong> {{ $brand->brand_admin->name }}</p>
                        <p><strong>Email:</strong> {{ $brand->brand_admin->email }}</p>
                        <p><strong>Super Admin:</strong> {{ $brand->brand_admin->is_super_brand_admin ? 'Yes' : 'No' }}</p>
                    @else
                        <p>No admin assigned.</p>
                        <a href="{{ route('dashboard.brands.admin.create', $brand) }}" class="btn btn-primary">Assign Admin</a>
                    @endif
                </div>
            </div>
            <div class="d-flex mt-4 justify-content-center">
                <a href="{{ route('dashboard.brands.index') }}" class="btn btn-secondary">Back to Brands</a>
                <form action="{{ route('dashboard.brands.destroy', $brand) }}" method="POST" class="ms-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete Brand</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection