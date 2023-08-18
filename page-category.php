<?php session_start();?>
<head>
    <link rel="shortcut icon" type="x-icon" href="img/Dabe-logos_black2.png">
    <title>DabeShop - Category</title>
    <link rel="stylesheet" href="css/style.css" />

</head>
<body>
<div id="page" class="page-category">

<?php include 'header.php'?>
<?php


$sql = "SELECT * FROM products";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

</div>
<div class="overlay" data-overlay></div>

<main>
    <div class="section">
        <div class="container wide">
            <div class="wrap">
                <div class="heading">
                    <h1 class="title">Sweater</h1>
                </div>
                <div class="content">
                    <div id="sidebar-filter" class="sidebar">
                        <div class="wrap">
                            <a href="#0" class="close-trigger">
                                <i class="ri-close-line"></i>
                            </a>
                            <div class="sidebar-content">
                                <div class="sidebar-title">Filter</div>
                                <div class="widget">
                                    <div class="summary">
                                        <input type="checkbox" name="cats" id="aaa" checked>
                                        <label for="aaa">
                                            <span>Size</span>
                                            <i class="ri-arrow-down-s-line"></i>
                                        </label>
                                        <div class="accord product-size">
                                            <div class="wrap">
                                                <button>S</button>
                                                <button>M</button>
                                                <button>L</button>
                                                <button>XL</button>
                                                <button>XXL</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget">
                                    <div class="summary">
                                        <input type="checkbox" name="cats" id="aab" checked>
                                        <label for="aab">
                                            <span>Color</span>
                                            <i class="ri-arrow-down-s-line"></i>
                                        </label>
                                        <div class="accord product-color">
                                            <div class="wrap">
                                                <button class="tosca"></button>
                                                <button class="brown"></button>
                                                <button class="purple"></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget">
                                    <div class="summary">
                                        <input type="checkbox" name="cats" id="aac" checked>
                                        <label for="aac">
                                            <span>Category</span>
                                            <i class="ri-arrow-down-s-line"></i>
                                        </label>
                                        <div class="accord list-block scrollto">
                                            <ul class="wrapper initial">
                                                <a href=""><li class="">Active Wear</li></a>
                                                <li class="">Beauty</li>
                                                <li class="">Candles</li>
                                                <li class="">Fashion</li>
                                                <li class="">Glases</li>
                                                <li class="">Organic</li>
                                                <li class="">Hat</li>
                                                <li class="">Bedding</li>
                                                <li class="">Backpack</li>
                                                <li class="">Sneaker</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget">
                                    <div class="summary">
                                        <input type="checkbox" name="cats" id="aad" checked>
                                        <label for="aad">
                                            <span>Brands</span>
                                            <i class="ri-arrow-down-s-line"></i>
                                        </label>
                                        <div class="accord list-block scrollto">
                                            <ul class="wrapper initial">
                                                <li class="">Adidas</li>
                                                <li class="">Chanel</li>
                                                <li class="">Dolce & Gabanna</li>
                                                <li class="">Gucci</li>
                                                <li class="">Louis Vuttion</li>
                                                <li class="">Nike</li>
                                                <li class="">Prada</li>
                                                <li class="">Puma</li>
                                                <li class="">Zara</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget">
                                    <div class="summary">
                                        <label><span>Price</span></label>
                                        <div class="range-track">
                                            <input type="range" value="1000" min="0" max="25000" step="1">
                                        </div>
                                        <div class="price-range grey-color">
                                            <span>1000RSD</span>
                                            <span>25000RSD</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="category-content">
                        <div class="sorter">
<!--                            <a href="#0" class="menu-trigger">-->
<!--                                <i class="ri-filter-line"></i>-->
<!--                            </a>-->
                            <div class="left">
                                <span class="grey-color">Showing 9 of 35 results</span>
                            </div>
                            <div class="right">
                                <div class="sort-list">
                                    <div class="wrap">
                                        <div class="opt-trigger">
                                            <span class="value">Default sorting</span>
                                            <i class="ri-arrow-down-s-line"></i>
                                        </div>
                                        <ul>
                                            <li class="active"><a href="#0">Default sorting</a></li>
                                            <li><a href="#0">Popular</a></li>
                                            <li><a href="#0">Latest</a></li>
                                            <li><a href="#0">Price low to hight</a></li>
                                            <li><a href="#0">Price hight to low</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="list-inline">
                                    <ul>
<!--                                        <li><a href=""><i class="ri-pause-mini-line"></i></a></li>-->
<!--                                        <li><a href=""><i class="ri-list-check-2"></i></a></li>-->
<!--                                        <li><a href=""><i class="ri-layout-grid-line"></i></a></li>-->
<!--                                        <li><a href=""><i class="ri-layout-masonry-line"></i></a></li>-->
                                    </ul>
                                </div>
                            </div>
                        </div>
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
                                                        <li><a href=""><i class="ri-star-line"></i></a></li>
                                                        <li><a href=""><i class="ri-arrow-left-right-line"></i></a></li>
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
                        <div class="button"><a href="" class="primary-btn">Load more</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'footer.php'?>


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
