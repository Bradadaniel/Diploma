<?php

include 'php/config.php';
include 'php/db_config.php';
require_once 'Mobile-Detect-2.8.39/Mobile_Detect.php';

$pdo = connectDatabase($dsn, $pdoOptions);

$msg = '';
$code ='';

session_start();

if (isset($_SESSION['SESSION_EMAIL'])) {
    $email = $_SESSION['SESSION_EMAIL'];
}

if (isset($_GET['verification'])) {
    $ver = $_GET['verification'];
    $check_verification = $pdo->prepare("SELECT * FROM users WHERE code ='$ver' ");
    $check_verification->execute();
    if ($check_verification->rowCount() > 0) {
        $update_verification=$pdo->prepare("UPDATE users SET code='$code' WHERE code='$ver' ");
        $update_verification->execute();
        if ($update_verification){
            $msg = "<div class='alert alert-success'>You have successfully verified your account.</div>";
        }
    }else {
        header("Location: index.php");
    }
}

if (isset($_POST['submit'])){

    $email = $_POST['email'];
    $passowrd = $_POST['password'];

    $check_login = $pdo->prepare("SELECT * FROM users WHERE email = ? and no_hash = ?");
    $check_login->execute([$email, $passowrd]);

    if ($check_login->rowCount() === 1) {
        $row = $check_login->fetch(PDO::FETCH_ASSOC);
        $id = $row['user_id'];
        $user_type=$row['user_type'];
        $status = $row['status'];

        if ($status == 'active') {
            if (empty($row['code'])) {
                if ($user_type == 'user') {
                    $_SESSION['SESSION_EMAIL'] = $email;
                    $_SESSION['ID'] = $id;

                    header("Location: index.php");
                } elseif ($user_type == 'admin') {

                    $_SESSION['SESSION_EMAIL'] = $email;
                    header("Location:admin.php");
                }
            } else {

                $msg = "<div class='alert alert-danger'>Verify your account identity.</div>";
            }
        }else{
            $msg = "<div class='alert alert-danger'>Your account has been suspended.</div>";
        }
    }
    else{
        $msg = "<div class='alert alert-danger'>Incorrect username or password.</div>";
    }
}

?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Login Form</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords"
          content="Login Form" />

    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="css/register-style.css" type="text/css" media="all" />


    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>
</head>
<body>

<section class="w3l-mockup-form">
    <div class="container">

        <div class="workinghny-form-grid">
            <div class="main-mockup">
                <div class="alert-close">
                       <a href="index.php" style="color: var(--white)"><span class="fa fa-close"></span></a>
                </div>
                <div class="w3l_form align-self">
                    <div class="left_grid_info">
                        <img src="img/Dabe-logos_black2.png" alt="">
                    </div>
                </div>
                <div class="content-wthree">
                    <h2>Login</h2>
                    <p>Welcome to us! This is DabeShop, fashion and quality in one place.</p>
                    <?php echo $msg; ?>
                    <form action="" method="post">
                        <input type="email" class="email" name="email" id="email" placeholder="Enter your email address" required>
                        <input type="password" class="password" name="password" id="password" placeholder="Enter your password" style="margin-bottom: 2px;" required>
                        <p><a href="user_forgot_password.php" style="margin-bottom: 15px; display: block; text-align: right;">Forgot your password?</a></p>
                        <button name="submit" name="submit" id="submit" class="btn" type="submit">Log in</button>
                    </form>
                    <div class="social-icons">
                        <p>Register now! <a href="register.php">Register</a>.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

</body>

</html>