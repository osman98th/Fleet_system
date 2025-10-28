@extends('layouts.app')
@section('title', 'Add Driver')

@section('content')
<div class="dashboard">
    <h2>Add New Driver</h2>

    <form action="{{ route('drivers.store') }}" method="POST" class="vehicle-form">
        @csrf
        <label>Name</label>
        <input type="text" name="name" required>

        <label>License Number</label>
        <input type="text" name="license_number" required>

        <label>Phone</label>
        <input type="text" name="phone" required>

        <label>Address</label>
        <input type="text" name="address">

        <label>Status</label>
        <select name="status">
            <option>Available</option>
            <option>Unavailable</option>
        </select>

        <button type="submit" class="btn">Save Driver</button>
    </form>
</div>
@endsection
