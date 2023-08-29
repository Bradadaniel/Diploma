<?php

//session_start();

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

$visitorId = $_COOKIE['visitor_id'] ?? null;
$lastVisitTime = $_COOKIE['last_visit_time'] ?? null;
$currentTimestamp = time();

if (!$visitorId || !$lastVisitTime || ($currentTimestamp - $lastVisitTime) >= 1800) {
    $visitorId = md5(uniqid(rand(), true));
    setcookie('visitor_id', $visitorId, $currentTimestamp + 1800); // 30 perc
    setcookie('last_visit_time', $currentTimestamp, $currentTimestamp + 1800); // 30 perc

    $visitorStmt = $pdo->prepare('SELECT * FROM visitors WHERE visitor_id = :visitor_id');
    $visitorStmt->bindParam(':visitor_id', $visitorId);
    $visitorStmt->execute();
    $visitor = $visitorStmt->fetch(PDO::FETCH_ASSOC);

    if (!$visitor) {
        $insertStmt = $pdo->prepare('INSERT INTO visitors (visitor_id, visit_count) VALUES (:visitor_id, 1)');
        $insertStmt->bindParam(':visitor_id', $visitorId);
        $insertStmt->execute();
    } else {
        $updateStmt = $pdo->prepare('UPDATE visitors SET visit_count = visit_count + 1 WHERE visitor_id = :visitor_id');
        $updateStmt->bindParam(':visitor_id', $visitorId);
        $updateStmt->execute();
    }
}




$cart_count_sql = "SELECT COUNT(*) FROM cart WHERE user_id = :user_id";
$cart_count_stmt = $pdo->prepare($cart_count_sql);
$cart_count_stmt->bindParam(':user_id', $id);
$cart_count_stmt->execute();
$cart_item_count = $cart_count_stmt->fetchColumn();
if ($id == ''){
    $cart_item_count= '0';
}

$wishlist_count_sql = "SELECT COUNT(*) FROM wishlist WHERE user_id = :user_id";
$wishlist_count_stmt = $pdo->prepare($wishlist_count_sql);
$wishlist_count_stmt->bindParam(':user_id', $id);
$wishlist_count_stmt->execute();
$wishlist_item_count = $wishlist_count_stmt->fetchColumn();
if ($id == ''){
    $wishlist_item_count= '0';
}

?>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>

</head>

<div id="page" class="page-home">
    <header>
        <div class="inner-header">
            <div class="container wide">
                <div class="wrap">
                    <div class="header-left">
                        <div class="menu-bar">
                            <a href="#" class="menu-trigger" trigger-button data-target="mobile-menu"><i class="ri-menu-line"></i></a>
                            <!--                            <div class="btn">-->
                            <!--                                <span class="fas fa-bars"></span>-->
                            <!--                            </div>-->
                        </div>
                        <div class="list-inline">
                            <ul>
                                <li><a href="">
                                        <i class="ri-user-line"></i>
                                    </a>
                                    <ul class="sub-menu" style="padding: 10px">
                                        <?php
                                        $select_profile= $pdo->prepare("SELECT * FROM `users` WHERE email = ?");
                                        $select_profile->execute([$email]);
                                        if ($select_profile->rowCount() > 0){
                                            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                                            ?>
                                            <div class="login">
                                                <h4>Welcome <span><?= $fetch_profile["username"]?></span></h4>
                                                <li class="primary-btn"><a href="">Update profile</a></li>
                                                <li class="secondary-btn"><a href="logout.php" onclick="return confirm('Biztosan kijelentkezik?')">Logout</a></li>
                                            </div>
                                            <?php
                                        }else{
                                        ?>
                                        <div class="login">
                                            <h4>Become a member too</h4>
                                        <li class="primary-btn"><a href="login.php">Login</a></li>
                                        <li class="secondary-btn"><a href="register.php">Register</a></li>
                                        </div>
                                        <?php
                                            }
                                        ?>

                                    </ul>
                                </li>




                                </li>
                                <li><a href="wishlist.php"><span class="item-floating"><?php echo $wishlist_item_count?></span>
                                        <i class="ri-heart-line"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="header-center">
                        <nav class="menu">
                            <ul>
