<?php
include 'php/config.php';
include 'php/db_config.php';

$pdo = connectDatabase($dsn, $pdoOptions);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["edit_user_id"];
    $username = $_POST["edit_username"];
    $email = $_POST["edit_email"];
    $phone = $_POST["edit_phone"];
    $status = $_POST["edit_status"];

    $query = "UPDATE users SET username = :username, email = :email, phone = :phone, status = :status WHERE user_id = :user_id";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":user_id", $user_id);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":phone", $phone);
    $stmt->bindParam(":status", $status);

    $stmt->execute();
}

$pdo = null;

header("Location: admin-users.php");