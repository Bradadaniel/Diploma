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
                                <li><a href=""><span class="item-floating">7</span>
                                        <i class="ri-star-line"></i>
                                    </a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="header-center">
                        <nav class="menu">
                            <ul>
<!--                                <li><a href=""><span>Home</span></a></li>-->
                                <li><a href="">
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
                                                                        <a href="" class="product-permalink"></a>
                                                                        <div class="thumbnail">
                                                                            <img src="prod-img/3.jpg"  alt="">
                                                                        </div>
                                                                        <div class="thumbnail hover">
                                                                            <img src="prod-img/11.jpg"  alt="">
                                                                        </div>
                                                                        <div class="actions">
                                                                            <ul>
                                                                                <li><a href=""><i class="ri-star-line"></i></a>
                                                                                </li>
                                                                                <li><a href=""><i class="ri-arrow-left-right-line"></i></a>
                                                                                </li>
                                                                                <li><a href=""><i
                                                                                            class="ri-eye-line"></i></a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="label"><span>-25%</span></div>
                                                                    </div>
                                                                    <div class="dot-info">
                                                                        <h2 class="dot-title"><a href="">Man Clothes</a></h2>
                                                                        <div class="product-price">
                                                                            <span class="before">500RSD</span>
                                                                            <span class="current">350RSD</span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!--                                                                copy-->
                                                                <div class="item">
                                                                    <div class="dot-image">
                                                                        <a href="" class="product-permalink"></a>
                                                                        <div class="thumbnail">
                                                                            <img src="prod-img/3.jpg"  alt="">
                                                                        </div>
                                                                        <div class="thumbnail hover">
                                                                            <img src="prod-img/22.jpg"  alt="">
                                                                        </div>
                                                                        <div class="actions">
                                                                            <ul>
                                                                                <li><a href=""><i class="ri-star-line"></i></a>
                                                                                </li>
                                                                                <li><a href=""><i class="ri-arrow-left-right-line"></i></a>
                                                                                </li>
                                                                                <li><a href=""><i
                                                                                            class="ri-eye-line"></i></a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="label"><span>-25%</span></div>
                                                                    </div>
                                                                    <div class="dot-info">
                                                                        <h2 class="dot-title"><a href="">Women Clothes</a></h2>
                                                                        <div class="product-price">
                                                                            <span class="before">500RSD</span>
                                                                            <span class="current">350RSD</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!--                                                                copy end-->
                                                                <!--                                                                copy-->
                                                                <div class="item">
                                                                    <div class="dot-image">
                                                                        <a href="" class="product-permalink"></a>
                                                                        <div class="thumbnail">
                                                                            <img src="prod-img/3.jpg" alt="">
                                                                        </div>
                                                                        <div class="thumbnail hover">
                                                                            <img src="prod-img/33.jpg" alt="">
                                                                        </div>
                                                                        <div class="actions">
                                                                            <ul>
                                                                                <li><a href=""><i class="ri-star-line"></i></a>
                                                                                </li>
                                                                                <li><a href=""><i class="ri-arrow-left-right-line"></i></a>
                                                                                </li>
                                                                                <li><a href=""><i
                                                                                            class="ri-eye-line"></i></a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="label"><span>-25%</span></div>
                                                                    </div>
                                                                    <div class="dot-info">
                                                                        <h2 class="dot-title"><a href="">Jackets under price</a></h2>
                                                                        <div class="product-price">
                                                                            <span class="before">500RSD</span>
                                                                            <span class="current">350RSD</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!--                                                                copy end-->


                                                            </div>
                                                        </div>
                                                        <div class="links">
                                                            <div class="list-block">
                                                                <h3 class="dot-title">Apparel</h3>
                                                                <ul>
                                                                    <li><a href="">Pull&Bear</a></li>
                                                                    <li><a href="">Berskha</a></li>
                                                                    <li><a href="">H&M</a></li>
                                                                    <li><a href="">Zara</a></li>
                                                                </ul>
                                                            </div>

                                                            <div class="list-block">
                                                                <h3 class="dot-title">Shoes</h3>
                                                                <ul>
                                                                    <li><a href="">Nike</a></li>
                                                                    <li><a href="">Adidas</a></li>
                                                                    <li><a href="">Puma</a></li>
                                                                    <li><a href="">New Balance</a></li>
                                                                </ul>
                                                            </div>

                                                            <div class="list-block">
                                                                <h3 class="dot-title">Gym</h3>
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
                                <li><a href=""><span>Favourites</span></a></li>
                            </ul>

                            <ul>
                                <li><a href=""><span>Specials</span>
                                        <i class="ri-arrow-down-s-line"></i>
                                    </a>
                                    <ul class="sub-menu list-block">
                                        <li><a href="">Nike</a></li>
                                        <li><a href="">Puma</a></li>
                                        <li><a href="">Adidas</a></li>
                                    </ul>
                                </li>
                                <li><a href="contact.php"><span>Contact</span></a></li>
                            </ul>
                        </nav>
                        <div class="branding"><a href="index.php"><img src="img/Dabe-logos_black2.png" alt=""></a></div>
                    </div>
                    <div class="header-right">
                        <div class="list-inline">
                            <ul>
                                <li><a href="#0" trigger-button data-target="search-float"><i class="ri-search-line"></i></a></li>
                                <li><a href=""><span class="item-floating">0</span><i class="ri-shopping-bag-line"></i></a></li>
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
        <div class="text">
            Side Menu
        </div>
        <hr>
        <ul>
            <li class="active"><a href="#">Dashboard</a></li>
            <li>
                <a href="#" class="feat-btn">Features
                    <span class="fas fa-caret-down first"></span>
                </a>
                <ul class="feat-show">
                    <li><a href="#">Pages</a></li>
                    <li><a href="#">Elements</a></li>
                </ul>
            </li>
            <li>
                <a href="#" class="serv-btn">Services
                    <span class="fas fa-caret-down second"></span>
                </a>
                <ul class="serv-show">
                    <li><a href="#">App Design</a></li>
                    <li><a href="#">Web Design</a></li>
                    <li><a href="#">App Design</a></li>
                    <li><a href="#">Web Design</a></li>
                    <li><a href="#">App Design</a></li>
                    <li><a href="#">Web Design</a></li>
                    <li><a href="#">App Design</a></li>
                    <li><a href="#">Web Design</a></li>
                    <li><a href="#">App Design</a></li>
                    <li><a href="#">Web Design</a></li>
                    <li><a href="#">App Design</a></li>
                    <li><a href="#">Web Design</a></li>
                </ul>
            </li>
            <li><a href="#">Portfolio</a></li>
            <li><a href="#">Overview</a></li>
            <li><a href="#">Shortcuts</a></li>
            <li><a href="#">Feedback</a></li>

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

