<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice - INV-{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
        }

        .company-address {
            font-size: 12px;
            color: #555;
        }

        .invoice-title {
            font-size: 20px;
            font-weight: bold;
            margin-top: 20px;
        }

        .details,
        .items {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .details td {
            padding: 5px;
            vertical-align: top;
        }

        .items th {
            background: #eee;
            padding: 10px;
            border: 1px solid #ddd;
        }

        .items td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .total {
            text-align: right;
            font-weight: bold;
        }

        .barcode,
        .qrcode {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="invoice-box" >
        <!-- container  -->
        <div style="display: flex; justify-content:space-between;">
        <!-- 1st -->
         <div>
            <div class="company-name">Fleet Management Co.</div>
        <div class="company-address">
            123 Main Street, Dhaka, Bangladesh<br>
            Phone: +880123456789 | Email: info@fleetco.com
        </div>
        
    </div>
    <!-- second  -->
     <div class="barcode">
            <strong>Barcode:</strong><br>
            <img src="data:image/png;base64,{{ $barcode }}" alt="Invoice Barcode">
        </div>
        </div>
        

        <div class="invoice-title">Invoice</div>
        <table class="details">
            <tr>
                <td>
                    <strong>Customer:</strong> {{ $booking->customer->name }}<br>
                    <strong>Email:</strong> {{ $booking->customer->email }}<br>
                    <strong>Phone:</strong> {{ $booking->customer->phone ?? 'N/A' }}
                </td>
                <td>
                    <strong>Invoice #:</strong> INV-{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}<br>
                    <strong>Date:</strong> {{ $booking->created_at->format('d-m-Y') }}<br>
                    <strong>Status:</strong> {{ ucfirst($booking->status) }}
                </td>
            </tr>
        </table>

        <table class="items">
            <thead>
                <tr>
                    <th>Vehicle</th>
                    <th>Driver</th>
                    <th>Car Type</th>
                    <th>Charge Type</th>
                    <th>Distance (KM)</th>
                    <th>Fare (BDT)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $booking->vehicle->name }} ({{ $booking->vehicle->license_plate }})</td>
                    <td>{{ $booking->driver->name }} ({{ $booking->driver->gender }})</td>
                    <td>{{ strtoupper($booking->car_type) }}</td>
                    <td>{{ ucfirst($booking->charge_type) }}</td>
                    <td>{{ $booking->distance ?? '-' }}</td>
                    <td>{{ number_format($booking->fare, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="total">
            Total: BDT {{ number_format($booking->fare, 2) }}
        </div>

        

        <div class="qrcode">
            <strong>QR Code:</strong><br>
            <img src="data:image/svg+xml;base64,{{ $qrCode }}" alt="Invoice QR Code">
        </div>

        <p style="margin-top:30px; font-size:12px; color:#777;">
            Thank you for choosing Fleet Management Co. <br>
            This is a system generated invoice.
        </p>
    </div>
</body>

</html>