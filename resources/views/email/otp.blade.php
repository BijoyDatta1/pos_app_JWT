<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Your OTP Code</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 40px;
            color: #333;
        }
        .container {
            background-color: #ffffff;
            max-width: 500px;
            margin: auto;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .otp {
            font-size: 32px;
            font-weight: bold;
            color: #e63946;
            letter-spacing: 4px;
            text-align: center;
            margin: 30px 0;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            text-align: center;
            color: #999;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            color: #1d3557;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>🔐 Your OTP Code</h2>
        </div>

        <p>Hello,</p>
        <p>Use the OTP below to proceed. This code is valid for 10 minutes:</p>

        <div class="otp">{{ $otp }}</div>

        <p>If you did not request this, please ignore this email.</p>

        <div class="footer">
            &copy; {{ date('Y') }} Your Company. All rights reserved.
        </div>
    </div>
</body>
</html>