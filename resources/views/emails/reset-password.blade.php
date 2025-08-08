<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reset Password - KMS KKN</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 0 0 5px 5px;
        }
        .button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #666;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reset Password - KMS KKN</h1>
    </div>
    
    <div class="content">
        <p>Halo,</p>
        
        <p>Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.</p>
        
        <p>Klik tombol di bawah untuk reset password Anda:</p>
        
        <div style="text-align: center;">
            <a href="{{ $resetUrl }}" class="button">Reset Password</a>
        </div>
        
        <p>Link ini akan kadaluarsa dalam 60 menit.</p>
        
        <p>Jika Anda tidak meminta reset password, abaikan email ini.</p>
        
        <p>Terima kasih,<br>Tim KMS KKN</p>
    </div>
    
    <div class="footer">
        <p>Email ini dikirim otomatis, mohon tidak membalas email ini.</p>
    </div>
</body>
</html>
