@extends('layouts.app')
@section('title', 'Assign Vehicle')

@section('content')
<div class="dashboard">
    <h2>Assign Vehicle to Driver</h2>

    <form action="{{ route('assignments.store') }}" method="POST" class="vehicle-form">
        @csrf

        <label>Select Vehicle</label>
        <select name="vehicle_id" required>
            <option value="">-- Select Vehicle --</option>
            @foreach($vehicles as $v)
                <option value="{{ $v->id }}">{{ $v->vehicle_name }} ({{ $v->vehicle_number }})</option>
            @endforeach
        </select>

        <label>Select Driver</label>
        <select name="driver_id" required>
            <option value="">-- Select Driver --</option>
            @foreach($drivers as $d)
                <option value="{{ $d->id }}">{{ $d->name }}</option>
            @endforeach
        </select>

        <label>Assigned Date</label>
        <input type="date" name="assigned_date" required>

        <label>Status</label>
        <select name="status">
            <option>Active</option>
            <option>Completed</option>
        </select>

        <button type="submit" class="btn">Assign Vehicle</button>
    </form>
</div>
@endsection
