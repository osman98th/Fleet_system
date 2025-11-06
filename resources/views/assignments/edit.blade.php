@extends('layouts.app')

@section('content')
<h3 class="mb-3">Edit Assignment</h3>

<form action="{{ route('assignments.update', $assignment->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Vehicle</label>
        <select name="vehicle_id" class="form-select" required>
            @foreach($vehicles as $v)
                <option value="{{ $v->id }}" {{ $assignment->vehicle_id == $v->id ? 'selected' : '' }}>
                    {{ $v->name }} ({{ $v->type }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Driver</label>
        <select name="driver_id" class="form-select" required>
            @foreach($drivers as $d)
                <option value="{{ $d->id }}" {{ $assignment->driver_id == $d->id ? 'selected' : '' }}>
                    {{ $d->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Assigned Date</label>
        <input type="date" name="assigned_date" value="{{ $assignment->assigned_date }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-select">
            <option value="assigned" {{ $assignment->status=='assigned'?'selected':'' }}>Assigned</option>
            <option value="pending" {{ $assignment->status=='pending'?'selected':'' }}>Pending</option>
            <option value="completed" {{ $assignment->status=='completed'?'selected':'' }}>Completed</option>
        </select>
    </div>

    <button class="btn btn-primary">Update</button>
    <a href="{{ route('assignments.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
