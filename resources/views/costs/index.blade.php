@extends('layouts.app')

@section('title','Costs List')

@section('content')
<div class="container py-4">
    <h3>💰 Vehicle Costs</h3>

    {{-- Filters --}}
    <div class="card shadow-sm mt-3 mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('costs.index') }}" class="row g-3">
                {{-- Vehicle Filter --}}
                <div class="col-md-4">
                    <label for="vehicle_id" class="form-label">Vehicle</label>
                    <select name="vehicle_id" id="vehicle_id" class="form-select">
                        <option value="">-- All Vehicles --</option>
                        @foreach(\App\Models\Vehicle::orderBy('name')->get() as $vehicle)
                        <option value="{{ $vehicle->id }}" {{ request('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                            {{ $vehicle->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Cost Type Filter --}}
                <div class="col-md-4">
                    <label for="type" class="form-label">Cost Type</label>
                    <select name="type" id="type" class="form-select">
                        <option value="">-- All Types --</option>
                        @php
                        $types = ['Fuel', 'Maintenance', 'Per Trip', 'Monthly', 'Parking', 'Toll'];
                        @endphp
                        @foreach($types as $type)
                        <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                    <a href="{{ route('costs.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Costs Table --}}
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Vehicle</th>
                        <th>Cost Type</th>
                        <th>Cost Name</th>
                        <th>Date</th>
                        <th>Amount (৳)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $perTripTotal = 0;
                    $monthlyTotal = 0;
                    $overallTotal = 0;
                    @endphp

                    @forelse($costs as $cost)
                    @php
                    $overallTotal += $cost->amount;
                    if($cost->type === 'Per Trip') $perTripTotal += $cost->amount;
                    if($cost->type === 'Monthly') $monthlyTotal += $cost->amount;
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $cost->vehicle?->name ?? '-' }}</td>
                        <td>{{ $cost->type }}</td>
                        <td>{{ $cost->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($cost->date)->format('d M, Y') }}</td>
                        <td>{{ number_format($cost->amount,2) }}</td>
                        <td>
                            <a href="{{ route('costs.edit', $cost->id) }}" class="btn btn-sm btn-info">Edit</a>
                            <form action="{{ route('costs.destroy', $cost->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No costs found.</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5" class="text-end">Per Trip Total</th>
                        <th colspan="2">৳ {{ number_format($perTripTotal,2) }}</th>
                    </tr>
                    <tr>
                        <th colspan="5" class="text-end">Monthly Total</th>
                        <th colspan="2">৳ {{ number_format($monthlyTotal,2) }}</th>
                    </tr>
                    <tr>
                        <th colspan="5" class="text-end">Overall Total</th>
                        <th colspan="2">৳ {{ number_format($overallTotal,2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection