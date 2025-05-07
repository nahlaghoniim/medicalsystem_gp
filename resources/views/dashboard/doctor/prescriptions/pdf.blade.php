<!DOCTYPE html>
<html>
<head>
    <title>Prescription</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { color: #1D5E86; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ccc; }
        th, td { padding: 8px; text-align: left; }
        th { font-weight: bold; background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h1>Prescription Details</h1>

    <p><strong>Patient:</strong> {{ $prescription->patient->name }}</p>
    <p><strong>Doctor:</strong> {{ $prescription->doctor->name ?? 'N/A' }}</p>
    <p><strong>Issued At:</strong> {{ $prescription->issued_at->format('Y-m-d') }}</p>

    <h2>Prescription Items</h2>
    <table>
        <thead>
            <tr>
                <th>Drug Name</th>
                <th>Dosage</th>
                <th>Instructions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($prescription->items as $item)
                <tr>
                    <td>{{ $item->medicine_name }}</td>
                    <td>{{ $item->dosage }}</td>
                    <td>{{ $item->instructions ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>QR Code</h2>
    <div>
        {!! $qrCode !!}
    </div>
</body>
</html>
