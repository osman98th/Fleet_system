@extends('layouts.app')

@section('content')
<h3 class="mb-3">Add Assignment</h3>

<form action="{{ route('assignments.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Vehicle</label>
        <select name="vehicle_id" class="form-select" required>
            <option value="">Select Vehicle</option>
            @foreach($vehicles as $v)
                <option value="{{ $v->id }}">{{ $v->name }} ({{ $v->type }})</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Driver</label>
        <select name="driver_id" class="form-select" required>
            <option value="">Select Driver</option>
            @foreach($drivers as $d)
                <option value="{{ $d->id }}">{{ $d->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Assigned Date</label>
        <input type="date" name="assigned_date" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-select">
            <option value="assigned">Assigned</option>
            <option value="pending">Pending</option>
            <option value="completed">Completed</option>
        </select>
    </div>

    <button class="btn btn-success">Save</button>
    <a href="{{ route('assignments.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
