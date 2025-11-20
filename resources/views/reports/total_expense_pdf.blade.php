<!DOCTYPE html>
<html>

<head>
    <title>Total Expense Report</title>
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

        table,
        th,
        td {
            border: 1px solid #000;
        }

        th,
        td {
            padding: 5px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>
    <h3 style="text-align:center;">Total Expense Report</h3>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Vehicle</th>
                <th>Fuel</th>
                <th>Maintenance</th>
                <th>Food</th>
                <th>Stipend</th>
                <th>Parking</th>
                <th>Toll</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $index => $r)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($r->date)->format('d M Y') }}</td>
                <td>{{ $r->vehicle->name ?? 'N/A' }}</td>
                <td>{{ number_format($r->fuel_cost ?? 0,2) }}</td>
                <td>{{ number_format($r->maintenance_cost ?? 0,2) }}</td>
                <td>{{ number_format($r->food_cost ?? 0,2) }}</td>
                <td>{{ number_format($r->stipend_cost ?? 0,2) }}</td>
                <td>{{ number_format($r->parking_cost ?? 0,2) }}</td>
                <td>{{ number_format($r->toll_cost ?? 0,2) }}</td>
                <td>{{ number_format(
                        ($r->fuel_cost ?? 0)+($r->maintenance_cost ?? 0)+($r->food_cost ?? 0)+
                        ($r->stipend_cost ?? 0)+($r->parking_cost ?? 0)+($r->toll_cost ?? 0),2) 
                    }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="9" style="text-align:right;">Grand Total</th>
                <th>{{ number_format($totalExpense, 2) }}</th>
            </tr>
        </tfoot>
    </table>
</body>

</html>