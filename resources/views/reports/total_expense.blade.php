@extends('layouts.app-layout')

@section('title', 'Total Expense Report')

@section('content')
<div class="container py-3">
    <h3 class="mb-3">💰 Total Expense Report</h3>

    <form method="GET" class="row g-3 mb-3">
        <div class="col-md-3">
            <label for="month" class="form-label">Select Month</label>
            <input type="month" name="month" id="month" class="form-control" value="{{ request('month') }}">
        </div>
        <div class="col-md-3">
            <label for="vehicle_id" class="form-label">Select Vehicle</label>
            <select name="vehicle_id" id="vehicle_id" class="form-select">
                <option value="">All Vehicles</option>
                @foreach(\App\Models\Vehicle::all() as $vehicle)
                <option value="{{ $vehicle->id }}" {{ request('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                    {{ $vehicle->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 align-self-end">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('reports.total_expense') }}" class="btn btn-secondary">Reset</a>
        </div>
        <div class="col-md-3 align-self-end text-end">
            <a href="{{ route('reports.total_expense.pdf', request()->query()) }}" class="btn btn-success">📄 Download PDF</a>
        </div>
    </form>

    @if($records->isEmpty())
    <div class="alert alert-warning">No records found.</div>
    @else
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Type</th>
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
                @foreach($records as $key => $r)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $r->type ?? 'N/A' }}</td>
                    <td>{{ $r->date ?? 'N/A' }}</td>
                    <td>{{ $r->vehicle->name ?? '-' }}</td>
                    <td>{{ number_format($r->fuel_cost ?? 0, 2) }}</td>
                    <td>{{ number_format($r->maintenance_cost ?? 0, 2) }}</td>
                    <td>{{ number_format($r->food_cost ?? 0, 2) }}</td>
                    <td>{{ number_format($r->stipend_cost ?? 0, 2) }}</td>
                    <td>{{ number_format($r->parking_cost ?? 0, 2) }}</td>
                    <td>{{ number_format($r->toll_cost ?? 0, 2) }}</td>
                    <td>
                        {{ number_format(
                                    ($r->fuel_cost ?? 0) + 
                                    ($r->maintenance_cost ?? 0) + 
                                    ($r->food_cost ?? 0) + 
                                    ($r->stipend_cost ?? 0) + 
                                    ($r->parking_cost ?? 0) + 
                                    ($r->toll_cost ?? 0), 2) 
                                }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="table-dark">
                <tr>
                    <th colspan="10" class="text-end">Grand Total:</th>
                    <th>{{ number_format($totalExpense ?? 0, 2) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
    @endif
</div>
@endsection