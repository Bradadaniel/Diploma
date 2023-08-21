<?php
session_start();

include 'php/config.php';
include 'php/db_config.php';

$pdo = connectDatabase($dsn, $pdoOptions);

if (isset($_SESSION['ID'])) {
    $user_id = $_SESSION['ID'];
} else {
    $user_id = 0;
}

if (isset($_POST['submit_order'])) {
    $name = $_POST['name'];
    $zip = $_POST['zip'];
    $street = $_POST['street'];
    $phone = $_POST['phone'];
    $payment_method = $_POST['payment'];
    $address = $zip . ', ' . $street;

    $order_items = array();
    $subtotal = 0;

    $cart_sql = "SELECT product_id, product_size, product_quantity FROM cart WHERE user_id = :user_id";
    $cart_stmt = $pdo->prepare($cart_sql);
    $cart_stmt->bindParam(':user_id', $user_id);
    $cart_stmt->execute();

    while ($cart_row = $cart_stmt->fetch(PDO::FETCH_ASSOC)) {
        $product_id = $cart_row['product_id'];
        $product_size = $cart_row['product_size'];
        $product_quantity = $cart_row['product_quantity'];

        $product_sql = "SELECT product_price FROM products WHERE product_id = :product_id";
        $product_stmt = $pdo->prepare($product_sql);
        $product_stmt->bindParam(':product_id', $product_id);
        $product_stmt->execute();
        $product_row = $product_stmt->fetch(PDO::FETCH_ASSOC);
        $product_price = $product_row['product_price'];

        $order_items[] = "$product_id:$product_size:$product_quantity";
        $subtotal += $product_price * $product_quantity;
    }

    $order_items_str = implode(',', $order_items);
    $total_price = $subtotal + ($subtotal >= 50 ? 0 : 5);

    $order_successful = true;
    $error_message = "";

    foreach ($order_items as $order_item) {
        list($product_id, $product_size, $product_quantity) = explode(':', $order_item);

        $storage_sql = "SELECT product_quantity FROM product_storage WHERE product_id = :product_id AND product_size = :product_size";
        $storage_stmt = $pdo->prepare($storage_sql);
        $storage_stmt->bindParam(':product_id', $product_id);
        $storage_stmt->bindParam(':product_size', $product_size);
        $storage_stmt->execute();
        $storage_row = $storage_stmt->fetch(PDO::FETCH_ASSOC);

        $remaining_quantity = $storage_row['product_quantity'] - $product_quantity;

        if ($remaining_quantity < 0) {
            $order_successful = false;
            $error_message = "Not enough stock for one or more products in your cart.";
            break;
        }

        $update_storage_sql = "UPDATE product_storage SET product_quantity = :remaining_quantity 
                               WHERE product_id = :product_id AND product_size = :product_size";
        $update_storage_stmt = $pdo->prepare($update_storage_sql);
        $update_storage_stmt->bindParam(':remaining_quantity', $remaining_quantity);
        $update_storage_stmt->bindParam(':product_id', $product_id);
        $update_storage_stmt->bindParam(':product_size', $product_size);
        $update_storage_stmt->execute();
    }

    $status = 'pending';

    if ($order_successful) {
        $insert_order_sql = "INSERT INTO orders (user_id, product_data, phone, name, total_price, payment_method, address, status) 
                            VALUES (:user_id, :product_data, :phone, :name, :total_price, :payment_method, :address, :status)";
        $insert_order_stmt = $pdo->prepare($insert_order_sql);
        $insert_order_stmt->bindParam(':user_id', $user_id);
        $insert_order_stmt->bindParam(':product_data', $order_items_str);
        $insert_order_stmt->bindParam(':phone', $phone);
        $insert_order_stmt->bindParam(':name', $name);
        $insert_order_stmt->bindParam(':total_price', $total_price);
        $insert_order_stmt->bindParam(':payment_method', $payment_method);
        $insert_order_stmt->bindParam(':address', $address);
        $insert_order_stmt->bindParam(':status', $status);
        $insert_order_stmt->execute();

        $delete_cart_sql = "DELETE FROM cart WHERE user_id = :user_id";
        $delete_cart_stmt = $pdo->prepare($delete_cart_sql);
        $delete_cart_stmt->bindParam(':user_id', $user_id);
        $delete_cart_stmt->execute();

        header("Location: index.php?order_success=1");
    } else {
        header("Location: cart.php?order_error=1&message=" . urlencode($error_message));
    }
}
?>