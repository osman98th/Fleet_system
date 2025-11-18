<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Total Expense Report</title>
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

        tfoot th {
            background-color: #bbb;
        }
    </style>
</head>

<body>
    <h3 style="text-align: center;">💰 Total Expense Report</h3>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Type</th>
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
            @foreach($records as $key => $r)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $r->type ?? 'N/A' }}</td>
                <td>{{ $r->date ?? 'N/A' }}</td>
                <td>{{ $r->vehicle->name ?? '-' }}</td>
                <td>{{ number_format($r->fuel_cost ?? 0, 2) }}</td>
                <td>{{ number_format($r->maintenance_cost ?? 0, 2) }}</td>
                <td>{{ number_format($r->food_cost ?? 0, 2) }}</td>
                <td>{{ number_format($r->stipend_cost ?? 0, 2) }}</td>
                <td>{{ number_format($r->parking_cost ?? 0, 2) }}</td>
                <td>{{ number_format($r->toll_cost ?? 0, 2) }}</td>
                <td>
                    {{ number_format(
                        ($r->fuel_cost ?? 0) + 
                        ($r->maintenance_cost ?? 0) + 
                        ($r->food_cost ?? 0) + 
                        ($r->stipend_cost ?? 0) + 
                        ($r->parking_cost ?? 0) + 
                        ($r->toll_cost ?? 0), 2) 
                    }}
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="10" style="text-align: right;">Grand Total:</th>
                <th>{{ number_format($totalExpense ?? 0, 2) }}</th>
            </tr>
        </tfoot>
    </table>
</body>

</html>