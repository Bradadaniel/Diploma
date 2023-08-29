<?php
session_start();

include 'php/config.php';
include 'php/db_config.php';
$pdo = connectDatabase($dsn, $pdoOptions);

if (isset($_SESSION['SESSION_EMAIL'])) {
    $email = $_SESSION['SESSION_EMAIL'];
}
else{
    $email = '';
}

if (isset($_SESSION['ID'])) {
    $id =$_SESSION['ID'];
}
else{
    $id = '';
}

$totalVisitorsStmt = $pdo->query('SELECT SUM(visit_count) AS total_visitors FROM visitors');
$totalVisitors = $totalVisitorsStmt->fetch(PDO::FETCH_ASSOC)['total_visitors'];

$query = "SELECT total_price FROM orders WHERE status = 'accepted'";
$stmt = $pdo->query($query);
$totalPrices = $stmt->fetchAll(PDO::FETCH_COLUMN);

$sumTotalPrice = array_sum($totalPrices);

$query = "SELECT COUNT(*) AS num_accepted_orders FROM orders WHERE status = 'accepted'";
$stmt = $pdo->query($query);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$numAcceptedOrders = $result['num_accepted_orders'];
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-EY3N6WTSLC"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-EY3N6WTSLC');
    </script>

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
<body style="background-color: var(--grey);color: var(--dark)">
<!--Sidebar-->
<div class="sidebar">
    <a href="#" class="logo">
        <img src="img/Dabe-logos_black2.png" alt="">
    </a>
    <ul class="side-menu">
        <li><a href="admin.php"><i class="bx bxs-dashboard"></i>Dashboard</a></li>
        <li><a href="admin-upload.php"><i class="bx bx-store-alt"></i>Shop</a></li>
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


<!-- Main Content -->
<div class="content">
    <!-- Navbar -->
    <nav>
        <i class='bx bx-menu'></i>
        <form action="#">
            <div class="form-input">

            </div>
        </form>
        <input type="checkbox" id="theme-toggle" hidden>
        <label for="theme-toggle" class="theme-toggle"></label>
<!--        <a href="#" class="notif">-->
<!--            <i class='bx bx-bell'></i>-->
<!--            <span class="count">12</span>-->
<!--        </a>-->
    </nav>

    <!-- End of Navbar -->

    <main>
        <div class="header">
            <div class="left">
                <h1>Dashboard</h1>
            </div>

        </div>

        <!-- Insights -->
        <ul class="insights">
            <li>
                <i class='bx bx-calendar-check'></i>
                <span class="info">
                        <h3>
                           <?php echo $numAcceptedOrders; ?>
                        </h3>
                        <p>Paid Order</p>
                    </span>
            </li>
            <li><i class='bx bx-show-alt'></i>
                <span class="info">
                        <h3>
                            <?php echo $totalVisitors; ?>
                        </h3>
                        <p>Site Visit</p>
                    </span>
            </li>
            <li><i class='bx bx-line-chart'></i>
                <span class="info">
                        <h3>
                            24
                        </h3>
                        <p>Searches</p>
                    </span>
            </li>
            <li><i class='bx bx-dollar-circle'></i>
                <span class="info">
                        <h3>
                            <?php echo $sumTotalPrice; ?>$
                        </h3>
                        <p>Total Sales</p>
                    </span>
            </li>
        </ul>

        <div class="left">
            <h1>Orders</h1>
        </div>
        <div class="white-bg" style="background: white;border-radius: 2rem;padding: 1rem 0">
            <div class="container mt-5">
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
