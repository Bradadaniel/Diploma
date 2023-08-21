<?php
include 'php/config.php';
include 'php/db_config.php';

$pdo = connectDatabase($dsn, $pdoOptions);

if (isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];

    $query = "SELECT product_size FROM products WHERE product_id = :product_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
    $stmt->execute();

    $sizes = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($sizes) {
        $sizeOptions = '';
        foreach (explode(',', $sizes['product_size']) as $individualSize) {
            $sizeOptions .= "<option value=\"" . htmlspecialchars($individualSize) . "\">" . htmlspecialchars($individualSize) . "</option>";
        }
        echo $sizeOptions;
    }
}