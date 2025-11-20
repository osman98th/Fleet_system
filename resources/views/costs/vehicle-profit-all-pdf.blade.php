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

        .profit-positive {
            color: green;
        }

        .profit-negative {
            color: red;
        }
    </style>
</head>

<body>
    <h2>All Vehicles Profit Report</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Vehicle</th>
                <th>Total Income</th>
                <th>Total Fuel Cost</th>
                <th>Total Other Costs</th>
                <th>Net Profit</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $d)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $d['vehicle']->name }}</td>
                <td>৳ {{ number_format($d['income'],2) }}</td>
                <td>৳ {{ number_format($d['fuel'],2) }}</td>
                <td>৳ {{ number_format($d['otherCosts'],2) }}</td>
                <td class="{{ $d['profit'] < 0 ? 'profit-negative' : 'profit-positive' }}">
                    ৳ {{ number_format($d['profit'],2) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>