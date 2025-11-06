@extends('layouts.app')
@section('title', 'Vehicle List')

@section('content')

<div class="container py-3">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">🚗 Vehicle List</h3>
        <a href="{{ route('vehicles.create') }}" class="btn btn-primary btn-sm">+ Add New Vehicle</a>
    </div>

    <!-- Filter Dropdowns -->
    <div class="row mb-3 g-2">
        <div class="col-md-3">
            <select id="filterType" class="form-select">
                <option value="">All Types</option>
                <option value="Car">Car</option>
                <option value="Truck">Truck</option>
                <option value="Bus">Bus</option>
                <option value="Van">Van</option>
            </select>
        </div>
        <div class="col-md-3">
            <select id="filterStatus" class="form-select">
                <option value="">All Status</option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0" id="vehiclesTable">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Vehicle ID</th>
                        <th>Model</th>
                        <th>Type</th>
                        <th>Plate Number</th>
                        <th>Status</th>
                        <th width="160">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vehicles as $vehicle)
                    <tr data-type="{{ $vehicle->type }}" data-status="{{ $vehicle->status }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $vehicle->name }}</td>
                        <td>{{ $vehicle->model }}</td>
                        <td>{{ $vehicle->type }}</td>
                        <td>{{ $vehicle->license_plate }}</td>
                        <td>
                            <span class="badge bg-{{ $vehicle->status == 'Active' ? 'success' : 'danger' }}">
                                {{ $vehicle->status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-3">No vehicles found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@push('scripts')
<script>
    const typeFilter = document.getElementById('filterType');
    const statusFilter = document.getElementById('filterStatus');
    const tableRows = document.querySelectorAll('#vehiclesTable tbody tr');

    function filterVehicles() {
        const type = typeFilter.value;
        const status = statusFilter.value;

        tableRows.forEach(row => {
            const rowType = row.dataset.type;
            const rowStatus = row.dataset.status;

            if ((type === '' || rowType === type) && (status === '' || rowStatus === status)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    typeFilter.addEventListener('change', filterVehicles);
    statusFilter.addEventListener('change', filterVehicles);
</script>
@endpush

@endsection
