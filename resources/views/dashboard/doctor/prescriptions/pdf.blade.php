<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Prescription - {{ $prescription->patient->name }}</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            padding: 40px 50px;
            background: #fff;
            color: #333;
        }

        .header {
            display: flex;
            align-items: center;
            gap: 20px;
            border-bottom: 3px solid #1D5E86;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }

        .logo img {
            height: 70px;
        }

        .clinic-info {
            line-height: 1.4;
        }

        .clinic-name-main {
            font-size: 24px;
            font-weight: bold;
            color: #1D5E86;
        }

        .clinic-sub {
            font-size: 14px;
            color: #666;
        }

        h1 {
            text-align: center;
            color: #1D5E86;
            margin-bottom: 30px;
            font-size: 28px;
        }

        .details {
            margin-bottom: 30px;
            font-size: 15px;
        }

        .details p {
            margin: 6px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 15px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 12px 10px;
            text-align: left;
        }

        th {
            background-color: #e6f0f6;
            color: #1D5E86;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer {
            margin-top: 60px;
            text-align: center;
            font-size: 13px;
            color: #888;
            border-top: 1px dashed #ccc;
            padding-top: 10px;
        }

        .qr {
            text-align: right;
            margin-top: 20px;
        }

        .qr img {
            height: 100px;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <div class="logo">
            <img src="{{ public_path('images/wessal.png') }}" alt="Wessal Logo">
        </div>
        <div class="clinic-info">
            <div class="clinic-name-main">Wessal</div>
            <div class="clinic-sub">Specialized Medical Clinic</div>
        </div>
    </div>

    <!-- Title -->
    <h1>Medical Prescription</h1>

    <!-- Patient & Doctor Info -->
    <div class="details">
        <p><strong>Patient Name:</strong> {{ $prescription->patient->name }}</p>
        <p><strong>Doctor:</strong> {{ $prescription->doctor->name ?? 'N/A' }}</p>
        <p><strong>Date Issued:</strong> {{ $prescription->issued_at->format('F d, Y') }}</p>
    </div>

    <!-- Prescription Table -->
    <table>
        <thead>
            <tr>
                <th>Medicine Name</th>
                <th>Dosage</th>
                <th>Instructions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($prescription->items as $item)
                <tr>
                    <td>{{ $item->medication->name ?? $item->medicine_name ?? 'Unknown' }}

</td>
                    <td>{{ $item->dosage }}</td>
                    <td>{{ $item->instructions ?? 'Take as directed' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- QR Code -->
    <div class="qr">
        {!! $qrCode !!}
    </div>

    <!-- Footer -->
    <div class="footer">
        Wessal Specialized Clinic — All Rights Reserved © {{ now()->year }}
    </div>

</body>
</html>
