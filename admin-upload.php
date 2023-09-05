<?php
include 'php/config.php';
include 'php/db_config.php';

$pdo = connectDatabase($dsn, $pdoOptions);

$msg='';
$query = "SELECT category_name FROM category";
$stmt = $pdo->prepare($query);
$stmt->execute();

$options = $stmt->fetchAll(PDO::FETCH_ASSOC);


if (isset($_POST['submit_category'])) {
    $name = $_POST['category_name'];

    $check_category = $pdo->prepare("SELECT * FROM category WHERE category_name = ?");
    $check_category->execute([$name]);
    if ($check_category->rowCount() === 1) {

        $msg = '<div class="alert"><span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>This category name is already used.</div>';

    }else{
        $insert_category = $pdo->prepare("INSERT INTO category (category_name) VALUES (?)");
        $insert_category->execute([$name]);
        $msg = '<div class="alert success"><span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>New category added.</div>';
    }
}

    $query = "SELECT product_id, product_size FROM products";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $sizes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($sizes as &$size) {
        $size['product_size'] = explode(',', $size['product_size']);
    }

    if (isset($_POST['submit_qty'])) {
    $productId = $_POST['product_id'];
    $selectedSize = $_POST['size'];
    $productQuantity = $_POST['product_quantity'];

    $insert_storage = $pdo->prepare("INSERT INTO product_storage (product_id, product_size, product_quantity) VALUES (?,?,?)");
    $insert_storage->execute([$productId, $selectedSize, $productQuantity]);


}


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>DabeShop - Admin</title>
</head>
<body style="background-color: var(--grey)">
<!--Sidebar-->
<div class="sidebar">
    <a href="#" class="logo">
        <img src="img/Dabe-logos_black2.png" alt="">
    </a>
    <ul class="side-menu">
        <li><a href="admin.php"><i class="bx bxs-dashboard"></i>Dashboard</a></li>
        <li><a href="admin-upload.php"><i class="bx bx-store-alt"></i>Shop</a></li>
        <li><a href="admin-products.php"><i class="bx bx-store-alt"></i>Products</a></li>
        <li><a href="admin_order_archive.php"><i class="bx bx-message-square-dots"></i>Archive</a></li>
        <li><a href="admin-users.php"><i class="bx bx-group"></i>Users</a></li>
<!--        <li><a href="#"><i class="bx bx-cog"></i>Settings</a></li>-->
    </ul>
    <ul class="side-menu">
        <li>
            <a href="logout.php" class="logout">
                <i class="bx bx-log-out-circle"></i>
                Logout
            </a>
        </li>
    </ul>
</div>
<!--Sidebar-->

<div class="content">
    <!-- Navbar -->
    <nav>
        <i class='bx bx-menu'></i>
        <form action="#">
            <div class="form-input">

            </div>
        </form>
        <input type="checkbox" id="theme-toggle" <?php echo isset($_COOKIE['dark_mode']) ? 'checked' : ''; ?> hidden>
        <label for="theme-toggle" class="theme-toggle"></label>
        <a href="#" class="notif">
            <i class='bx bx-bell'></i>
            <span class="count">12</span>
        </a>
    </nav>
    <!--    End of Navbar -->
    <main class="main-upload">
        <div class="alert-div" style="display: flex;align-items: center;justify-content: center">
            <?php echo $msg; ?>
        </div>

        <div class="add-products" style="margin: 55px">
            <form action="" method="post" enctype="multipart/form-data">
                <h2>Add category</h2>
                <div class="flex">
                    <div class="inputBox">
                <label for="category_name">Category Name:</label><br>
                <input type="text" name="category_name" id="category_name">
                    </div>
                <button name="submit_category" id="submit_category" class="button-6" type="submit">Add Category</button>
                </div>
            </form>
        </div>


        <div class="add-products" style="margin: 55px">
            <form action="" method="post" enctype="multipart/form-data">
                <h2>Add Quantity</h2>
                <div class="flex">
                    <div class="inputBox">
                <label for="product_id">Product ID:</label><br>
                <input type="text" name="product_id" id="product_id"><br>
                    </div>
                    <div class="inputBox">
                <label for="size">Choose a size:</label><br>
                <select id="size" name="size">
                </select><br><br>
                    </div>
                    <div class="inputBox">
                <label for="product_quantity">Product Quantity:</label><br>
                <input type="text" name="product_quantity" id="product_quantity"><br>
                    </div>
                <button name="submit_qty" id="submit_qty" class="button-6" type="submit">Add Qunatity</button>
                </div>
            </form>
        </div>


        <div class="add-products" style="margin: 55px">
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <h2>Add product</h2>
                <div class="flex">
                    <div class="inputBox">
                <label for="select_category">Select Category:</label><br>
                <select name="select_category" id="select_category">
                    <?php foreach ($options as $option) {
                        echo '<option value="' . $option['category_name'] . '">' . $option['category_name'] . '</option>';
                    } ?>
                </select><br><br>
                    </div>
                    <div class="inputBox">
                <label for="product_name">Product Name:</label><br>
                <input type="text" name="product_name" id="product_name"><br>
                    </div>
                    <div class="inputBox">
                <label for="product_price">Product Price:($)</label><br>
                <input type="number" name="product_price" id="product_price"><br>
                    </div>
                    <div class="inputBox">
                        <label for="product_size">Select Size:</label><br>
                <label>
                    <input type="checkbox" name="fruits[]" value="S"> S
                </label>

                <label>
                    <input type="checkbox" name="fruits[]" value="M"> M
                </label>

                <label>
                    <input type="checkbox" name="fruits[]" value="L"> L
                </label>

                <label>
                    <input type="checkbox" name="fruits[]" value="XL"> XL
                </label>

                <label>
                    <input type="checkbox" name="fruits[]" value="XXL"> XXL
                </label>
                <br>
                    </div>
                    <div class="inputBox">
                <label for="product_detail">Product Details:</label><br>
                <textarea name="product_detail" id="product_detail"></textarea><br>
                    </div>
                    <div class="inputBox">
                <label for="product_brand">Product Brand:</label><br>
                <input type="text" name="product_brand" id="product_brand"><br>
                    </div>
                    <div class="inputBox">
                <label for="product_action">Product Action:(%)</label><br>
                <input type="text" name="product_action" id="product_action"><br>
                    </div>
                    <div class="inputBox">
                <label for="file">Add Image:</label><br>
                <input type="file" name="file[]" multiple><br>
                    </div>
                <button name="submit_product" id="submit_product" class="button-6" type="submit">Add Product</button>
                </div>
            </form>
        </div>





    </main>
</div>



<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>

<script src="js/adminscript.js"></script>
<script>
    $(document).ready(function () {
        $('#product_id').on('input', function () {
            var productId = $(this).val();
            $.ajax({
                url: 'get_sizes.php',
                type: 'POST',
                data: { product_id: productId },
                success: function (response) {
                    $('#size').html(response);
                }
            });
        });
    });




</script>
</body>
</html>
