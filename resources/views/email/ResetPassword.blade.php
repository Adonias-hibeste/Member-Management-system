<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset - FCMS</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #e9ecef;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 10px;
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            font-size: 28px;
            font-weight: bold;
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }

        .content {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 20px;
            color: #333333;
        }

        .card {
            border: 1px solid #007bff;
            padding: 15px;
            border-radius: 5px;
            background-color: #f1f8ff;
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            margin: 20px 0;
            color: #007bff;
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
            text-align: center;
            color: #666666;
        }

        .signature {
            margin-top: 20px;
            font-size: 16px;
            font-weight: bold;
            text-align: right;
            color: #007bff;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">Password Reset Request</div>
        <div class="content">
            <p>Hello {{ $user->full_name }},</p>
            <p>We have successfully reset your password for your FCMS account. Below is your new password for logging
                in:</p>
            <div class="card">
                {{ $newPassword }}
            </div>
            <p>Please keep this password confidential. After logging in, we recommend changing your password in the
                settings for enhanced security.</p>
            <p>If you did not request this change, please <a href="mailto:support@fcms.com">contact our support team</a>.
            </p>
        </div>
        <div class="footer">
            <p>Best regards,</p>
            <p class="signature">The FCMS Team</p>
        </div>
    </div>
</body>

</html>
