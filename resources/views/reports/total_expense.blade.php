@extends('layouts.app-layout')

@section('title', 'Total Expense')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4">💰 Total Expense</h3>

    <div class="mb-3">
        <strong>Total Cost:</strong> {{ number_format($totalExpense,2) }} ৳
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Date</th>
                    <th>Vehicle</th>
                    <th>Fuel (৳)</th>
                    <th>Maintenance (৳)</th>
                    <th>Food (৳)</th>
                    <th>Stipend (৳)</th>
                    <th>Parking (৳)</th>
                    <th>Toll (৳)</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fuelRecords as $record)
                <tr>
                    <td>{{ date('d M Y', strtotime($record->date)) }}</td>
                    <td>{{ $record->vehicle->name ?? '-' }}</td>
                    <td>{{ number_format($record->fuel_cost ?? $record->cost, 2) }}</td>
                    <td>{{ number_format($record->maintenance_cost ?? 0, 2) }}</td>
                    <td>{{ number_format($record->food_cost ?? 0, 2) }}</td>
                    <td>{{ number_format($record->stipend_cost ?? 0, 2) }}</td>
                    <td>{{ number_format($record->parking_cost ?? 0, 2) }}</td>
                    <td>{{ number_format($record->toll_cost ?? 0, 2) }}</td>
                    <td>{{ $record->remarks ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">No records found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection