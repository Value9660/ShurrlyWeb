<!DOCTYPE html>
<html>
<head>
    <title>Reset Email Verification</title>
</head>
<body>
    <p>Hello <?php echo e($user->name); ?>,</p>

    <p>Your OTP for email verification is: <?php echo e($otp); ?></p>

    <p>This code is valid for 5 minutes. Please use it to verify your email address.</p>

    <p>Thank you!</p>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\TestTody\resources\views/email/forget_password.blade.php ENDPATH**/ ?>