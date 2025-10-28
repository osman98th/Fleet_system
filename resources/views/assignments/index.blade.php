@extends('layouts.app')
@section('title', 'Vehicle Assignments')

@section('content')
<div class="dashboard">
    <h2>Vehicle Assignments</h2>

    @if(session('success'))
        <p class="alert-success">{{ session('success') }}</p>
    @endif

    <a href="{{ route('assignments.create') }}" class="btn">+ New Assignment</a>

    <table class="vehicle-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Vehicle</th>
                <th>Driver</th>
                <th>Assigned Date</th>
                <th>Status</th>
                <th>Action</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assignments as $a)
            <tr>
                <td>{{ $a->id }}</td>
                <td>{{ $a->vehicle->vehicle_name ?? 'N/A' }}</td>
                <td>{{ $a->driver->name ?? 'N/A' }}</td>
                <td>{{ $a->assigned_date }}</td>
                <td>{{ $a->status }}</td>
                <td>
                    <form action="{{ route('assignments.destroy', $a->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="delete-btn" onclick="return confirm('Delete this assignment?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
