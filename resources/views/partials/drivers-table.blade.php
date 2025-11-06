<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
        </tr>
    </thead>
    <tbody>
        @forelse($recentDrivers as $driver)
            <tr>
                <td>{{ $driver->id }}</td>
                <td>{{ $driver->name }}</td>
                <td>{{ $driver->email }}</td>
                <td>{{ $driver->phone }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">No drivers found</td>
            </tr>
        @endforelse
    </tbody>
</table>
