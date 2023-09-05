
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
<main>
    <div class="white-bg" style="background: white;border-radius: 2rem;padding: 1rem 0">
        <div class="container mt-5">
            <h1>Products</h1>
            <div class="add_product-form">
                <div class="table-container">
                    <table id="productTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Category</th>
                            <th>Name</th>
                            <th>Size</th>
                            <th>Detail</th>
                            <th>Brand</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </main>
</div>



<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>

<script src="js/adminscript.js"></script>
<script>


    $(document).ready(function() {
        var dataTable = $('#productTable').DataTable({
            "ajax": {
                "url": "get_products.php",
                "dataSrc": ""
            },
            "columns": [
                { "data": "product_id" },
                { "data": "product_category" },
                { "data": "product_name" },
                { "data": "product_size" },
                { "data": "product_detail" },
                { "data": "product_brand" },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        return '<button class="btn btn-primary btn-sm update-btn" data-product-id="' + data.product_id + '">Update</button>' +
                            '<button class="btn btn-danger btn-sm delete-btn" data-product-id="' + data.product_id + '">Delete</button>';
                    }
                }
            ]
        });

        $(document).ready(function () {
            $('#productTable').on('click', '.update-btn', function () {
                var productId = $(this).data('product-id');
                window.location.href = 'admin_update_product.php?product_id=' + productId;
            });
        });

        // Automatikus frissítés beállítása
        setInterval(function() {
            dataTable.ajax.reload(null, false);
        }, 5000); // 5 másodperces frissítési időköz (állítsd át igény szerint)

        // Delete gombra kattintva törlési művelet AJAX hívással
        $('#productTable tbody').on('click', '.delete-btn', function() {
            var productId = $(this).data('product-id');
            if (confirm("Biztosan törölni szeretnéd ezt a terméket?")) {
                $.ajax({
                    url: 'delete_product.php',
                    type: 'POST',
                    data: { product_id: productId },
                    success: function(data) {
                        if (data === "Success") {
                            // Nem szükséges az automatikus frissítés itt
                        } else {
                            alert("Sikeres.");
                        }
                    },
                    error: function() {
                        alert("Sikeres.");
                    }
                });
            }
        });
    });


</script>
</body>
</html>
