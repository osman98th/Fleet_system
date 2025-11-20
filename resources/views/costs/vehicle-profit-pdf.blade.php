<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Vehicle Profit Report</title>
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
    </style>
</head>

<body>
    <h2>Vehicle Profit Report</h2>

    @if(request('month'))
    <p style="text-align:center;">Month: {{ \Carbon\Carbon::parse(request('month').'-01')->format('F Y') }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Vehicle</th>
                <th>Fuel Cost (৳)</th>
                <th>Other Costs (৳)</th>
                <th>Income (৳)</th>
                <th>Profit (৳)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item['vehicle']->name }}</td>
                <td>{{ number_format($item['fuel'],2) }}</td>
                <td>{{ number_format($item['otherCosts'],2) }}</td>
                <td>{{ number_format($item['income'],2) }}</td>
                <td>{{ number_format($item['profit'],2) }}</td>
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