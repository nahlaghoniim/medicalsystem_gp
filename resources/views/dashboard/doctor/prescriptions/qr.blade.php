<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription QR Code</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: #F9FAFB;
            color: #0E0F11;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .card {
            background: #fff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        h1 {
            color: #1D5E86;
            font-size: 24px;
            margin-bottom: 24px;
        }

        .qr svg {
            width: 180px;
            height: auto;
        }

        .btn {
            margin-top: 32px;
            display: inline-block;
            background-color: #1D5E86;
            color: #fff;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.3s;
        }

        .btn:hover {
            background-color: #144866;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Scan Prescription QR Code</h1>
        <div class="qr">
            {!! $qrCode !!}
        </div>
        <a href="{{ route('dashboard.doctor.prescriptions.index') }}" class="btn">← Back to Prescriptions</a>
    </div>
</body>
</html>
