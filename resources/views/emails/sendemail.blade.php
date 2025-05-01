<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <p>You requested a password reset. Click the link below to reset your password:</p>
    <a href="{{ url('admin/reset-password/'.$token) }}">Reset Password</a>
</body>
</html>
