<?php
require_once 'library/lib.php';
require_once 'classes/auth.php';

$lib = new Lib;
$validate = new Auth;

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $validate->generateResetCode($email);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link href="users/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="users/css/sb-admin.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="card card-login mx-auto mt-5">
        <div class="card-header">Forgot Password</div>
        <div class="card-body">
            <form action="forgot_password.php" method="post">
                <div class="form-group">
                    <label for="email">Enter your email address:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <button type="submit" name="submit" class="btn btn-primary btn-block">Submit</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
