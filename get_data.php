<?php
include 'php/config.php';
include 'php/db_config.php';

$pdo = connectDatabase($dsn, $pdoOptions);

$query = "SELECT user_id, username, email, phone, status FROM users";
$stmt = $pdo->prepare($query);
$stmt->execute();

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($data);

$pdo = null;