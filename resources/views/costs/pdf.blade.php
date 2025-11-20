<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Vehicle Costs Report</title>
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

        .summary {
            margin-top: 15px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h2>Vehicle Costs Report</h2>

    @if(request('vehicle_id') || request('type'))
    <p>
        Filters:
        @if(request('vehicle_id')) Vehicle: {{ $vehicle_name ?? 'N/A' }}; @endif
        @if(request('type')) Type: {{ request('type') }}; @endif
    </p>
    @endif

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Vehicle</th>
                <th>Cost Type</th>
                <th>Cost Name</th>
                <th>Date</th>
                <th>Amount (৳)</th>
            </tr>
        </thead>
        <tbody>
            @php
            $perTripTotal = 0;
            $monthlyTotal = 0;
            $overallTotal = 0;
            @endphp

            @forelse($costs as $cost)
            @php
            $overallTotal += $cost->amount;
            if($cost->type === 'Per Trip') $perTripTotal += $cost->amount;
            if($cost->type === 'Monthly') $monthlyTotal += $cost->amount;
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $cost->vehicle?->name ?? '-' }}</td>
                <td>{{ $cost->type }}</td>
                <td>{{ $cost->name }}</td>
                <td>{{ \Carbon\Carbon::parse($cost->date)->format('d M, Y') }}</td>
                <td>{{ number_format($cost->amount,2) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">No costs found.</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" style="text-align: right;">Per Trip Total</th>
                <th>৳ {{ number_format($perTripTotal,2) }}</th>
            </tr>
            <tr>
                <th colspan="5" style="text-align: right;">Monthly Total</th>
                <th>৳ {{ number_format($monthlyTotal,2) }}</th>
            </tr>
            <tr>
                <th colspan="5" style="text-align: right;">Overall Total</th>
                <th>৳ {{ number_format($overallTotal,2) }}</th>
            </tr>
        </tfoot>
    </table>
</body>

</html>