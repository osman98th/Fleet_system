@extends('layouts.app')
@section('title','Total Expense Report')

@section('content')
<div class="container py-3">
    <h3 class="mb-3">📊 Total Expense Report</h3>

    {{-- Filter Form --}}
    <form action="{{ route('reports.total_expense') }}" method="GET" class="row g-3 mb-3">
        <div class="col-md-3">
            <label for="vehicle_id" class="form-label">Vehicle</label>
            <select name="vehicle_id" id="vehicle_id" class="form-control">
                <option value="">All Vehicles</option>
                @foreach(\App\Models\Vehicle::orderBy('name')->get() as $vehicle)
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

        <div class="col-md-3 d-flex align-items-end">
            <button class="btn btn-primary me-2">Filter</button>
            <a href="{{ route('reports.total_expense') }}" class="btn btn-secondary">Reset</a>
            <a href="{{ route('reports.total_expense-pdf', request()->all()) }}" target="_blank" class="btn btn-success ms-2">PDF</a>
        </div>
    </form>

    {{-- Total Expense Table --}}
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Vehicle</th>
                        <th>Fuel</th>
                        <th>Maintenance</th>
                        <th>Food</th>
                        <th>Stipend</th>
                        <th>Parking</th>
                        <th>Toll</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($records as $index => $r)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($r->date)->format('d M Y') }}</td>
                        <td>{{ $r->vehicle->name ?? 'N/A' }}</td>
                        <td>{{ number_format($r->fuel_cost ?? 0,2) }}</td>
                        <td>{{ number_format($r->maintenance_cost ?? 0,2) }}</td>
                        <td>{{ number_format($r->food_cost ?? 0,2) }}</td>
                        <td>{{ number_format($r->stipend_cost ?? 0,2) }}</td>
                        <td>{{ number_format($r->parking_cost ?? 0,2) }}</td>
                        <td>{{ number_format($r->toll_cost ?? 0,2) }}</td>
                        <td>{{ number_format(
                                ($r->fuel_cost ?? 0)+($r->maintenance_cost ?? 0)+($r->food_cost ?? 0)+
                                ($r->stipend_cost ?? 0)+($r->parking_cost ?? 0)+($r->toll_cost ?? 0),2) 
                            }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center">No records found.</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="9" class="text-end">Grand Total</th>
                        <th>{{ number_format($totalExpense, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection