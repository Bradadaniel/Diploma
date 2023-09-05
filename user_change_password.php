<?php
include 'php/config.php';
include 'php/db_config.php';
require_once 'Mobile-Detect-2.8.39/Mobile_Detect.php';

$pdo = connectDatabase($dsn, $pdoOptions);
$msg = "";


if (isset($_GET['reset'])) {
    $code = $_GET['reset'];
    $check_code = $pdo->prepare("SELECT * FROM users WHERE code ='$code' ");
    $check_code->execute();
    if ($check_code->rowCount() > 0) {
        if (isset($_POST['submit'])){
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm-password'];
            if ($password === $confirm_password) {
                $encpass = password_hash($password, PASSWORD_BCRYPT);
                $new_code = '';
                $update_password = $pdo->prepare("UPDATE users SET password =:password, no_hash=:no_hash, code=:code WHERE code ='$code'");
                $update_password->bindParam(':password',$encpass,PDO::PARAM_STR);
                $update_password->bindParam(':no_hash',$password,PDO::PARAM_STR);
                $update_password->bindParam(':code',$new_code,PDO::PARAM_STR);
                $result = $update_password->execute();

                if ($result) {
                    header("Location:login.php");
                }
            }else {
                $msg = "<div class='alert alert-danger'>A jelszavak nem eggyeznek.</div>";
            }
        }
    } else {
        $msg = "<div class='alert alert-danger'>A link nem stimmel.</div>";
    }
} else {
    header("Location:user_forgot_password.php");
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
                    <h2>Change password</h2>
                    <p></p>
                    <?php echo $msg; ?>
                    <form action="" method="post">
                        <input type="password" class="password" name="password" placeholder="Enter you password" required>
                        <input type="password" class="confirm-password" name="confirm-password" placeholder="Confirm your password" required>
                        <button name="submit" class="btn" type="submit">Change password</button>
                    </form>
                    <div class="social-icons">
                        <p>Back! <a href="login.php">Login</a>.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>


<script src="js/jquery.min.js"></script>


</body>

</html>