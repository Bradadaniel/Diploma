<?php session_start()?>
<head>
    <link rel="shortcut icon" type="x-icon" href="img/Dabe-logos_black2.png">
    <title>DabeShop - Wishlist</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
<?php include 'header.php'?>
<?php
if (isset($_GET['remove'])) {
    $removeProductId = $_GET['remove'];


    $remove_sql = "DELETE FROM wishlist WHERE user_id = :user_id AND product_id = :product_id";
    $remove_stmt = $pdo->prepare($remove_sql);
    $remove_stmt->bindParam(':user_id', $id);
    $remove_stmt->bindParam(':product_id', $removeProductId);
    $remove_stmt->execute();
    header("Location: wishlist.php");
}


if (!empty($id)) {
    $wishlist_sql = "SELECT * FROM wishlist WHERE user_id = :user_id";
    $wishlist_stmt = $pdo->prepare($wishlist_sql);
    $wishlist_stmt->bindParam(':user_id', $id);
    $wishlist_stmt->execute();
    $wishlist_result = $wishlist_stmt->fetchAll(PDO::FETCH_ASSOC);

    $product_ids = array();
    foreach ($wishlist_result as $wishlist_row) {
        $product_ids[] = $wishlist_row['product_id'];
    }

    if (!empty($product_ids)) {
        $product_sql = "SELECT * FROM products WHERE product_id IN (" . implode(',', $product_ids) . ")";
        $product_stmt = $pdo->prepare($product_sql);
        $product_stmt->execute();
        $product_result = $product_stmt->fetchAll(PDO::FETCH_ASSOC);

        ?>
        <div class="bycats">
            <div class="container">
                <div class="wrap">
                    <div class="heading" id="Wishlist">
                        <h2 class="title">Wishlist</h2>
                    </div>
                    <div class="tabbed">
                        <div id="wishlist" class="sort-data active">
                            <div class="dotgrid">
                                <div class="wrapper">
                                    <?php
                                    if ($product_result) {
                                        foreach ($product_result as $row) {
                                            $product_name = $row["product_name"];
                                            $product_price = $row["product_price"];
                                            $product_size = $row["product_size"];
                                            $product_images = explode(",", $row["product_img"]);
                                            $product_action = $row["product_action"];
                                            $discounted_price = $product_price - ($product_price * ($product_action / 100));
                                            ?>
                                            <div class="item">
                                                <div class="dot-image">
                                                    <a href="" class="product-permalink"></a>
                                                    <div class="thumbnail">
                                                        <img src="uploaded_images/<?php echo $product_images[0]; ?>" alt="">
                                                    </div>
                                                    <div class="thumbnail hover">
                                                        <img src="uploaded_images/<?php echo $product_images[1]; ?>" alt="">
                                                    </div>
                                                    <div class="actions">
                                                        <ul>
                                                            <li><a href="remove_wishlist.php?remove=<?php echo $row['product_id']; ?>"><i class="ri-delete-bin-line"></i></a></li>
                                                            <li><a href="page-single.php?product_id=<?php echo $row['product_id']; ?>"><i class="ri-eye-line"></i></a></li>
                                                        </ul>
                                                    </div>
                                                    <?php
                                                    if ($product_action) {
                                                        echo '<div class="label action"><span>-' . $product_action . '%</span></div>';
                                                    }
                                                    ?>
                                                </div>
                                                <div class="dot-info">
                                                    <h2 class="dot-title"><a href=""><?php echo $product_name; ?></a></h2>
                                                    <div class="product-price">
                                                        <?php
                                                        if ($product_action) {
                                                            echo '<span class="before">' . $product_price . '$ </span>';
                                                            echo '<span class="current">' . $discounted_price . '$</span>';
                                                        } else {
                                                            echo '<span class="current">' . $product_price . '$</span>';
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    } else {
                                        echo "No products in your wishlist.";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } else {
        echo "No products in your wishlist.";
    }
} else {
    echo "Login to view your wishlist.";
}
?>
<?php include 'footer.php'?>
</body>