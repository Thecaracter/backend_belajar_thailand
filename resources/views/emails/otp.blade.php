<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #2D2A4A, #A51931);
            color: white;
            padding: 20px;
            text-align: center;
        }

        .content {
            padding: 30px;
        }

        .otp {
            font-size: 32px;
            font-weight: bold;
            text-align: center;
            color: #2D2A4A;
            margin: 30px 0;
            padding: 15px;
            background-color: #f0f0f0;
            border-radius: 8px;
            border: 2px dashed #A51931;
        }

        .footer {
            background-color: #2D2A4A;
            color: #ffffff;
            text-align: center;
            padding: 15px;
            font-size: 12px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #A51931;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Password Reset OTP</h1>
        </div>
        <div class="content">
            <p>Hello,</p>
            <p>You have requested to reset your password. Please use the following One-Time Password (OTP) to proceed
                with your password reset:</p>
            <div class="otp">{{ $otp }}</div>
            <p>This OTP will expire in 15 minutes for security reasons. If you did not request a password reset, please
                ignore this email or contact support if you have concerns.</p>
            <p>To reset your password, please click the button below and enter this OTP:</p>
            <center><a href="#" class="button">Reset Password</a></center>
            <p>Thank you for using our service!</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Codingin. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
