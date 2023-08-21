<?php session_start();?>
<head xmlns="http://www.w3.org/1999/html">
    <link rel="shortcut icon" type="x-icon" href="img/Dabe-logos_black2.png">
    <title>DabeShop - Product</title>
    <link rel="stylesheet" href="css/style.css" />
<body>
<div id="page" class="page-single">

<?php include "header.php";?>
    <?php
    $msg='';
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
            $image_html = '';
            foreach ($product_images as $image) {
                $image_html .= '<div class="item swiper-slide"><img src="uploaded_images/' . $image . '" alt=""></div>';
//                $image_thumb .= '<div class="thumb-wrap"><img src="uploaded_images/' . $image . '" alt=""></div>';
            }
            $product_size = $row["product_size"];
            $product_brand = $row["product_brand"];
            $product_category = $row["product_category"];
            $product_detail = $row["product_detail"];

        }
//        kiszedni mennyi van
        $query = $pdo->prepare("SELECT SUM(product_quantity) AS total_quantity FROM product_storage WHERE product_id = ?");
        $query->execute([$product_id]);

        $totalQuantity = $query->fetch(PDO::FETCH_ASSOC)['total_quantity'];

    }


    if (isset($_POST['add_to_cart'])) {
        $product_id = $_POST['product_id']; // Termék azonosítója, amit a űrlapból kapunk
        $product_quantity = $_POST['quantity']; // Kiválasztott mennyiség

        // Ellenőrizd, hogy legalább egy méret van kiválasztva
        if (isset($_POST['selected_size']) && is_array($_POST['selected_size']) && count($_POST['selected_size']) > 0) {
            $selected_size = $_POST['selected_size'];

            // SQL parancs a cart tábla frissítéséhez
            $sql = "INSERT INTO cart (user_id, product_id, product_size, product_quantity)
                VALUES (:user_id, :product_id, :product_size, :product_quantity)";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':user_id', $id);
            $stmt->bindParam(':product_id', $product_id);

            // Mentsd el a méreteket egy változóba
            $selected_size_str = implode(',', $selected_size);
            $stmt->bindParam(':product_size', $selected_size_str);

            $stmt->bindParam(':product_quantity', $product_quantity);

            $stmt->execute();
            $msg = '<div class="alert success"><span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>Product added to cart successfully!</div>';
        } else {
            $msg = '<div class="alert"><span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>Please select at least one size.</div>';
        }
    }





    ?>

<div class="overlay" data-overlay></div>


    <div class="alert-div" style="margin-top: 50px;display: flex;align-items: center;justify-content: center">
        <?php echo $msg; ?>
    </div>
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
                                        <?php echo $image_html; ?>
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
                                        <?php
                                        foreach ($product_images as $image) {
                                            echo '<div class="item swiper-slide">';
                                            echo '<div class="thumb-wrap"><img src="uploaded_images/' . $image . '" alt=""></div>';
                                            echo '</div>';
                                        }
                                        ?>
                                        <!-- Adatbázisból kinyert képek beillesztése vége -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="summary">
                            <div class="entry">
                                <h1 class="title"><?php echo $product_name; ?></h1>
                                <h2 style="color: var(--grey-color);font-size: 24px;"><?php echo $product_brand; ?></h2>
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
<!--                                <form action="" method="post">-->
<!--                                    <div class="product-size">-->
<!--                                        <span>Size:</span>-->
<!--                                        <div class="wrap">-->
<!--                                            --><?php
                                            $sizes = explode(",", $product_size);
//                                            foreach ($sizes as $size) {
//                                                // Ellenőrzés, hogy van-e még készleten az adott méretből
//                                                $isAvailable = true; // Helyezd ide a készlet ellenőrzését
//
//                                                if ($isAvailable) {
//                                                    echo '<button name="selected_size" value="' . $size . '">' . $size . '</button>';
//                                                } else {
//                                                    echo '<button name="selected_size" value="' . $size . '" disabled style="background-color: gray;">' . $size . '</button>';
//                                                }
//                                            }
//                                            ?>
<!--                                        </div>-->
<!--                                    </div>-->
<!---->

<!--                                </form>-->

                                <form action="" method="post" id="productForm">
                                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">

                                    <div class="product-size">
                                        <span>Size:</span>
                                        <div class="wrap">
                                            <?php
                                            $sizes = explode(",", $product_size);
                                            foreach ($sizes as $size) {
                                                $isChecked = (isset($_POST['selected_size']) && in_array($size, $_POST['selected_size'])) ? 'checked' : '';
                                                echo '<input class="checkbox" type="checkbox" id="size_' . $size . '" name="selected_size[]" value="' . $size . '" ' . $isChecked . '>
                  <label class="checkbox-label" for="size_' . $size . '">' . $size . '</label>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <br>

                                    <div class="product-stock">
                                        <div class="wrap">
                                            <strong id="stock_count"><?php echo $totalQuantity; ?></strong>
                                            <span class="grey-color">in stock</span>
                                            <i class="ri-checkbox-circle-line"></i>
                                        </div>
                                    </div>
                                    <br>
                                    <p class="details"><?php echo $product_detail; ?></p>

                                    <div class="product-action">

                                        <div class="qty">
                                            <button class="decrease" name="change_qty" value="decrease">-</button>
                                            <input type="text" name="quantity" value="1">
                                            <button class="increase" name="change_qty" value="increase">+</button>
                                        </div>

                                        <div class="addcart button">
                                            <button type="submit" name="add_to_cart" class="primary-btn">Add to cart</button>
                                        </div>
                                        <div class="buynow button">
                                            <a href="page-category.php" class="secondary-btn" style="text-decoration: none">Continue shopping</a></div>
                                    </div>
                                </form>


<!--                                <div class="product-control list-inline">-->
<!--                                    <ul>-->
<!--                                        <li><a href=""><i class="ri-heart-line"></i><span>Add to wishlist</span></a></li>-->
<!--                                        <li><a href=""><i class="ri-question-line"></i><span>Ask Question</span></a></li>-->
<!--                                    </ul>-->
<!--                                </div>-->
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
    const quantityInput = document.querySelector('input[name="quantity"]');
    const decreaseButton = document.querySelector('.decrease');
    const increaseButton = document.querySelector('.increase');

    decreaseButton.addEventListener('click', (event) => {
        event.preventDefault();
        let newValue = parseInt(quantityInput.value) - 1;
        if (newValue < 1) newValue = 1;
        quantityInput.value = newValue;
    });

    increaseButton.addEventListener('click', (event) => {
        event.preventDefault();
        let newValue = parseInt(quantityInput.value) + 1;
        quantityInput.value = newValue;
    });

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
