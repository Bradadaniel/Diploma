<?php

include 'php/config.php';
include 'php/db_config.php';

$pdo = connectDatabase($dsn, $pdoOptions);


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_product"])) {
    $product_category = $_POST['select_category'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_size = implode(', ', $_POST["fruits"]);
    $product_detail = $_POST['product_detail'];
    $product_brand = $_POST['product_brand'];
    $product_action = $_POST['product_action'];

    $fileCount = count($_FILES['file']['name']);
    $imagePaths = array();
    $a = mt_rand();
    for ($i = 0; $i < $fileCount; $i++) {
        $fileName = $_FILES['file']['name'][$i];
        $tempFilePath = $_FILES['file']['tmp_name'][$i];
        $fileSize = $_FILES['file']['size'][$i];

        $uploadDir = "uploaded_images/";
        $targetFilePath = $uploadDir . $fileName;

        if (move_uploaded_file($tempFilePath, $targetFilePath)) {
            $imagePaths[] = $fileName;
        } else {
            echo "Error uploading the image.";
        }
    }
    $csvPaths = implode(",", $imagePaths);

    $stmt = $pdo->prepare("INSERT INTO products (product_category, product_name, product_price, product_size, product_detail, product_img, product_brand,product_action) VALUES (?,?,?,?,?,?,?,?)");
    $stmt->execute([$product_category, $product_name, $product_price, $product_size, $product_detail, $csvPaths, $product_brand, $product_action]);

    echo "Product added successfully!";
} else {
    echo "No product submitted.";
}

    header("Location:admin-upload.php");

