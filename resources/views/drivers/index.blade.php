@extends('layouts.app')
@section('title', 'Driver List')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Driver List</h4>
            <a href="{{ route('drivers.create') }}" class="btn btn-light btn-sm">+ Add New Driver</a>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Driver ID</th>
                        <th>Name</th>
                        <th>License</th>
                        <th>Phone</th>
                        <th>Vehicle Type</th>
                        <th>Route</th>
                        <th>Status</th>
                        <th width="160">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($drivers as $driver)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $driver->driver_id }}</td>
                        <td>{{ $driver->name }}</td>
                        <td>{{ $driver->license_number }}</td>
                        <td>{{ $driver->phone }}</td>
                        <td>{{ $driver->vehicle_type }}</td>
                        <td>{{ $driver->route }}</td>
                        <td>
                            <span class="badge bg-{{ $driver->status == 'Available' ? 'success' : 'danger' }}">
                                {{ $driver->status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('drivers.edit', $driver->id) }}" class="btn btn-sm btn-warning">Edit</a>

                            <form action="{{ route('drivers.destroy', $driver->id) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>
@endsection
