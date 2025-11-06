@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Assignments List</h3>
    <a href="{{ route('assignments.create') }}" class="btn btn-success btn-sm">+ Add Assignment</a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Vehicle</th>
                    <th>Type</th>
                    <th>Driver</th>
                    <th>Assigned Date</th>
                    <th>Status</th>
                    <th width="170">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($assignments as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->vehicle->name ?? 'N/A' }}</td>
                    <td>{{ $item->vehicle->type ?? '-' }}</td>
                    <td>{{ $item->driver->name ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->assigned_date)->format('d-m-Y') }}</td>
                    <td>
                        @if($item->status == 'assigned')
                            <span class="badge bg-success">Assigned</span>
                        @elseif($item->status == 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @else
                            <span class="badge bg-secondary">Completed</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('assignments.edit', $item->id) }}" class="btn btn-primary btn-sm">Edit</a>

                        <form action="{{ route('assignments.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">
                                Delete
                            </button>
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
