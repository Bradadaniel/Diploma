<?php
include 'php/config.php';
include 'php/db_config.php';

$pdo = connectDatabase($dsn, $pdoOptions);


$sql = "SELECT id, user_id, product_data, phone, name, total_price, payment_method, address, status FROM orders WHERE status = 'pending'";
$stmt = $pdo->query($sql);

if ($stmt) {
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
} else {
    echo "Error executing SQL query.";
}