<!--                                <li><a href=""><span>Home</span></a></li>-->
                                <li><a href="#Guide">
                                        <span>Products</span>
                                        <i class="ri-arrow-down-s-line"></i>
                                    </a>
                                    <ul class="sub-mega">
                                        <li>
                                            <div class="container">
                                                <div class="wrapper">
                                                    <div class="mega-content">
                                                        <div class="dotgrid">
                                                            <div class="wrapper">
                                                                <div class="item">
                                                                    <div class="dot-image">
                                                                        <a href="#shirt" class="product-permalink"></a>
                                                                        <div class="thumbnail">
                                                                            <img src="prod-img/1.jpg"  alt="" width="250">
                                                                        </div>
                                                                        <div class="thumbnail hover">
                                                                            <img src="prod-img/11.jpg"  alt="">
                                                                        </div>

                                                                    </div>
                                                                    <div class="dot-info">
                                                                        <h2 class="dot-title"><a href="">Shirts</a></h2>
                                                                    </div>
                                                                </div>

                                                                <div class="item">
                                                                    <div class="dot-image">
                                                                        <a href="#jeans" class="product-permalink"></a>
                                                                        <div class="thumbnail">
                                                                            <img src="prod-img/Jeans.jpg" width="250" alt="">
                                                                        </div>
                                                                        <div class="thumbnail hover">
                                                                            <img src="prod-img/2.jpg"  alt="">
                                                                        </div>

                                                                    </div>
                                                                    <div class="dot-info">
                                                                        <h2 class="dot-title"><a href="">Jeans</a></h2>
                                                                    </div>
                                                                </div>

                                                                <div class="item">
                                                                    <div class="dot-image">
                                                                        <a href="#jackets" class="product-permalink"></a>
                                                                        <div class="thumbnail">
                                                                            <img src="prod-img/3.jpg" width="250" alt="">
                                                                        </div>
                                                                        <div class="thumbnail hover">
                                                                            <img src="prod-img/33.jpg" alt="">
                                                                        </div>

                                                                    </div>
                                                                    <div class="dot-info">
                                                                        <h2 class="dot-title"><a href="">Jackets</a></h2>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>
                                                        <div class="links">
                                                            <div class="list-block">
                                                                <h3 class="dot-title">Brands</h3>
                                                                <ul>
                                                                    <li><a href="">Pull&Bear</a></li>
                                                                    <li><a href="">Berskha</a></li>
                                                                    <li><a href="">H&M</a></li>
                                                                    <li><a href="">Zara</a></li>
                                                                </ul>
                                                            </div>

                                                            <div class="list-block">
                                                                <h3 class="dot-title"></h3>
                                                                <ul>
                                                                    <li><a href="">Nike</a></li>
                                                                    <li><a href="">Adidas</a></li>
                                                                    <li><a href="">Puma</a></li>
                                                                    <li><a href="">New Balance</a></li>
                                                                </ul>
                                                            </div>

                                                            <div class="list-block">
                                                                <h3 class="dot-title"></h3>
                                                                <ul>
                                                                    <li><a href="">Gym Shark</a></li>
                                                                    <li><a href="">Under Armour</a></li>
                                                                    <li><a href="">Rhone</a></li>
                                                                    <li><a href="">Reebok</a></li>
                                                                </ul>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
<!--                                <li><a href=""><span>Favourites</span></a></li>-->
                                <li><a href="#News"><span>News</span></a></li>

                            </ul>

                            <ul>
                                <li><a href="contact.php"><span>Contact</span></a></li>
                                <li><a href="page-category.php"><span>Shop</span></a></li>
                            </ul>
                        </nav>
                        <div class="branding"><a href="index.php"><img src="img/Dabe-logos_black2.png" alt=""></a></div>
                    </div>
                    <div class="header-right">
                        <div class="list-inline">
                            <ul>
<!--                                <li><a href="#0" trigger-button data-target="search-float"><i class="ri-search-line"></i></a></li>-->
                                <li><a href="cart.php"><span class="item-floating"><?php echo $cart_item_count?></span><i class="ri-shopping-cart-line"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div id="search-float" class="search-float">
                <div class="container wide">
                    <form action="" class="search">
                        <i class="ri-search-line"></i>
                        <input type="search" class="input" name="" id="" placeholder="Search products">
                        <i class="ri-close-line" close-button></i>
                    </form>
                </div>
            </div>
        </div>
    </header>
</div>
<div class="overlay" data-overlay></div>

<div class="mobile">
    <nav class="sidebar">

        <ul>
            <li class="active"><a href="index.php">Home</a></li>
            <li class=""><a href="wishlist.php">Favourites</a></li>
            <li class=""><a href="cart.php">Cart</a></li>
            <li class=""><a href="page-category.php">Shop</a></li>
            <li class=""><a href="#Guide">Products</a></li>
<!--            <li>-->
<!--                <a href="#" class="serv-btn">Products-->
<!--                    <span class="fas fa-caret-down second"></span>-->
<!--                </a>-->
<!--                <ul class="serv-show">-->
<!--                    <li><a href="#">App Design</a></li>-->
<!--                    <li><a href="#">Web Design</a></li>-->
<!--                    <li><a href="#">App Design</a></li>-->
<!--                    <li><a href="#">Web Design</a></li>-->
<!--                    <li><a href="#">App Design</a></li>-->
<!--                    <li><a href="#">Web Design</a></li>-->
<!--                    <li><a href="#">App Design</a></li>-->
<!--                    <li><a href="#">Web Design</a></li>-->
<!--                    <li><a href="#">App Design</a></li>-->
<!--                    <li><a href="#">Web Design</a></li>-->
<!--                    <li><a href="#">App Design</a></li>-->
<!--                    <li><a href="#">Web Design</a></li>-->
<!--                </ul>-->
<!--            </li>-->
            <li><a href="contact.php">Contact</a></li>
            <?php
            $select_profile= $pdo->prepare("SELECT * FROM `users` WHERE email = ?");
            $select_profile->execute([$email]);
            if ($select_profile->rowCount() > 0){
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                ?>
                <div class="button">
                    <a href="logout.php" class="secondary-btn" onclick="return confirm('Biztosan kijelentkezik?')">Logout</a>
                </div>
                <?php
            }else{
            ?>
            <div class="button">
                <a href="login.php" class="secondary-btn">Login</a>
                <a href="register.php" class="primary-btn">Register</a>
            </div>
                <?php
            }
            ?>



        </ul>

    </nav>
</div>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
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

