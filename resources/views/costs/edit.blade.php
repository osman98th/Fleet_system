@extends('layouts.app')

@section('title','Edit Cost')

@section('content')
<div class="container py-4">
    <h3>✏️ Edit Cost</h3>
    <div class="card shadow-sm mt-3">
        <div class="card-body">
            <form action="{{ route('costs.update', $cost->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Vehicle Dropdown --}}
                <div class="mb-3">
                    <label for="vehicle_id" class="form-label">Vehicle</label>
                    <select name="vehicle_id" id="vehicle_id" class="form-select" required>
                        <option value="">-- Select Vehicle --</option>
                        @foreach(\App\Models\Vehicle::orderBy('name')->get() as $vehicle)
                        <option value="{{ $vehicle->id }}" {{ $cost->vehicle_id == $vehicle->id ? 'selected' : '' }}>
                            {{ $vehicle->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Cost Type --}}
                <div class="mb-3">
                    <label for="type" class="form-label">Cost Type</label>
                    <select name="type" id="type" class="form-select" required>
                        @php
                        $types = ['Fuel', 'Maintenance', 'Per Trip', 'Monthly', 'Parking', 'Toll'];
                        @endphp
                        <option value="">-- Select Type --</option>
                        @foreach($types as $type)
                        <option value="{{ $type }}" {{ $cost->type == $type ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Name --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Cost Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $cost->name }}" required>
                </div>

                {{-- Amount --}}
                <div class="mb-3">
                    <label for="amount" class="form-label">Amount (৳)</label>
                    <input type="number" step="0.01" name="amount" id="amount" class="form-control" value="{{ $cost->amount }}" required>
                </div>

                {{-- Date --}}
                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" name="date" id="date" class="form-control" value="{{ $cost->date->format('Y-m-d') }}" required>
                </div>

                {{-- Vehicle Profit Preview --}}
                <div class="mb-3">
                    <label class="form-label">Vehicle Profit</label>
                    <input type="text" id="vehicle_profit" class="form-control" value="" readonly>
                </div>

                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('costs.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

{{-- JS for dynamic vehicle profit --}}
<script>
    function updateProfit(vehicleId) {
        if (!vehicleId) {
            document.getElementById('vehicle_profit').value = '';
            return;
        }
        fetch(`/vehicles/${vehicleId}/profit`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('vehicle_profit').value = '৳ ' + (data.profit ?? 0).toFixed(2);
            });
    }

    document.getElementById('vehicle_id').addEventListener('change', e => {
        updateProfit(e.target.value);
    });

    // Initialize on page load
    updateProfit(document.getElementById('vehicle_id').value);
</script>
@endsection