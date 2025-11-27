<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f7f7f7; padding: 30px;">

<div style="max-width: 500px; margin:auto; background:white; padding:20px; border-radius:10px;">
    
    <h2 style="color:#333;">Reset Your Password</h2>

    <p>Hello,</p>
    <p>You requested to reset your password. Click the button below:</p>

    <p style="text-align:center;">
        <a href="{{ $resetUrl }}" 
           style="background:#3b82f6; padding:12px 25px; color:white; text-decoration:none; border-radius:6px;">
            Reset Password
        </a>
    </p>

    <p>If the button doesn't work, copy this link:</p>
    <p style="word-break: break-all; color:#555;">
        {{ $resetUrl }}
    </p>

    <p style="margin-top:25px;">Regards,<br>Your Team</p>

</div>

</body>
</html>
