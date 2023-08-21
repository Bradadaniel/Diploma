<?php
include 'php/config.php';
include 'php/db_config.php';

$pdo = connectDatabase($dsn, $pdoOptions);


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
        <li><a href="admin_orders.php"><i class='bx bxs-shopping-bag'></i>Orders</a></li>
        <li><a href="admin_order_archive.php"><i class="bx bx-message-square-dots"></i>Archive</a></li>
        <li><a href="admin-users.php"><i class="bx bx-group"></i>Users</a></li>
        <li><a href="#"><i class="bx bx-cog"></i>Settings</a></li>
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
</div>
<!--    End of Navbar -->

<main>
    <div class="container mt-5">
        <h1>Orders</h1>
        <div class="orders-table">
            <div class="table-container">
                <table id="orderTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>User ID</th>
                        <th>Product Data</th>
                        <th>Phone</th>
                        <th>Name</th>
                        <th>Total Price</th>
                        <th>Payment Method</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>

<script src="js/adminscript.js"></script>
<script>

    $(document).ready(function() {
        var orderTable = $('#orderTable').DataTable({
            "ajax": {
                "url": "get_orders.php",
                "dataSrc": ""
            },
            "columns": [
                { "data": "id" },
                { "data": "user_id" },
                { "data": "product_data" },
                { "data": "phone" },
                { "data": "name" },
                { "data": "total_price" },
                { "data": "payment_method" },
                { "data": "address" },
                {
                    "data": "status",
                    "render": function(data, type, row) {
                        var statusClass = '';
                        if (data === "pending") {
                            statusClass = 'status-pending';
                        } else if (data === "accepted") {
                            statusClass = 'status-accepted';
                        } else if (data === "declined") {
                            statusClass = 'status-declined';
                        }
                        return '<span class="' + statusClass + '">' + data + '</span>';
                    }
                },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        if (data.status === "pending") {
                            return '<button class="btn btn-success btn-sm accept-btn" data-order-id="' + data.id + '">Accept</button>' +
                                '<button class="btn btn-danger btn-sm decline-btn" data-order-id="' + data.id + '">Decline</button>';
                        } else {
                            return 'Accepted';
                        }
                    }
                }
            ]
        });








        // Delete gombra kattintva törlési művelet AJAX hívással
        $('#orderTable tbody').on('click', '.accept-btn', function() {
            var orderId = $(this).data('order-id');
            if (confirm("Are you sure you want to accept this order?")) {
                $.ajax({
                    url: 'accept_order.php',
                    type: 'POST',
                    data: { order_id: orderId },
                    success: function(data) {
                        if (data === "Success") {
                            orderTable.ajax.reload(null, false);
                        } else {
                            alert("Error");
                        }
                    },
                    error: function() {
                        alert("Error");
                    }
                });
            }
        });

        $('#orderTable tbody').on('click', '.decline-btn', function() {
            var orderId = $(this).data('order-id');
            if (confirm("Are you sure you want to decline this order?")) {
                $.ajax({
                    url: 'decline_order.php',
                    type: 'POST',
                    data: { order_id: orderId },
                    success: function(data) {
                        if (data === "Success") {
                            orderTable.ajax.reload(null, false);
                        } else {
                            alert("Error");
                        }
                    },
                    error: function() {
                        alert("Error");
                    }
                });
            }
        });
    });
</script>
</body>
</html>
