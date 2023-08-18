<?php

include 'php/config.php';
include 'php/db_config.php';

$pdo = connectDatabase($dsn, $pdoOptions);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["user_id"];

    $query = "DELETE FROM users WHERE user_id = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $user_id);

    $stmt->execute();
}

$pdo = null;