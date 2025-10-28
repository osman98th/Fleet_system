@extends('layouts.app')
@section('title', 'Vehicles')

@section('content')
<div class="dashboard">
    <h2>Vehicle List</h2>

    @if(session('success'))
        <p class="alert-success">{{ session('success') }}</p>
    @endif

    <a href="{{ route('vehicles.create') }}" class="btn">+ Add Vehicle</a>

    <table class="vehicle-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Vehicle Name</th>
                <th>Model</th>
                <th>License Plate</th>
                <th>Year</th>
                <th>Status</th>
                <th>Action</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vehicles as $v)
            <tr>
                <td>{{ $v->id }}</td>
                <td>{{ $v->vehicle_name }}</td>
                <td>{{ $v->model }}</td>
                <td>{{ $v->license_plate }}</td>
                <td>{{ $v->year }}</td>
                <td>{{ $v->status }}</td>
                <td>
                    <a href="{{ route('vehicles.edit', $v->id) }}" class="edit-btn">Edit</a>
                    <form action="{{ route('vehicles.destroy', $v->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="delete-btn" onclick="return confirm('Delete this vehicle?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
