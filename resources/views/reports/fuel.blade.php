@extends('layouts.app')

@section('title','Fuel Report')

@section('content')
<div class="container py-4 w-100" style="margin-left:250px;">
    <h3 class="mb-4">⛽ Fuel Report</h3>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('reports.fuel') }}" class="row g-3 mb-4">
        <div class="col-md-3">
            <input type="date" name="start_date" class="form-control" placeholder="Start Date" value="{{ request('start_date') }}">
        </div>
        <div class="col-md-3">
            <input type="date" name="end_date" class="form-control" placeholder="End Date" value="{{ request('end_date') }}">
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('reports.fuel') }}" class="btn btn-secondary">Reset</a>
        </div>
        <div class="col-md-3 text-end">
            <a href="{{ route('reports.fuel.pdf', request()->all()) }}" class="btn btn-success">Download PDF</a>
        </div>
    </form>

    <!-- Report Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Vehicle</th>
                    <th>Total Liters</th>
                    <th>Total Cost</th>
                    <th>Avg Cost / Liter</th>
                    <th>Total Days</th>
                    <th>Total KM</th>
                    <th>Cost / Day</th>
                    <th>Cost / KM</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reportData as $index => $r)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $r->vehicle_name ?? '-' }}</td>
                    <td>{{ $r->total_liters }}</td>
                    <td>{{ $r->total_cost }}</td>
                    <td>{{ $r->avg_cost_per_liter }}</td>
                    <td>{{ $r->total_days }}</td>
                    <td>{{ $r->total_km }}</td>
                    <td>{{ $r->cost_per_day }}</td>
                    <td>{{ $r->cost_per_km }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">No records found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Optional: Daily Chart -->
    @if($dailyData->count())
    <h5 class="mt-5">Daily Fuel Cost</h5>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Date</th>
                <th>Daily Cost</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dailyData as $d)
            <tr>
                <td>{{ $d->date }}</td>
                <td>{{ $d->daily_cost }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection