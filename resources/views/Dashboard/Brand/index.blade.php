@extends('Dashboard.layouts.layouts')

@section('title')
    Brands - Dashboard
@endsection

@section('content')
@section('css')
    <link rel="stylesheet" href="{{ asset('Dashboard/assets/compiled/css/table-datatable.css') }}">
    <style>
        .brand-img {
            width: 70px;
            height: auto;
            object-fit: contain;
            border-radius: 5px;
        }

        .admin-badge {
            background-color: #f0f4ff;
            color: #2c3e50;
            padding: 5px 8px;
            border-radius: 8px;
            font-size: 12px;
            display: inline-block;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('Dashboard/assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('Dashboard/assets/static/js/pages/simple-datatables.js') }}"></script>
@endsection

<div class="page-heading">
    <h3>Brands</h3>
</div>

@include('messages.errors')
@include('messages.success')

<section class="section">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">All Brands</h5>
        </div>
        <div style="display: flex; gap: 10px; margin-top: 5px; padding: 0 50px; justify-content: flex-end;">
            <a href="{{ route('dashboard.brands.create') }}" class="btn btn-success">Add Brand</a>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="table1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Logo</th>
                        <th>Cover</th>
                        <th>Status</th>
                        <th>License</th>
                        <th>Commercial Registry</th>
                        <th>Tax Registry</th>
                        <th>Admin</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($brands as $brand)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $brand->name }}</td>
                            <td><img src="{{ asset($brand->logo) }}" alt="Logo"
                                    class="brand-img"></td>
                            <td><img src="{{ asset($brand->cover) }}" alt="Cover"
                                    class="brand-img"></td>
                            <td>
                                <span class="badge bg-{{ $brand->status ? 'success' : 'secondary' }}">
                                    {{ $brand->status ? 'Approved' : 'Pending' }}
                                </span>
                            </td>
                            <td><img src="{{ asset($brand->organization_license) }}" alt="Logo"
                                class="brand-img"></td>
                            <td><img src="{{ asset($brand->commercial_registry_extract) }}" alt="Logo"
                                class="brand-img"></td>
                            <td><img src="{{ asset($brand->tax_registry) }}" alt="Logo"
                                class="brand-img"></td>
                            <td>
                                @if ($brand->admin)
                                    <span
                                        class="admin-badge">{{ $brand->admin->name }}<br>{{ $brand->admin->email }}</span>
                                @else
                                    <span class="text-danger">No Admin</span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; gap: 5px;">
                                    <a href="{{ route('dashboard.brands.show', $brand->id) }}"
                                        class="btn btn-sm btn-outline-primary">Show</a>
                                    <form action="{{ route('dashboard.brands.destroy', $brand->id) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">No brands found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
