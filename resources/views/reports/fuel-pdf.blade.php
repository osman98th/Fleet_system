<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Fuel Report</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        th {
            background-color: #ddd;
        }
    </style>
</head>

<body>
    <h3 style="text-align: center;">⛽ Fuel Report</h3>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Vehicle</th>
                <th>Total Liters</th>
                <th>Total Cost</th>
                <th>Avg Cost per Liter</th>
                <th>Total Days</th>
                <th>Total KM</th>
                <th>Cost per Day</th>
                <th>Cost per KM</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportData as $key => $r)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $r->vehicle_name ?? '-' }}</td>
                <td>{{ number_format($r->total_liters ?? 0, 2) }}</td>
                <td>{{ number_format($r->total_cost ?? 0, 2) }}</td>
                <td>{{ number_format($r->avg_cost_per_liter ?? 0, 2) }}</td>
                <td>{{ $r->total_days ?? 0 }}</td>
                <td>{{ number_format($r->total_km ?? 0, 2) }}</td>
                <td>{{ number_format($r->cost_per_day ?? 0, 2) }}</td>
                <td>{{ number_format($r->cost_per_km ?? 0, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if(!empty($chartImage))
    <div style="text-align:center; margin-top:20px;">
        <img src="{{ $chartImage }}" alt="Fuel Chart" style="max-width:100%;">
    </div>
    @endif
</body>

</html>