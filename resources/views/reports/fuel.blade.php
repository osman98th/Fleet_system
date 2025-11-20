@extends('layouts.app')

@section('title','Fuel Report')

@section('content')
<div class="container py-3">
    <h3 class="mb-3">📊 Fuel Report</h3>

    {{-- Filter Form --}}
    <form method="GET" action="{{ route('reports.fuel') }}" class="row g-3 mb-3">
        <div class="col-md-3">
            <label for="vehicle_id" class="form-label">Vehicle</label>
            <select name="vehicle_id" id="vehicle_id" class="form-select">
                <option value="">All Vehicles</option>
                @foreach($vehicles as $vehicle)
                <option value="{{ $vehicle->id }}" {{ request('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                    {{ $vehicle->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label for="month" class="form-label">Month</label>
            <input type="month" name="month" id="month" class="form-control" value="{{ request('month') }}">
        </div>

        <div class="col-md-2">
            <label for="from_date" class="form-label">From Date</label>
            <input type="date" name="from_date" id="from_date" class="form-control" value="{{ request('from_date') }}">
        </div>

        <div class="col-md-2">
            <label for="to_date" class="form-label">To Date</label>
            <input type="date" name="to_date" id="to_date" class="form-control" value="{{ request('to_date') }}">
        </div>

        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary me-2">Filter</button>
            <a href="{{ route('reports.fuel') }}" class="btn btn-secondary me-2">Reset</a>
            <a href="{{ route('reports.fuel.pdf', request()->all()) }}" target="_blank" class="btn btn-success">PDF</a>
        </div>
    </form>

    {{-- Daily Fuel Cost Chart --}}
    @if(isset($chartImage))
    <div class="mb-4 text-center">
        <img src="{{ $chartImage }}" alt="Daily Fuel Cost Chart" style="width:100%; max-width:700px;">
    </div>
    @endif

    {{-- Fuel Records Table --}}
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Vehicle</th>
                        <th>Driver</th>
                        <th>Liters</th>
                        <th>Cost</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fuelRecords as $record)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($record->date)->format('d M, Y') }}</td>
                        <td>{{ $record->vehicle?->name ?? '-' }}</td>
                        <td>{{ $record->driver?->name ?? '-' }}</td>
                        <td>{{ $record->liters }}</td>
                        <td>{{ number_format($record->cost,2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No records found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection