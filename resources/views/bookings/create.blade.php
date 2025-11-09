    @extends('layouts.app')

    @section('content')
    <div class="container py-4 w-75" style="margin-left:250px;">    <h3 class="mb-4">📋 New Booking</h3>

        <form action="{{ route('bookings.store') }}" method="POST" id="bookingForm">
            @csrf

            <!-- Vehicle -->
            <div class="mb-3 ">
                <label class="form-label">Select Vehicle</label>
                <select name="vehicle_id" id="vehicleSelect" class="form-select" required>
                    <option value="">-- Select Vehicle --</option>
                    @foreach($vehicles as $vehicle)
                    <option value="{{ $vehicle->id }}"
                        data-ac-price="{{ $vehicle->ac_price }}"
                        data-non-ac-price="{{ $vehicle->non_ac_price }}"
                        data-ac-price-per-day="{{ $vehicle->ac_price_per_day }}"
                        data-non-ac-price-per-day="{{ $vehicle->non_ac_price_per_day }}">
                        {{ $vehicle->name }} ({{ $vehicle->license_plate }})
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Rent Dates -->
            <div class="mb-3">
                <label>Rent Start:</label>
                <input type="date" name="rent_start_date" id="rentStart" class="form-control" min="{{ date('Y-m-d') }}" required>
            </div>
            <div class="mb-3">
                <label>Rent End:</label>
                <input type="date" name="rent_end_date" id="rentEnd" class="form-control" min="{{ date('Y-m-d') }}" required>
            </div>

            <!-- Car Type -->
            <div class="mb-3">
                <label>Car Type:</label><br>
                <input type="radio" name="car_type" value="ac" class="carType"> AC
                <input type="radio" name="car_type" value="non_ac" class="carType"> Non-AC
            </div>

            <!-- Charge Type -->
            <div class="mb-3">
                <label>Charge Type:</label><br>
                <input type="radio" name="charge_type" value="km" class="chargeType"> Per KM
                <input type="radio" name="charge_type" value="days" class="chargeType"> Per Day
            </div>

            <!-- Driver -->
            <div class="mb-3">
                <label>Driver:</label>
                <select name="driver_id" id="driverSelect" class="form-select" required>
                    <option value="">-- Select Driver --</option>
                    @foreach($drivers as $driver)
                    <option value="{{ $driver->id }}" data-vehicle="{{ $driver->vehicle_id ?? '' }}">
                        {{ $driver->name }} ({{ $driver->gender }})
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Fare -->
            <div class="mb-3">
                <label>Fare:</label>
                <input type="text" id="fareDisplay" class="form-control" >
                <input type="hidden" name="fare" id="fareInput">
            </div>

            <button type="submit" class="btn btn-success">Save Booking</button>
        </form>
    </div>

    @push('scripts')
    <script>
        const vehicleSelect = document.getElementById('vehicleSelect');
        const driverSelect = document.getElementById('driverSelect');
        const carTypeRadios = document.querySelectorAll('.carType');
        const chargeTypeRadios = document.querySelectorAll('.chargeType');
        const rentStart = document.getElementById('rentStart');
        const rentEnd = document.getElementById('rentEnd');
        const fareDisplay = document.getElementById('fareDisplay');
        const fareInput = document.getElementById('fareInput');

        function calculateFare() {
            const vehicleOption = vehicleSelect.selectedOptions[0];
            if (!vehicleOption) return;

            const carType = [...carTypeRadios].find(r => r.checked)?.value;
            const chargeType = [...chargeTypeRadios].find(r => r.checked)?.value;
            if (!carType || !chargeType) return;

            let fare = 0;
            if (carType === 'ac') {
                fare = chargeType === 'km' ? parseFloat(vehicleOption.dataset.acPrice) : parseFloat(vehicleOption.dataset.acPricePerDay);
            } else {
                fare = chargeType === 'km' ? parseFloat(vehicleOption.dataset.nonAcPrice) : parseFloat(vehicleOption.dataset.nonAcPricePerDay);
            }

            if (chargeType === 'days' && rentStart.value && rentEnd.value) {
                const start = new Date(rentStart.value);
                const end = new Date(rentEnd.value);
                const diffDays = Math.ceil((end - start) / (1000 * 60 * 60 * 24)) || 1;
                fare *= diffDays;
            }

            fareDisplay.value = fare.toFixed(2);
            fareInput.value = fare.toFixed(2);
        }

        function filterDrivers() {
            const vehicleId = vehicleSelect.value;
            [...driverSelect.options].forEach(opt => {
                if (opt.value === "") return;
                opt.style.display = (opt.dataset.vehicle === vehicleId) ? 'block' : 'none';
            });
            driverSelect.value = "";
        }

        vehicleSelect.addEventListener('change', () => {
            filterDrivers();
            calculateFare();
        });
        [...carTypeRadios, ...chargeTypeRadios, rentStart, rentEnd].forEach(el => el.addEventListener('change', calculateFare));
    </script>
    @endpush