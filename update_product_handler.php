<?php
include 'php/config.php';
include 'php/db_config.php';

$pdo = connectDatabase($dsn, $pdoOptions);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_category = $_POST['product_category'];
    $product_size = $_POST['product_size'];
    $product_price = $_POST['product_price'];
    $product_detail = $_POST['product_detail'];
    $product_brand = $_POST['product_brand'];

    $sql = "UPDATE products SET 
                product_name = :product_name,
                product_category = :product_category,
                product_size = :product_size,
                product_price = :product_price,
                product_detail = :product_detail,
                product_brand = :product_brand
            WHERE product_id = :product_id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':product_name', $product_name, PDO::PARAM_STR);
    $stmt->bindParam(':product_category', $product_category, PDO::PARAM_STR);
    $stmt->bindParam(':product_size', $product_size, PDO::PARAM_STR);
    $stmt->bindParam(':product_price', $product_price, PDO::PARAM_INT);
    $stmt->bindParam(':product_detail', $product_detail, PDO::PARAM_STR);
    $stmt->bindParam(':product_brand', $product_brand, PDO::PARAM_STR);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: admin-products.php");
        exit();
    } else {
        echo "An error occurred during the update.";
    }
}
?>