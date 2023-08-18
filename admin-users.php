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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
<div class="users-table">
<table id="example" class="display" style="width:100%">
    <thead>
    <tr>
        <th>Username</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Status</th>
        <th>Operations</th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>
</div>

<!--<div class="modal" style="display: flex;margin: 0 auto;align-items: center;justify-content: center">-->
    <!-- Modal for Edit -->
    <div class="modal fade" id="edit-modal" tabindex="-1" aria-labelledby="edit-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit-modal-label">Adatok szerkesztése</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edit-form" method="post" action="update_data.php">
                    <div class="modal-body">
                        <input type="hidden" id="edit-user-id" name="edit_user_id">
                        <div class="form-group">
                            <label for="edit-username">Felhasználónév</label>
                            <input type="text" class="form-control" id="edit-username" name="edit_username">
                        </div>
                        <div class="form-group">
                            <label for="edit-email">E-mail</label>
                            <input type="email" class="form-control" id="edit-email" name="edit_email">
                        </div>
                        <div class="form-group">
                            <label for="edit-phone">Telefonszám</label>
                            <input type="tel" class="form-control" id="edit-phone" name="edit_phone">
                        </div>
                        <div class="form-group">
                            <label for="edit-status">Státusz</label>
                            <input type="text" class="form-control" id="edit-status" name="edit_status">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Bezárás</button>
                        <button type="submit" class="btn btn-primary">Mentés</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<!-- jQuery és DataTables JavaScript fájlok -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- DataTables inicializálása és AJAX hívások -->

<script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
            "ajax": {
                "url": "get_data.php",
                "dataSrc": ""
            },
            "columns": [
                { "data": "username" },
                { "data": "email" },
                { "data": "phone" },
                { "data": "status" },
                { "data": "user_id", "render": function(data, type, row, meta) {
                        return '<button class="edit-button" data-id="' + data + '">Update</button>' +
                            '<button class="delete-button" data-id="' + data + '">Delete</button>';
                    }}
            ]
        });

        // Szerkesztés gomb kattintás
        $('#example tbody').on('click', '.edit-button', function() {
            var data = table.row($(this).parents('tr')).data();
            var user_id = data.user_id;
            var username = data.username;
            var email = data.email;
            var phone = data.phone;
            var status = data.status;

            // Az adatokat beállítjuk a szerkesztési űrlapon
            $('#edit-form #edit-user-id').val(user_id);
            $('#edit-form #edit-username').val(username);
            $('#edit-form #edit-email').val(email);
            $('#edit-form #edit-phone').val(phone);
            $('#edit-form #edit-status').val(status);

            $('#edit-modal').modal('show');
        });

        // Törlés gomb kattintás
        $('#example tbody').on('click', '.delete-button', function() {
            var data = table.row($(this).parents('tr')).data();
            var user_id = data.user_id;

            if (confirm('Biztosan törölni szeretnéd ezt a sort?')) {
                $.ajax({
                    url: 'delete_data.php',
                    type: 'POST',
                    data: { user_id: user_id },
                    success: function(response) {
                        alert('Sikeres törlés!');
                        table.ajax.reload();
                    },
                    error: function(xhr, status, error) {
                        alert('Hiba történt a törlés során: ' + error);
                    }
                });
            }
        });
    });
</script>



<script src="js/adminscript.js"></script>
</body>
</html>
