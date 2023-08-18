<?php session_start();?>
<head xmlns="http://www.w3.org/1999/html">
    <link rel="shortcut icon" type="x-icon" href="img/Dabe-logos_black2.png">
    <title>DabeShop - Product</title>
    <link rel="stylesheet" href="css/style.css" />
<body>
<div id="page" class="page-single">

<?php include "header.php";?>
    <?php

    if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];


        $sql = "SELECT * FROM products WHERE product_id = $product_id";
        $result = $pdo->query($sql);

        if ($result->rowCount() > 0) {
            $row = $result->fetch(PDO::FETCH_ASSOC);

            // Adatok kinyerése az adatbázisból
            $product_name = $row["product_name"];
            $product_price = $row["product_price"];
            $product_action = $row["product_action"];
            $product_images = explode(",", $row["product_img"]);
            $product_size = $row["product_size"];

            $product_brand = $row["product_brand"];
            $product_category = $row["product_category"];
        }
    }


    ?>

<div class="overlay" data-overlay></div>

<div class="space" style="margin: 100px"></div>

<main>
    <div class="section">
        <div class="container">
            <div class="wrap">
                <div class="product dotgrid">
                    <div class="wrapper">
                        <div class="image">
                            <div class="outer-main">
                                <div class="main-image swiper">
                                    <div class="wrap swiper-wrapper">
                                        <div class="item swiper-slide"><img src="prod-img/hoodie3.jpg" alt=""></div>
                                        <div class="item swiper-slide"><img src="prod-img/hoodie33.jpg" alt=""></div>
                                        <div class="item swiper-slide"><img src="prod-img/hoodie22.jpg" alt=""></div>
                                        <div class="item swiper-slide"><img src="prod-img/hoodie2.jpg" alt=""></div>
                                    </div>
                                </div>
                                <div class="custom-pagination">
                                    <div class="swiper-pagination">

                                    </div>
                                </div>
                            </div>
                            <div class="outer-thumb ob-cover">
                                <div class="thumbnail-image swiper">
                                    <div class="wrap swiper-wrapper">
                                        <div class="item swiper-slide">
                                            <div class="thumb-wrap"><img src="prod-img/hoodie3.jpg" alt=""></div>
                                        </div>
                                        <div class="item swiper-slide">
                                            <div class="thumb-wrap"><img src="prod-img/hoodie33.jpg" alt=""></div>
                                        </div>
                                        <div class="item swiper-slide">
                                            <div class="thumb-wrap"><img src="prod-img/hoodie22.jpg" alt=""></div>
                                        </div>
                                        <div class="item swiper-slide">
                                            <div class="thumb-wrap"><img src="prod-img/hoodie2.jpg" alt=""></div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="summary">
                            <div class="entry">
                                <h1 class="title">The Sweather in..</h1>
                                <div class="product-group">
                                    <div class="product-price">
                                        <?php if ($product_action) {  ?>
                                            <?php
                                            $discount_percentage = intval($product_action); // Akció mérete százalékban
                                            $discount_amount = intval($product_price) * ($discount_percentage / 100); // Akciós összeg
                                            $sale_price = intval($product_price) - $discount_amount; // Akciós ár
                                            ?>
                                            <span class="current"><?php echo $sale_price; ?>$</span>
                                            <div class="wrap">
                                                <span class="before"><?php echo $product_price; ?>$</span>
                                                <span class="discount">-<?php echo $discount_percentage; ?>%</span>
                                            </div>
                                        <?php } else { ?>
                                            <span class="current"><?php echo $product_price; ?>$</span>
                                        <?php } ?>
                                    </div>
<!--                                    <div class="product-rating">-->
<!--                                        <span>-->
<!--                                            <i class="ri-star-fill"></i>-->
<!--                                            <span>4.8</span>-->
<!--                                        </span>-->
<!--                                        <a href="">3 Reviews</a>-->
<!--                                    </div>-->
                                </div>
<!--                                <div class="product-color">-->
<!--                                    <span>Colors:</span>-->
<!--                                    <div class="wrap">-->
<!--                                        <button class="tosca selected"></button>-->
<!--                                        <button class="brown"></button>-->
<!--                                        <button class="purple"></button>-->
<!--                                    </div>-->
<!--                                </div>-->

                                <div class="product-size">
                                    <span>Size:</span>
                                    <div class="wrap">
                                        <?php
                                        $sizes = explode(",", $product_size);
                                        foreach ($sizes as $size) {
                                            echo '<button>' . $size . '</button>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="product-stock">
                                    <div class="wrap">
                                        <strong>201</strong>
                                        <span class="grey-color">in stock</span>
                                        <i class="ri-checkbox-circle-line"></i>
                                    </div>
                                </div>
                                <div class="product-action">
                                    <div class="qty">
                                        <button class="decrease">-</button>
                                        <input type="text" value="1">
                                        <button class="increase">+</button>
                                    </div>
                                    <div class="addcart button">
                                        <button type="submit" class="primary-btn">Add to cart</button>
                                    </div>
                                    <div class="buynow button">
                                        <button type="submit" class="secondary-btn">Buy now</button>
                                    </div>
                                </div>
                                <div class="product-control list-inline">
                                    <ul>
                                        <li><a href=""><i class="ri-heart-line"></i><span>Add to wishlist</span></a></li>
<!--                                        <li><a href=""><i class="ri-share-forward-line"></i><span>Share</span></a></li>-->
                                        <li><a href=""><i class="ri-question-line"></i><span>Ask Question</span></a></li>
                                    </ul>
                                </div>
                                <div class="shipping">
                                    <ul>
                                        <li>
                                            <i class="ri-gift-line"></i>
                                            <span>Free shipping & return</span>
                                            <span class="grey-color">On orders over 50$</span>
                                        </li>
                                        <li>
                                            <i class="ri-truck-line"></i>
                                            <span>Estimate delivery</span>
                                            <span class="grey-color">03 - 07 day</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product detail">

                </div>
            </div>
        </div>
    </div>

</main>
</div>
<?php include "footer.php";?>

<script>

    $('.menu-bar').click(function(){
        $(this).toggleClass("click");
        $('.sidebar').toggleClass("show");
    });
    $('.feat-btn').click(function(){
        $('nav ul .feat-show').toggleClass("show");
        $('nav ul .first').toggleClass("rotate");
    });
    $('.serv-btn').click(function(){
        $('nav ul .serv-show').toggleClass("show1");
        $('nav ul .second').toggleClass("rotate");
    });
    $('.mobile nav ul li').click(function(){
        $(this).addClass("active").siblings().removeClass("active");
    });

</script>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
    //swiper
    const thumbImage = new Swiper('.thumbnail-image', {

        direction: 'vertical',
        spaceBetween: 15,
        slidesPerView: 1,
        freeMode: true,
        watchSlidesProgress: true,

    });

    const mainImage = new Swiper('.main-image', {

        loop: true,
        autoHeight: true,

        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        thumbs: {
            swiper: thumbImage,
        },

    });
</script>
<script src="js/script.js"></script>
</body>
</html>
