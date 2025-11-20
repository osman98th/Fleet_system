<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Fuel Report PDF</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 5px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
        }

        .chart {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <h2>Fuel Report</h2>

    {{-- Filters --}}
    @if(request('vehicle_id') || request('month') || request('from_date') || request('to_date'))
    <p>
        Filters:
        @if(request('vehicle_id')) Vehicle: {{ $fuelRecords->first()?->vehicle?->name ?? 'N/A' }}; @endif
        @if(request('month')) Month: {{ \Carbon\Carbon::parse(request('month').'-01')->format('F Y') }}; @endif
        @if(request('from_date')) From: {{ \Carbon\Carbon::parse(request('from_date'))->format('d M, Y') }}; @endif
        @if(request('to_date')) To: {{ \Carbon\Carbon::parse(request('to_date'))->format('d M, Y') }}; @endif
    </p>
    @endif

    {{-- Chart --}}
    @if(isset($chartImage))
    <div class="chart">
        <img src="{{ $chartImage }}" alt="Daily Fuel Cost Chart" style="width:100%; max-width:700px;">
    </div>
    @endif

    {{-- Fuel Records Table --}}
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Vehicle</th>
                <th>Driver</th>
                <th>Liters</th>
                <th>Cost</th>
            </tr>
        </thead>
        <tbody>
            @forelse($fuelRecords as $record)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ \Carbon\Carbon::parse($record->date)->format('d M, Y') }}</td>
                <td>{{ $record->vehicle?->name ?? '-' }}</td>
                <td>{{ $record->driver?->name ?? '-' }}</td>
                <td>{{ $record->liters }}</td>
                <td>{{ number_format($record->cost, 2) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">No records found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>