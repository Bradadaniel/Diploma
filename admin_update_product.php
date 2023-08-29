<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h1>Update Product</h1>
    <?php
    include 'php/config.php';
    include 'php/db_config.php';

    $pdo = connectDatabase($dsn, $pdoOptions);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Az update_product_handler.php-t ide másold be

    } else {
        $product_id = $_GET['product_id'];
        $sql = "SELECT * FROM products WHERE product_id = :product_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            $product_name = $product['product_name'];
            $product_category = $product['product_category'];
            $product_size = $product['product_size'];
            $product_detail = $product['product_detail'];
            $product_brand = $product['product_brand'];
            $product_price = $product['product_price'];
        } else {
            echo "Product not found.";
            exit();
        }
    }
    ?>

    <form id="updateProductForm" action="update_product_handler.php" method="post">
        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">

        <div class="form-group">
            <label for="product_name">Product Name</label>
            <input type="text" class="form-control" id="product_name" name="product_name" required value="<?php echo $product_name; ?>">
        </div>

        <div class="form-group">
            <label for="product_category">Product Category</label>
            <input type="text" class="form-control" id="product_category" name="product_category" required value="<?php echo $product_category; ?>">
        </div>

        <div class="form-group">
            <label for="product_size">Product Size</label>
            <input type="text" class="form-control" id="product_size" name="product_size" required value="<?php echo $product_size; ?>">
        </div>

        <div class="form-group">
            <label for="product_price">Product Price($)</label>
            <input type="number" class="form-control" id="product_price" name="product_price" required value="<?php echo $product_price; ?>">
        </div>

        <div class="form-group">
            <label for="product_detail">Product Detail</label>
            <textarea class="form-control" id="product_detail" name="product_detail" rows="4" required><?php echo $product_detail; ?></textarea>
        </div>

        <div class="form-group">
            <label for="product_brand">Product Brand</label>
            <input type="text" class="form-control" id="product_brand" name="product_brand" required value="<?php echo $product_brand; ?>">
        </div>

        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>