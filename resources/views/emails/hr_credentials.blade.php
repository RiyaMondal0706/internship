<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Basic reset for email clients */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Helvetica, Arial, sans-serif;
            background-color: #f4f7f6;
            color: #333333;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            margin-top: 20px;
            border: 1px solid #e0e0e0;
        }

        .header {
            background-color: #4e73df;
            padding: 30px;
            text-align: center;
            color: #ffffff;
        }

        .content {
            padding: 40px 30px;
            line-height: 1.6;
        }

        .credentials-box {
            background-color: #f8f9fc;
            border: 1px dashed #4e73df;
            border-radius: 6px;
            padding: 20px;
            margin: 25px 0;
        }

        .btn {
            display: inline-block;
            padding: 12px 30px;
            background-color: #4e73df;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
        }

        .footer {
            background-color: #f1f1f1;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #777777;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <h1 style="margin: 0; font-size: 24px;">Welcome to the Team!</h1>
        </div>

        <div class="content">
            <p style="font-size: 18px; margin-top: 0;">Hello <strong>{{ $name }}</strong>,</p>
            <p>We are pleased to inform you that your <strong>HR Account</strong> has been successfully created. You can
                now access the CorpPanel portal to manage your responsibilities.</p>

            <p>Below are your official login credentials. Please keep this information secure.</p>

            <div class="credentials-box">
                <p style="margin: 5px 0;"><strong>User ID:</strong> <span
                        style="color: #4e73df;">{{ $email }}</span></p>
                <p style="margin: 5px 0;"><strong>Password:</strong> <span
                        style="color: #4e73df;">{{ $password }}</span></p>
            </div>

            <center>
                <a href="{{ url('/login') }}" class="btn">Login to Dashboard</a>
            </center>

            <p style="margin-top: 30px; font-size: 14px; color: #666;">
                <em>Note: For security reasons, we recommend changing your password after your first login.</em>
            </p>
        </div>

        <div class="footer">
            <p style="margin: 0;">&copy; 2026 CorpPanel HR Management System</p>
            <p style="margin: 5px 0;">If you did not expect this email, please contact our IT support immediately.</p>
        </div>
    </div>
</body>

</html>
