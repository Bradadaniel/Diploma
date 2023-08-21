<?php
session_start();

include 'php/config.php';
include 'php/db_config.php';
$pdo = connectDatabase($dsn, $pdoOptions);
$id = $_SESSION['ID'];

if (isset($_GET['remove'])) {
    $removeProductId = $_GET['remove'];

    // SQL parancs a termék eltávolításához
    $remove_sql = "DELETE FROM wishlist WHERE user_id = :user_id AND product_id = :product_id";
    $remove_stmt = $pdo->prepare($remove_sql);
    $remove_stmt->bindParam(':user_id', $id);
    $remove_stmt->bindParam(':product_id', $removeProductId);
    $remove_stmt->execute();

    header("Location: wishlist.php");
}