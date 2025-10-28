@extends('layouts.app')
@section('title', 'Edit Fuel Record')

@section('content')
<div class="dashboard">
    <h2>Edit Fuel Record</h2>

    <form action="{{ route('fuels.update', $fuel->id) }}" method="POST" class="vehicle-form">
        @csrf
        @method('PUT')

        <label>Select Vehicle</label>
        <select name="vehicle_id" required>
            @foreach($vehicles as $v)
                <option value="{{ $v->id }}" {{ $fuel->vehicle_id == $v->id ? 'selected' : '' }}>
                    {{ $v->vehicle_name }}
                </option>
            @endforeach
        </select>

        <label>Date</label>
        <input type="date" name="date" value="{{ $fuel->date }}" required>

        <label>Liters</label>
        <input type="number" step="0.01" name="liters" value="{{ $fuel->liters }}" required>

        <label>Cost</label>
        <input type="number" step="0.01" name="cost" value="{{ $fuel->cost }}" required>

        <label>Remarks</label>
        <input type="text" name="remarks" value="{{ $fuel->remarks }}">

        <button type="submit" class="btn">Update Record</button>
    </form>
</div>
@endsection
