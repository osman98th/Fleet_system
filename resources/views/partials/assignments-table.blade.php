<table class="table-auto w-full border border-gray-300">
    <thead>
        <tr class="bg-gray-100">
            <th class="px-4 py-2 border">ID</th>
            <th class="px-4 py-2 border">Vehicle</th>
            <th class="px-4 py-2 border">Driver</th>
            <th class="px-4 py-2 border">Assigned At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($recentAssignments as $assignment)
            <tr>
                <td class="px-4 py-2 border">{{ $assignment->id }}</td>
                <td class="px-4 py-2 border">{{ $assignment->vehicle->vehicle_name ?? 'N/A' }}</td>
                <td class="px-4 py-2 border">{{ $assignment->driver->name ?? 'N/A' }}</td>
                <td class="px-4 py-2 border">{{ $assignment->created_at->format('Y-m-d') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
