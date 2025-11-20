@extends('layouts.app')

@section('title','Vehicle Profit Dashboard')

@section('content')
<div class="container py-4">
    <h3>🚗 Vehicle Profit Dashboard</h3>

    {{-- Filter --}}
    <form action="{{ route('costs.vehicleProfitDashboard') }}" method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <label for="month" class="form-label">Month</label>
            <input type="month" name="month" id="month" class="form-control" value="{{ request('month') }}">
        </div>
        <div class="col-md-3 align-self-end">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('costs.vehicleProfitPdf', request()->all()) }}" target="_blank" class="btn btn-secondary">📄 PDF</a>
        </div>
    </form>

    {{-- Responsive Table --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Vehicle</th>
                    <th>Fuel Cost (৳)</th>
                    <th>Other Costs (৳)</th>
                    <th>Income (৳)</th>
                    <th>Profit (৳)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item['vehicle']->name }}</td>
                    <td>{{ number_format($item['fuel'],2) }}</td>
                    <td>{{ number_format($item['otherCosts'],2) }}</td>
                    <td>{{ number_format($item['income'],2) }}</td>
                    <td>{{ number_format($item['profit'],2) }}</td>
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
@endsection