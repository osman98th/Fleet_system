@extends('layouts.app')
@section('title', 'Edit Vehicle')

@section('content')
<div class="dashboard">
    <h2>Edit Vehicle</h2>

    <form action="{{ route('vehicles.update', $vehicle->id) }}" method="POST" class="vehicle-form">
        @csrf
        @method('PUT')

        <label>Vehicle Name</label>
        <input type="text" name="vehicle_name" value="{{ $vehicle->vehicle_name }}" required>

        <label>Model</label>
        <input type="text" name="model" value="{{ $vehicle->model }}" required>

        <label>License Plate</label>
        <input type="text" name="license_plate" value="{{ $vehicle->license_plate }}" required>

        <label>Year</label>
        <input type="number" name="year" value="{{ $vehicle->year }}">

        <label>Status</label>
        <select name="status">
            <option {{ $vehicle->status == 'Active' ? 'selected' : '' }}>Active</option>
            <option {{ $vehicle->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
        </select>

        <button type="submit" class="btn">Update Vehicle</button>
    </form>
</div>
@endsection
