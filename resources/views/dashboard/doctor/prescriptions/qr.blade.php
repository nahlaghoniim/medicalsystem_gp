<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code</title>
    <style>
        /* Global styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Center content */
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #fff;
            padding: 20px;
        }

        /* Heading style */
        h2 {
            font-size: 24px;
            color: #1D5E86;
            margin-bottom: 20px;
        }

        /* QR Code container styling */
        .qr-container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        /* Optional styling for the QR code itself */
        .qr-container svg {
            margin-top: 20px;
            max-width: 150px;
            height: auto;
        }

        /* Button style */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            text-decoration: none;
            background-color: #1D5E86;
            color: white;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
        }

        .btn:hover {
            background-color: #155a74;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            h2 {
                font-size: 20px;
            }

            .qr-container {
                padding: 15px;
            }

            .btn {
                padding: 8px 16px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>QR Code for Prescription</h2>
        <div class="qr-container">
            <!-- Display the generated QR code -->
            {!! $qrCode !!}
        </div>
        <!-- Optional: Link to go back or to another page -->
        <a href="{{ route('dashboard.doctor.prescriptions.index') }}" class="btn">Back to Prescriptions</a>
    </div>
</body>

</html>
