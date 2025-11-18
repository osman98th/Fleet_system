<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice - INV-{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
        }

        .header h2 {
            margin: 5px 0;
            font-size: 20px;
            color: #555;
        }

        .section {
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #000;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
        }

        .right {
            text-align: right;
        }

        .barcode,
        .qrcode {
            margin-top: 15px;
            text-align: center;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 14px;
            color: #555;
        }
    </style>
</head>

<body>

    {{-- Company Header --}}
    <div class="header">
        <h1>Fleet Management System</h1>
        <h2>Company Name: Your Company Ltd.</h2>
        <p>Invoice No: INV-{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</p>
        <p>Date: {{ date('d-m-Y', strtotime($booking->created_at)) }}</p>
    </div>

    {{-- Customer Details --}}
    <div class="section">
        <h3>Customer Details</h3>
        <table>
            <tr>
                <th>Name</th>
                <td>{{ $booking->customer->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $booking->customer->email ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Phone</th>
                <td>{{ $booking->customer->phone ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Address</th>
                <td>{{ $booking->customer->address ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>

    {{-- Booking Details --}}
    <div class="section">
        <h3>Booking Details</h3>
        <table>
            <tr>
                <th>Vehicle</th>
                <td>{{ $booking->vehicle->name }} ({{ $booking->vehicle->license_plate }})</td>
            </tr>
            <tr>
                <th>Driver</th>
                <td>{{ $booking->driver->name }} ({{ $booking->driver->gender }})</td>
            </tr>
            <tr>
                <th>Car Type</th>
                <td>{{ strtoupper($booking->car_type) }}</td>
            </tr>
            <tr>
                <th>Charge Type</th>
                <td>{{ strtoupper($booking->charge_type) }}</td>
            </tr>
            @if($booking->charge_type == 'km')
            <tr>
                <th>Distance (KM)</th>
                <td>{{ $booking->distance ?? 0 }}</td>
            </tr>
            @endif
            <tr>
                <th>Start Date</th>
                <td>{{ $booking->start_datetime }}</td>
            </tr>
            <tr>
                <th>End Date</th>
                <td>{{ $booking->end_datetime }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ ucfirst($booking->status) }}</td>
            </tr>
            <tr>
                <th>Total Fare</th>
                <td>{{ number_format($booking->fare,2) }} ৳</td>
            </tr>
        </table>
    </div>

    {{-- Barcode & QR Code --}}
    <div class="section">
        <div class="barcode">
            <img src="data:image/png;base64,{{ $barcode }}" alt="Barcode">
        </div>
        <div class="qrcode">
            <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code">
        </div>
    </div>

    {{-- Footer --}}
    <div class="footer">
        <p>Thank you for choosing Fleet Management System.</p>
        <p>Your Company Ltd. | www.yourcompany.com | support@yourcompany.com</p>
    </div>

</body>

</html>