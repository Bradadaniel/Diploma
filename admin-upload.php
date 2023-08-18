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
        <li><a href="#"><i class='bx bxs-shopping-bag'></i>Orders</a></li>
        <li><a href="#"><i class="bx bx-message-square-dots"></i>Archive</a></li>
        <li><a href="admin-users.php"><i class="bx bx-group"></i>Users</a></li>
        <li><a href="#"><i class="bx bx-cog"></i>Settings</a></li>
    </ul>
    <ul class="side-menu">
        <li>
            <a href="#" class="logout">
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
</div>
<!--    End of Navbar -->

<main class="main-upload">
<div class="alert-div" style="margin-top: 50px;display: flex;align-items: center;justify-content: center">
    <?php echo $msg; ?>
</div>
<h1>Add category</h1>
<div class="add_category-form" style="margin: 55px">
<form action="" method="post" enctype="multipart/form-data">
    <label for="category_name">Category Name:</label><br>
    <input type="text" name="category_name" id="category_name">
    <button name="submit_category" id="submit_category" class="button-6" type="submit">Add Category</button>
</form>
</div>

<h1>Add product</h1>
<div class="add_product-form">
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label for="select_category">Select Category:</label><br>
        <select name="select_category" id="select_category">
            <?php foreach ($options as $option) {
                echo '<option value="' . $option['category_name'] . '">' . $option['category_name'] . '</option>';
            } ?>
        </select><br><br>
        <label for="product_name">Product Name:</label><br>
        <input type="text" name="product_name" id="product_name"><br>
        <label for="product_price">Product Price:($)</label><br>
        <input type="number" name="product_price" id="product_price"><br>

        <label>
            <input type="checkbox" name="fruits[]" value="S"> S
        </label>
        <br>
        <label>
            <input type="checkbox" name="fruits[]" value="M"> M
        </label>
        <br>
        <label>
            <input type="checkbox" name="fruits[]" value="L"> L
        </label>
        <br>
        <label>
            <input type="checkbox" name="fruits[]" value="XL"> XL
        </label>
        <br>
        <label>
            <input type="checkbox" name="fruits[]" value="XXL"> XXL
        </label>
        <br>
        <label for="product_detail">Product Details:</label><br>
        <textarea name="product_detail" id="product_detail"></textarea><br>
        <label for="product_brand">Product Brand:</label><br>
        <input type="text" name="product_brand" id="product_brand"><br>
        <label for="product_action">Product Action:</label><br>
        <input type="text" name="product_action" id="product_action"><br>
        <label for="file">Add Image:</label><br>
        <input type="file" name="file[]" multiple><br>
        <button name="submit_product" id="submit_product" class="button-6" type="submit">Add Product</button>
    </form>
</div>
</main>

<script src="js/adminscript.js"></script>
</body>
</html>
