@extends('layouts.app')
@section('title', 'Add Fuel Record')

@section('content')
<div class="dashboard">
    <h2>Add Fuel Record</h2>

    <form action="{{ route('fuels.store') }}" method="POST" class="vehicle-form">
        @csrf

        <label for="vehicle_id">Select Vehicle</label>
        <select name="vehicle_id" id="vehicle_id" required>
            <option value="">-- Select Vehicle --</option>

            {{-- Demo data (in real app these come from $vehicles variable) --}}
            <option value="1">Toyota Corolla</option>
            <option value="2">Honda Civic</option>
            <option value="3">Mitsubishi Pajero</option>
            <option value="4">Nissan Sunny</option>
        </select>

        <label>Date</label>
        <input type="date" name="date" required>

        <label>Liters</label>
        <input type="number" step="0.01" name="liters" required>

        <label>Cost</label>
        <input type="number" step="0.01" name="cost" required>

        <label>Remarks</label>
        <input type="text" name="remarks">

        <button type="submit" class="btn">Save Record</button>
    </form>
</div>
@endsection
