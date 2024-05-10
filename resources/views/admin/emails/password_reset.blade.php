<!DOCTYPE html>
<html>
<head>
    <style>
        /* Add your custom styles here */
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            max-width: 200px;
            height: auto;
        }
        .message {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 3px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="{{ asset('path/to/your/logo.png') }}" alt="Logo">
        </div>
        <div class="message">
            <h1>Password Reset</h1>
            <p>Hello,</p>
            <p>We received a request to reset your password. Click the button below to reset your password:</p>
            <p><a class="btn" href="{{ $resetLink }}">Reset Password</a></p>
            <p>If you didn't request a password reset, no further action is required.</p>
            <p>Regards,<br>Sheba Capital Ltd.</p>
        </div>
    </div>
</body>
</html>