@extends('layouts.app')
@section('title', 'Edit Driver')

@section('content')
<div class="dashboard">
    <h2>Edit Driver</h2>

    <form action="{{ route('drivers.update', $driver->id) }}" method="POST" class="vehicle-form">
        @csrf
        @method('PUT')

        <label>Name</label>
        <input type="text" name="name" value="{{ $driver->name }}" required>

        <label>License Number</label>
        <input type="text" name="license_number" value="{{ $driver->license_number }}" required>

        <label>Phone</label>
        <input type="text" name="phone" value="{{ $driver->phone }}" required>

        <label>Address</label>
        <input type="text" name="address" value="{{ $driver->address }}">

        <label>Status</label>
        <select name="status">
            <option {{ $driver->status == 'Available' ? 'selected' : '' }}>Available</option>
            <option {{ $driver->status == 'Unavailable' ? 'selected' : '' }}>Unavailable</option>
        </select>

        <button type="submit" class="btn">Update Driver</button>
    </form>
</div>
@endsection
