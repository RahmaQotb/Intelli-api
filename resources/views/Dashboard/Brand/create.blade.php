@extends('Dashboard.layouts.layouts')

@section('title')
    Add Brand - VOLNA
@endsection

@section('content')
<form method="POST" action="{{ route('dashboard.brands.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="page-heading">
        <h3>Add Brand</h3>
    </div>
    @include('messages.errors')
    @include('messages.success')

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Create Brand</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h5>Brand Info</h5>

                        <div class="form-group">
                            <label for="brand_name">Brand Name</label>
                            <input type="text" class="form-control @error('brand_name') is-invalid @enderror" name="brand_name" id="brand_name" value="{{ old('brand_name') }}" required>
                            @error('brand_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="logo">Logo</label>
                            <input type="file" class="form-control @error('logo') is-invalid @enderror" name="logo" id="logo" required>
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="cover">Cover</label>
                            <input type="file" class="form-control @error('cover') is-invalid @enderror" name="cover" id="cover" required>
                            @error('cover')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="organization_license">Organization License</label>
                            <input type="text" class="form-control @error('organization_license') is-invalid @enderror" name="organization_license" value="{{ old('organization_license') }}" required>
                            @error('organization_license')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="commercial_registry_extract">Commercial Registry Extract</label>
                            <input type="text" class="form-control @error('commercial_registry_extract') is-invalid @enderror" name="commercial_registry_extract" value="{{ old('commercial_registry_extract') }}" required>
                            @error('commercial_registry_extract')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tax_registry">Tax Registry</label>
                            <input type="text" class="form-control @error('tax_registry') is-invalid @enderror" name="tax_registry" value="{{ old('tax_registry') }}" required>
                            @error('tax_registry')
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