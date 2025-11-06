@extends('layouts.app')
@section('title','Edit Booking')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">✏️ Edit Booking</h3>

    <form action="{{ route('bookings.update', $booking->id) }}" method="POST" id="bookingForm">
        @csrf
        @method('PUT')

        <!-- Vehicle Selection -->
        <div class="mb-3">
            <label for="vehicleSelect" class="form-label">Select Vehicle</label>
            <select name="vehicle_id" id="vehicleSelect" class="form-select" required>
                <option value="">-- Select Vehicle --</option>
                @foreach($vehicles as $vehicle)
                <option value="{{ $vehicle->id }}"
                    data-ac-price="{{ $vehicle->ac_price }}"
                    data-non-ac-price="{{ $vehicle->non_ac_price }}"
                    data-ac-price-per-day="{{ $vehicle->ac_price_per_day }}"
                    data-non-ac-price-per-day="{{ $vehicle->non_ac_price_per_day }}"
                    {{ $vehicle->id == $booking->vehicle_id ? 'selected' : '' }}>
                    {{ $vehicle->name }} ({{ $vehicle->license_plate }})
                </option>
                @endforeach
            </select>
        </div>

        <!-- Rent Dates -->
        <div class="mb-3">
            <label class="form-label">Rent Start:</label>
            <input type="date" name="rent_start_date" id="rentStart" class="form-control"
                min="{{ date('Y-m-d') }}" value="{{ $booking->rent_start_date }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Rent End:</label>
            <input type="date" name="rent_end_date" id="rentEnd" class="form-control"
                min="{{ date('Y-m-d') }}" value="{{ $booking->rent_end_date }}" required>
        </div>

        <!-- Car Type -->
        <div class="mb-3">
            <label class="form-label">Car Type:</label><br>
            <input type="radio" name="car_type" value="ac" class="carType" {{ $booking->car_type == 'ac' ? 'checked' : '' }}> AC
            <input type="radio" name="car_type" value="non_ac" class="carType" {{ $booking->car_type == 'non_ac' ? 'checked' : '' }}> Non-AC
        </div>

        <!-- Charge Type -->
        <div class="mb-3">
            <label class="form-label">Charge Type:</label><br>
            <input type="radio" name="charge_type" value="km" class="chargeType" {{ $booking->charge_type == 'km' ? 'checked' : '' }}> Per KM
            <input type="radio" name="charge_type" value="days" class="chargeType" {{ $booking->charge_type == 'days' ? 'checked' : '' }}> Per Day
        </div>

        <!-- Distance (only for Per KM) -->
        <div class="mb-3" id="distanceDiv" style="display:none;">
            <label class="form-label">Distance (KM):</label>
            <input type="number" name="distance" id="distanceInput" class="form-control" min="0" value="{{ $booking->charge_type == 'km' ? $booking->distance : '' }}">
        </div>

        <!-- Driver Selection -->
        <div class="mb-3">
            <label class="form-label">Select Driver:</label>
            <select name="driver_id" id="driverSelect" class="form-select" required>
                <option value="">-- Select Driver --</option>
                @foreach($drivers as $driver)
                <option value="{{ $driver->id }}" data-vehicle="{{ $driver->vehicle_id ?? '' }}"
                    {{ $driver->id == $booking->driver_id ? 'selected' : '' }}>
                    {{ $driver->name }} ({{ $driver->gender }})
                </option>
                @endforeach
            </select>
        </div>

        <!-- Fare Display -->
        <div class="mb-3">
            <label class="form-label">Fare:</label>
            <input type="text" id="fareDisplay" class="form-control" readonly>
            <input type="hidden" name="fare" id="fareInput" value="{{ $booking->fare }}">
        </div>

        <button type="submit" class="btn btn-success">Update Booking</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const vehicleSelect = document.getElementById('vehicleSelect');
    const driverSelect = document.getElementById('driverSelect');
    const carTypeRadios = document.querySelectorAll('.carType');
    const chargeTypeRadios = document.querySelectorAll('.chargeType');
    const rentStart = document.getElementById('rentStart');
    const rentEnd = document.getElementById('rentEnd');
    const distanceDiv = document.getElementById('distanceDiv');
    const distanceInput = document.getElementById('distanceInput');
    const fareDisplay = document.getElementById('fareDisplay');
    const fareInput = document.getElementById('fareInput');

    // Fare calculation function
    function calculateFare() {
        const vehicleOption = vehicleSelect.selectedOptions[0];
        if (!vehicleOption) return;

        const carType = [...carTypeRadios].find(r => r.checked)?.value;
        const chargeType = [...chargeTypeRadios].find(r => r.checked)?.value;
        if (!carType || !chargeType) return;

        let fare = 0;

        if (chargeType === 'km') {
            distanceDiv.style.display = 'block';
            const distance = parseFloat(distanceInput.value) || 0;
            fare = carType === 'ac' ? parseFloat(vehicleOption.dataset.acPrice) : parseFloat(vehicleOption.dataset.nonAcPrice);
            fare = fare * distance;
        } else {
            distanceDiv.style.display = 'none';
            fare = carType === 'ac' ? parseFloat(vehicleOption.dataset.acPricePerDay) : parseFloat(vehicleOption.dataset.nonAcPricePerDay);
            if (rentStart.value && rentEnd.value) {
                const start = new Date(rentStart.value);
                const end = new Date(rentEnd.value);
                const diffDays = Math.ceil((end - start) / (1000 * 60 * 60 * 24)) || 1;
                fare = fare * diffDays;
            }
        }

        fareDisplay.value = fare.toFixed(2);
        fareInput.value = fare.toFixed(2);
    }

    // Filter drivers based on vehicle
    function filterDrivers() {
        const vehicleId = vehicleSelect.value;
        [...driverSelect.options].forEach(opt => {
            if (opt.value === "") return;
            opt.style.display = (opt.dataset.vehicle === vehicleId) ? 'block' : 'none';
        });
    }

    // Event listeners
    vehicleSelect.addEventListener('change', () => {
        filterDrivers();
        calculateFare();
    });
    [...carTypeRadios, ...chargeTypeRadios, rentStart, rentEnd, distanceInput].forEach(el => el.addEventListener('change', calculateFare));

    // Initial setup
    window.addEventListener('load', () => {
        filterDrivers();
        calculateFare();
    });
</script>
@endpush