<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Fuel Expense Report</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 50px 25px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 0;
        }

        header {
            position: fixed;
            top: -40px;
            left: 0;
            right: 0;
            height: 100px;
            text-align: center;
        }

        footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            height: 50px;
            text-align: center;
            font-size: 10px;
            color: #555;
        }

        .header img.logo {
            max-height: 60px;
            margin-bottom: 5px;
        }

        .company-name {
            font-size: 18px;
            font-weight: bold;
        }

        .company-address {
            font-size: 12px;
            margin-bottom: 5px;
        }

        h3 {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #333;
        }

        th,
        td {
            padding: 6px 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #e0f7fa;
        }

        .totals-row {
            font-weight: bold;
            background-color: #dcdcdc;
        }

        .daily-table th,
        .daily-table td {
            text-align: right;
        }

        h4 {
            margin-top: 30px;
            margin-bottom: 10px;
        }

        .icon {
            height: 14px;
            vertical-align: middle;
            margin-right: 4px;
        }

        .chart-container {
            width: 100%;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <header>
        <img src="{{ public_path('logo.png') }}" alt="Company Logo" class="logo">
        <div class="company-name">Fleet Management Co.</div>
        <div class="company-address">
            64 Ramna Park Avenue, Dhaka, Bangladesh<br>
            ফোন: +8801797147515 | ইমেইল: osman98th@gamilcom.com
        </div>
        <h3>Fuel Expense Report</h3>
    </header>

    <footer>
        পৃষ্ঠা: {PAGE_NUM} / {PAGE_COUNT} | Fleet Management Co.
    </footer>

    <main>
        @php
        $columns = [
        ['title' => 'Vehicle', 'field' => 'vehicle_name', 'icon' => 'car.png'],
        ['title' => 'Total Liters', 'field' => 'total_liters', 'icon' => 'liters.png'],
        ['title' => 'Total Cost', 'field' => 'total_cost', 'icon' => 'cost.png'],
        ['title' => 'Avg Cost / Liter', 'field' => 'avg_cost_per_liter', 'icon' => null],
        ['title' => 'Total Days', 'field' => 'total_days', 'icon' => null],
        ['title' => 'Total KM', 'field' => 'total_km', 'icon' => null],
        ['title' => 'Cost / Day', 'field' => 'cost_per_day', 'icon' => null],
        ['title' => 'Cost / KM', 'field' => 'cost_per_km', 'icon' => null],
        ];

        $totals = [];
        foreach ($columns as $col) {
        $totals[$col['field']] = 0;
        }
        @endphp

        <div class="chart-container">
            <img src="{{ $chartImage ?? '' }}" alt="Fuel Cost Chart" style="max-width:90%; height:auto;">
        </div>

        <!-- Fuel Report Table -->
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    @foreach($columns as $col)
                    <th>
                        @if($col['icon'])
                        <img src="{{ public_path('icons/'.$col['icon']) }}" class="icon" alt="{{ $col['title'] }}">
                        @endif
                        {{ $col['title'] }}
                    </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse($reportData as $index => $r)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    @foreach($columns as $col)
                    <td>{{ $r->{$col['field']} ?? '-' }}</td>
                    @php
                    if(isset($r->{$col['field']}) && is_numeric($r->{$col['field']})) {
                    $totals[$col['field']] += $r->{$col['field']};
                    }
                    @endphp
                    @endforeach
                </tr>
                @empty
                <tr>
                    <td colspan="{{ count($columns)+1 }}">No records found.</td>
                </tr>
                @endforelse

                @if($reportData->count())
                <tr class="totals-row">
                    <td>Totals</td>
                    @foreach($columns as $col)
                    @if(in_array($col['field'], ['vehicle_name','avg_cost_per_liter','cost_per_day','cost_per_km']))
                    <td>-</td>
                    @else
                    <td>{{ $totals[$col['field']] }}</td>
                    @endif
                    @endforeach
                </tr>
                @endif
            </tbody>
        </table>

        <!-- Daily Fuel Cost Table -->
        @if($dailyData->count())
        <h4>Daily Fuel Cost</h4>
        <table class="daily-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Daily Cost</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dailyData as $d)
                <tr>
                    <td>{{ $d->date }}</td>
                    <td>{{ $d->daily_cost }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </main>

</body>

</html>