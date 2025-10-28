@extends('layouts.app')
@section('title', 'Drivers')

@section('content')
<div class="dashboard">
    <h2>Driver List</h2>

    @if(session('success'))
        <p class="alert-success">{{ session('success') }}</p>
    @endif

    <a href="{{ route('drivers.create') }}" class="btn">+ Add Driver</a>

    <table class="vehicle-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>License Number</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Status</th>
                <th>Action</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            @foreach($drivers as $d)
            <tr>
                <td>{{ $d->id }}</td>
                <td>{{ $d->name }}</td>
                <td>{{ $d->license_number }}</td>
                <td>{{ $d->phone }}</td>
                <td>{{ $d->address }}</td>
                <td>{{ $d->status }}</td>
                <td>
                    <a href="{{ route('drivers.edit', $d->id) }}" class="edit-btn">Edit</a>
                    <form action="{{ route('drivers.destroy', $d->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="delete-btn" onclick="return confirm('Delete this driver?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
