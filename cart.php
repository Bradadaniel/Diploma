<?php session_start()?>
<head>
    <link rel="shortcut icon" type="x-icon" href="img/Dabe-logos_black2.png">
    <title>DabeShop - Cart</title>
    <link rel="stylesheet" href="css/style.css" />

</head>
<body>
<?php include 'header.php'?>

<?php
$msg='';
if (isset($_GET['order_error']) && $_GET['order_error'] == 1) {
    $error_message = urldecode($_GET['message']);
    echo '<div class="alert"><span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>Order error: ' . $error_message . '</div>';
}

echo $msg;?>


<div class="small-container cart-page">
    <?php

    if (empty($id)) {
        echo '<p>Log in first to view the contents of the shopping cart.</p>';
    } else {
        ?>
        <table>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Size</th>
                <th>Subtotal</th>
            </tr>
            <?php
            $subtotal = 0;
            $cart_sql = "SELECT product_id, product_size, product_quantity FROM cart WHERE user_id = :user_id";
            $cart_stmt = $pdo->prepare($cart_sql);
            $cart_stmt->bindParam(':user_id', $id);
            $cart_stmt->execute();
            $cart_count = $cart_stmt->rowCount();

            if ($cart_count === 0) {
                echo '<p style="min-width: 1000px">Your shopping cart is empty.</p>';
            } else {

                while ($cart_row = $cart_stmt->fetch(PDO::FETCH_ASSOC)) {
                    $product_id = $cart_row['product_id'];
                    $product_size = $cart_row['product_size'];
                    $product_quantity = $cart_row['product_quantity'];

                    $product_sql = "SELECT product_name, product_price, product_img 
                            FROM products
                            WHERE product_id = :product_id";
                    $product_stmt = $pdo->prepare($product_sql);
                    $product_stmt->bindParam(':product_id', $product_id);
                    $product_stmt->execute();
                    $product_row = $product_stmt->fetch(PDO::FETCH_ASSOC);

                    $product_name = $product_row['product_name'];
                    $product_price = $product_row['product_price'];
                    $product_images = explode(',', $product_row['product_img']); // Képek tömbbe szétválasztása
                    $product_image = $product_images[0]; // Az első kép

                    $subtotal += $product_price * $product_quantity; // Összegzés


                    echo '<tr>
                    <td>
                        <div class="cart-info">
                            <img src="uploaded_images/' . $product_image . '">
                            <div>
                                <p>' . $product_name . '</p>
                                <small>Price: ' . $product_price . '$</small>
                                <br>
                                <a href="remove_product.php?remove=' . $product_id . '">Remove</a>
                            </div>
                        </div>
                    </td>
                    <td><input type="number" value="' . $product_quantity . '" readonly></td>
                    <td>' . $product_size . '</td>
                    <td>' . ($product_price * $product_quantity) . '$</td>
                  </tr>';
                }
            }
            ?>
        </table>
        <div class="total-price" style="margin-top: 5px">
            <table>
                <tr>
                    <td>Subtotal</td>
                    <td><?php echo $subtotal; ?>$</td>
                </tr>
                <tr>
                    <td>Tax</td>
                    <td><?php echo ($subtotal >= 50) ? 0 : 5; ?>$</td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td><?php echo $subtotal + (($subtotal >= 50) ? 0 : 5); ?>$</td>
                </tr>
            </table>
        </div>
    <?php
    }?>
</div>

<div class="flex-btn" style="display: flex;margin: 0 auto;justify-content: center;
align-items: center; padding: 10px 0">
<div class="continueshopping button">
     <a href="page-category.php" class="primary-btn" style="text-decoration: none;">Continue shopping</a></div>
<div class="buynow button">
    <button type="submit" name="buy_now" class="secondary-btn" id="buyNowBtn" disabled>Buy now</button>
</div>
</div>

<div class="container">
    <h1>Checkout</h1>
    <form action="process_checkout.php" method="post">
        <label for="name">Full Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="zip">Zip code:</label>
        <input type="text" id="zip" name="zip" required>

        <label for="street">Street (Number):</label>
        <input type="text" id="street" name="street" required>

        <label for="phone">Phone:</label>
        <input type="number" id="phone" name="phone" required>

        <label for="payment">Payment Method:</label>
        <select id="payment" name="payment" required>
            <option value="credit_card">Credit Card</option>
            <option value="paypal">PayPal</option>
            <option value="payment_on_delivery">Payment on delivery</option>
        </select>

        <button type="submit" class="secondary-btn" style="align-items: center;justify-content: center;margin: 10px auto" name="submit_order" id="submit_order">Place Order</button>
    </form>
</div>



<?php include 'footer.php'?>

</body>