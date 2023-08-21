<?php
include 'php/config.php';
include 'php/db_config.php';

$pdo = connectDatabase($dsn, $pdoOptions);

if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    // Módosítsd az "orders" táblát az elfogadott státuszra
    $update_sql = "UPDATE orders SET status = 'accepted' WHERE id = :order_id";
    $update_stmt = $pdo->prepare($update_sql);
    $update_stmt->bindParam(':order_id', $order_id);
    $update_stmt->execute();

    // Másold az elfogadott rendelést az "archive" táblába
    $insert_archive_sql = "INSERT INTO archive (order_id) VALUES (:order_id)";
    $insert_archive_stmt = $pdo->prepare($insert_archive_sql);
    $insert_archive_stmt->bindParam(':order_id', $order_id);
    $insert_archive_stmt->execute();

    echo "Success";
} else {
    echo "Error";
}
?>