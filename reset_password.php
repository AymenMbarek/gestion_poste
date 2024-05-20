<?php
require_once 'library/lib.php';
require_once 'classes/auth.php';

$lib = new Lib;
$validate = new Auth;

if (isset($_POST['reset'])) {
    $email = $_POST['email'];
    $code = $_POST['code'];
    $newPassword = $_POST['password'];
    $validate->resetPassword($email, $code, $newPassword);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link href="users/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="users/css/sb-admin.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="card card-login mx-auto mt-5">
        <div class="card-header">Reset Password</div>
        <div class="card-body">
            <form action="reset_password.php" method="post">
                <div class="form-group">
                    <label for="email">Enter your email address:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="code">Enter the reset code:</label>
                    <input type="text" id="code" name="code" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Enter your new password:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <button type="submit" name="reset" class="btn btn-primary btn-block">Reset Password</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
