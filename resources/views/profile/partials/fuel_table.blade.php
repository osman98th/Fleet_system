<table class="table table-bordered table-striped table-hover">
    <thead class="table-dark">
        <tr>
            @php
            $columns = ['id' => 'ID', 'vehicle_id' => 'Vehicle', 'driver_id' => 'Driver', 'amount' => 'Amount', 'date' => 'Date', 'remarks' => 'Remarks'];
            @endphp
            @foreach($columns as $field => $label)
            <th>
                @if(in_array($field,['id','vehicle_id','driver_id','amount','date']))
                <a href="#" class="sortable text-white" data-sort="{{ $field }}" data-order="{{ ($sort_by==$field && $sort_order=='asc') ? 'desc' : 'asc' }}">
                    {{ $label }}
                    @if($sort_by==$field)
                    @if($sort_order=='asc') ▲ @else ▼ @endif
                    @endif
                </a>
                @else
                {{ $label }}
                @endif
            </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @forelse($fuels as $fuel)
        <tr>
            <td>{{ $fuel->id }}</td>
            <td>{{ $fuel->vehicle->name ?? 'N/A' }}</td>
            <td>{{ $fuel->driver->name ?? 'N/A' }}</td>
            <td>{{ $fuel->amount }}</td>
            <td>{{ \Carbon\Carbon::parse($fuel->date)->format('Y-m-d') }}</td>
            <td>{{ $fuel->remarks ?? '-' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">No fuel records found.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<!-- Pagination Links -->
<div id="fuelPagination" class="mt-3">
    {{ $fuels->links() }}
</div>