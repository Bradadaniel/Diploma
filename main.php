<?php

$sql = "SELECT * FROM products ORDER BY product_id DESC LIMIT 16";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$msg='';

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Ellenőrizd, hogy a rekord már létezik-e a wishlist táblában
    $check_sql = "SELECT * FROM wishlist WHERE user_id = :user_id AND product_id = :product_id";
    $check_stmt = $pdo->prepare($check_sql);
    $check_stmt->bindParam(':user_id', $id);
    $check_stmt->bindParam(':product_id', $product_id);
    $check_stmt->execute();

    if ($check_stmt->rowCount() == 0) {
        // Hozzáadás a wishlist táblához
        $add_sql = "INSERT INTO wishlist (user_id, product_id) VALUES (:user_id, :product_id)";
        $add_stmt = $pdo->prepare($add_sql);
        $add_stmt->bindParam(':user_id', $id);
        $add_stmt->bindParam(':product_id', $product_id);
        $add_stmt->execute();

        $msg = '<div class="alert success"><span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>Product has been added to your wishlist.</div>';
    } else {
        $msg = '<div class="alert"><span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>Product is already in your wishlist!</div>';
    }
}

if (isset($_GET['order_success']) && $_GET['order_success'] == 1) {
    $msg = '<div class="alert success"><span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>Your order was successful! Thank you for shopping with us.</div>';
}

?>
<main>
    <?php echo $msg;?>
    <div class="slider">
        <div class="sliderbox swiper">
            <div class="wrap swiper-wrapper">
                <div class="item swiper-slide">
                    <div class="image">
                        <div class="ob-cover">
                            <img src="prod-img/slider3.jpg" alt="">
                        </div>
                        <div class="title-info">
                            <div class="container wide">
                                <div class="wrap">
                                    <span class="price">399RSD</span>
                                    <h3 class="title">Find your best deal</h3>
                                    <div class="button"><a href="" class="primary-btn">Shop Now</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item swiper-slide">
                    <div class="image">
                        <div class="ob-cover">
                            <img src="prod-img/slider2.jpg" alt="">
                        </div>
                        <div class="title-info">
                            <div class="container wide">
                                <div class="wrap">
                                    <span class="price">599RSD</span>
                                    <h3 class="title">The best shop with best price</h3>
                                    <div class="button"><a href="" class="primary-btn">Shop Now</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="item swiper-slide">
                    <div class="image">
                        <div class="ob-cover">
                            <img src="prod-img/slider1.jpg" alt="">
                        </div>
                        <div class="title-info">
                            <div class="container wide">
                                <div class="wrap">
                                    <span class="price">599RSD</span>
                                    <h3 class="title">Woman's Fashion</h3>
                                    <div class="button"><a href="" class="primary-btn">Shop Now</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="custom-pagination">
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>


    <div class="guide">
        <div class="container">
            <div class="wrap">
                <div class="heading">
                    <h2 class="title">Products Guide</h2>
                </div>
                <div class="dotgrid scrollto">
                    <div class="wrapper">
                        <div class="item">
                            <div class="dot-image">
                                <div class="thumbnail hover">
                                    <img src="prod-img/1.jpg" alt="">
                                </div>
                            </div>
                            <div class="dot-info">
                                <h3 class="dot-title">Shirts</h3>
                                <p class="grey-color">Top quality shirts in a wide selection.Meticulously crafted from premium materials, our shirts are designed to accompany you through the years.</p>
                            </div>
                        </div>

                        <div class="item">
                            <div class="dot-image">
                                <div class="thumbnail hover">
                                    <img src="prod-img/Jeans.jpg" alt="">
                                </div>
                            </div>
                            <div class="dot-info">
                                <h3 class="dot-title">Jeans</h3>
                                <p class="grey-color">You've got Questions. We've Got Jeans.Discover the perfect balance of style and comfort with our latest denim collection! Choose quality and durability in a single garment.</p>
                            </div>
                        </div>

                        <div class="item">
                            <div class="dot-image">
                                <div class="thumbnail hover">
                                    <img src="prod-img/3.jpg" alt="">
                                </div>
                            </div>
                            <div class="dot-info">
                                <h3 class="dot-title">Jackets</h3>
                                <p class="grey-color">Whether it's for everyday wear or special outings, our coats not only exude elegance but also ensure unmatched coziness. </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="bycats">
        <div class="container">
            <div class="wrap">
                                <div class="heading" id="News">
                                    <h2 class="title">New Arrivals</h2>
                                </div>

                <div class="tabbed">
                    <div id="sweater" class="sort-data active">
                        <div class="dotgrid">
                            <div class="wrapper">
                                <?php
                                if ($result) {
                                foreach ($result as $row) {
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
                                                <?php
                                                if (!empty($id)){
                                                ?>
                                                <li><a href="?product_id=<?php echo $row['product_id']; ?>"><i class="ri-heart-line"></i></a></li>
                                                <?php
                                                }
                                                ?>
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
                                    echo "Not found.";
                                }
                                ?>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

<!--    <div class="banner" style="padding: 100px 0">-->
<!--        <div class="container">-->
<!--            <div class="wrap">-->
<!--                <div class="content">-->
<!--                    <span>Promo</span>-->
<!--                    <h3 class="title">Get ready!<br>Winter is comeing..</h3>-->
<!--                    <div class="button"><a href="" class="primary-btn">Go get in</a></div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->

    <div class="guide">
        <div class="container">
            <div class="wrap"></div>
        </div>
    </div>

</main>
