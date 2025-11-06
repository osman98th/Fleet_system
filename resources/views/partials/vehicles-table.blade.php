<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Vehicle Name</th>
            <th>Model</th>
            <th>License Plate</th>
            <th>Year</th>
        </tr>
    </thead>
    <tbody>
        @forelse($recentVehicles as $vehicle)
            <tr>
                <td>{{ $vehicle->id }}</td>
                <td>{{ $vehicle->vehicle_name }}</td>
                <td>{{ $vehicle->model }}</td>
                <td>{{ $vehicle->license_plate }}</td>
                <td>{{ $vehicle->year }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">No vehicles found</td>
            </tr>
        @endforelse
    </tbody>
</table>
