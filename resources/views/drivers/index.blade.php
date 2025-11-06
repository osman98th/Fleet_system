@extends('layouts.app')

@section('title', 'Driver List')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">🚚 Driver List</h3>
        <a href="{{ route('drivers.create') }}" class="btn btn-success btn-sm">+ Add Driver</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-bordered mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Driver ID</th>
                            <th>Name</th>
                            <th>License</th>
                            <th>Phone</th>
                            <th>Vehicle Type</th>
                            <th>Route</th>
                            <th>Status</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($drivers as $driver)
                        <tr>
                            <td>{{ $driver->id }}</td>
                            <td>{{ $driver->name }}</td>
                            <td>{{ $driver->license_number }}</td>
                            <td>{{ $driver->phone }}</td>
                            <td>{{ $driver->vehicle->type ?? 'Not Assigned' }}</td>
                            <td>{{ $driver->route ?? 'N/A' }}</td>
                            <td>
                                @if(strtolower($driver->status) == 'available')
                                    <span class="badge bg-success">{{ $driver->status }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ $driver->status }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('drivers.edit', $driver->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('drivers.destroy', $driver->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete this driver?')" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-3">No drivers found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
