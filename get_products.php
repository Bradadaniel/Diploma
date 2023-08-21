<?php
include 'php/config.php';
include 'php/db_config.php';

$pdo = connectDatabase($dsn, $pdoOptions);

$sql = "SELECT product_id, product_category, product_name, product_size, product_detail, product_brand, product_action FROM products";
$stmt = $pdo->query($sql);

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// JSON válasz küldése a DataTables-nek
echo json_encode($data);