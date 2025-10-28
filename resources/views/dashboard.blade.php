@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="dashboard">
    <h2>Top Features of the Fleet Management System</h2>
    <div class="features">
        @foreach($features as $feature)
            <div class="feature-item">{{ $feature }}</div>
        @endforeach
    </div>
</div>
@endsection
