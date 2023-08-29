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
$msg='';

$sql = "SELECT * FROM products";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$msg='';

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $check_sql = "SELECT * FROM wishlist WHERE user_id = :user_id AND product_id = :product_id";
    $check_stmt = $pdo->prepare($check_sql);
    $check_stmt->bindParam(':user_id', $id);
    $check_stmt->bindParam(':product_id', $product_id);
    $check_stmt->execute();

    if ($check_stmt->rowCount() == 0) {
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
?>

</div>
<div class="overlay" data-overlay></div>
<?php echo $msg;?>
<main>
    <div class="section">
        <div class="container wide">
            <div class="wrap">
                <div class="heading">
                    <h1 class="title"></h1>
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
                                        <input type="checkbox" name="cats" id="aac" checked>
                                        <label for="aac">
                                            <span>Category</span>
                                            <i class="ri-arrow-down-s-line"></i>
                                        </label>
                                        <div class="accord list-block scrollto">
                                            <ul class="wrapper initial">
                                                <a href=""><li class="">Hoodie</li></a>
                                                <li class="">Shirt</li>
                                                <li class="">Jeans</li>
                                                <li class="">T-Shirt</li>
                                                <li class="">Jackets</li>
                                                <li class="">Skirt</li>
                                                <li class="">Hat</li>
                                                <li class="">Bag</li>
                                                <li class="">Sweather</li>
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
                                            <input type="range" id="priceRange" value="1000" min="0" max="25000" step="1">
                                        </div>
                                        <div class="price-range grey-color">
                                            <span id="minPrice">$1</span>
                                            <span id="maxPrice">$3000</span>
                                        </div>
                                    </div>
                                </div>
<!--                                <button type="submit" id="submit_sorters" class="primary-btn" style="padding: 0.5rem;font-size: 1.5rem">Submit Sorter</button>-->
                            </div>
                        </div>
                    </div>
                    <div class="category-content">
                        <div class="sorter">
                            <div class="left">
                                <form id="searchForm" method="post" style="display: flex">
                                    <input type="text" id="searchInput" name="searchTerm" placeholder="Search for products">
                                    <button type="submit" style="padding: 0.5rem;font-size: 1.5rem"><i class="ri-search-line"></i></button>
                                </form>
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
                                            <li><a href="#0">Latest</a></li>
                                            <li><a href="#0">Price low to hight</a></li>
                                            <li><a href="#0">Price hight to low</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="list-inline">
                                    <ul>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div id="searchResults" class="dotgrid">
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
                                                            if (!empty($id)) {
                                                                echo '<li><a href="?product_id=' . $row['product_id'] . '"><i class="ri-heart-line"></i></a></li>';
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
<!--                        <div class="button"><a href="" class="primary-btn">Load more</a></div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'footer.php'?>


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

    $(document).ready(function () {
        $('#searchForm').on('submit', function (event) {
            event.preventDefault(); // Az űrlap alapértelmezett beküldésének megakadályozása

            var searchTerm = $('#searchInput').val(); // Keresési kifejezés lekérése

            $.ajax({
                url: 'search_products.php', // Az AJAX kérést feldolgozó PHP fájl elérési útvonala
                method: 'POST',
                data: { searchTerm: searchTerm }, // Elküldendő adatok
                success: function (response) {
                    $('#searchResults .wrapper').html(response); // Keresési eredmények beillesztése a megfelelő helyre
                }
            });
        });
    });
</script>
<script src="js/script.js"></script>
</body>
</html>
