@extends('layouts.app')
@section('title', 'Fuel Records')

@section('content')
<div class="dashboard">
    <h2>Fuel Records</h2>

    @if(session('success'))
        <p class="alert-success">{{ session('success') }}</p>
    @endif

    <a href="{{ route('fuels.create') }}" class="btn">+ Add Fuel Record</a>

    <table class="vehicle-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Vehicle</th>
                <th>Date</th>
                <th>Liters</th>
                <th>Cost</th>
                <th>Remarks</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($fuels as $f)
            <tr>
                <td>{{ $f->id }}</td>
                <td>{{ $f->vehicle->vehicle_name ?? 'N/A' }}</td>
                <td>{{ $f->date }}</td>
                <td>{{ $f->liters }}</td>
                <td>{{ $f->cost }}</td>
                <td>{{ $f->remarks }}</td>
                <td>
                    <a href="{{ route('fuels.edit', $f->id) }}" class="edit-btn">Edit</a>
                    <form action="{{ route('fuels.destroy', $f->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="delete-btn" onclick="return confirm('Delete this record?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
