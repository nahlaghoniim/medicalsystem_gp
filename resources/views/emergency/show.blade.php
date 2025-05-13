<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emergency Information</title>
    <style>
        /* Your styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #1D5E86;
        }
        .card {
            background: #FF9B8C;
            padding: 15px;
            margin-top: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .card h3 {
            margin: 0;
            font-size: 18px;
            color: #fff;
        }
        .card p {
            color: #fff;
        }
        .button {
            background-color: #1B8332;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
        }
        .button:hover {
            background-color: #167522;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Emergency Information</h1>

        <!-- Display error message if available -->
        @if(isset($message))
            <div class="card">
                <p>{{ $message }}</p>
            </div>
        @else
            <!-- Display patient data if available -->
            <div class="card">
                <h3>Patient Name: {{ $name }}</h3>
                <p>Age: {{ $age }}</p>
                <p>Blood Group: {{ $blood_group }}</p>
                <p>Allergies: {{ $allergies }}</p>
                <p>Medical Conditions: {{ $medical_conditions }}</p>
                <p>Emergency Contact Name: {{ $emergency_contact_name }}</p>
                <p>Emergency Contact Phone: {{ $emergency_contact_phone }}</p>
                <p>Condition: {{ $condition }}</p>
                <p>Condition Status: {{ $condition_status }}</p>
                <a href="tel:+123456789" class="button">Contact Emergency</a>
            </div>
        @endif
    </div>
</body>
</html>
