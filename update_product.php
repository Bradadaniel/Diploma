<?php
include 'php/config.php';
include 'php/db_config.php';

$pdo = connectDatabase($dsn, $pdoOptions);

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $productId = $_GET['id'];



        $sql = "SELECT * FROM products WHERE product_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
        $stmt->execute();

        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        $pdo = null;
} else {
    echo "Invalid Request";
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Update Product</h1>
        <form action="update_process.php" method="post">
            <input type="hidden" name="productId" value="<?php echo $product['product_id']; ?>">
            <label>Category:</label>
            <input type="text" name="category" value="<?php echo $product['product_category']; ?>"><br>
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo $product['product_name']; ?>"><br>
            <label>Size:</label>
            <input type="text" name="size" value="<?php echo $product['product_size']; ?>"><br>
            <label>Detail:</label>
            <input type="text" name="detail" value="<?php echo $product['product_detail']; ?>"><br>
            <label>Brand:</label>
            <input type="text" name="brand" value="<?php echo $product['product_brand']; ?>"><br>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>