@extends('layouts.app')
@section('title', 'Add Vehicle')

@section('content')
<div class="dashboard">
    <h2>Add New Vehicle</h2>

    <form action="{{ route('vehicles.store') }}" method="POST" class="vehicle-form">
        @csrf
        <label>Vehicle Name</label>
        <input type="text" name="vehicle_name" required>

        <label>Model</label>
        <input type="text" name="model" required>

        <label>License Plate</label>
        <input type="text" name="license_plate" required>

        <label>Year</label>
        <input type="number" name="year">

        <label>Status</label>
        <select name="status">
            <option>Active</option>
            <option>Inactive</option>
        </select>

        <button type="submit" class="btn">Save Vehicle</button>
    </form>
</div>
@endsection
