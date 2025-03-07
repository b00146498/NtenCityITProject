<!DOCTYPE html>
<html>
<head>
    <title>Appointment Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            text-align: center;
        }
        .content {
            padding: 20px;
            border: 1px solid #ddd;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Appointment Confirmation</h1>
        </div>
        
        <div class="content">
            <p>Hello {{ $clientName }},</p>
            
            <p>Your appointment has been successfully booked!</p>
            
            <h3>Appointment Details:</h3>
            <p><strong>Doctor:</strong> {{ $doctorName }}</p>
            <p><strong>Date:</strong> {{ $appointmentDate }}</p>
            <p><strong>Time:</strong> {{ $appointmentTime }}</p>
            <p><strong>Reference Number:</strong> #{{ $appointmentId }}</p>
            
            <p>If you need to reschedule or cancel your appointment, please contact us at least 24 hours in advance.</p>
            
            <p>Thank you for choosing our service!</p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} NTenCity. All rights reserved.</p>
        </div>
    </div>
</body>
</html>