<?php

include 'php/config.php';
include 'php/db_config.php';

$pdo = connectDatabase($dsn, $pdoOptions);

if (isset($_POST['searchTerm'])) {
    $searchTerm = $_POST['searchTerm'];



    $sql = "SELECT * FROM products WHERE product_name LIKE :searchTerm";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($results) {
        foreach ($results as $row) {
            $product_name = $row["product_name"];
            $product_price = $row["product_price"];
            $product_size = $row["product_size"];
            $product_images = explode(",", $row["product_img"]); // Képek tömbbe szétválasztása
            $product_action = $row["product_action"];

            $discounted_price = $product_price - ($product_price * ($product_action / 100));

            echo '<div class="item">';
            echo '<div class="dot-image">';
            echo '<a href="page-single.php?product_id=' . $row['product_id'] . '" class="product-permalink"></a>';
            echo '<div class="thumbnail">';
            echo '<img src="uploaded_images/' . $product_images[0] . '" alt="">';
            echo '</div>';
            echo '<div class="thumbnail hover">';
            echo '<img src="uploaded_images/' . $product_images[1] . '" alt="">';
            echo '</div>';
            echo '<div class="actions">';
            echo '<ul>';
            if (!empty($id)) {
                echo '<li><a href="?product_id=' . $row['product_id'] . '"><i class="ri-heart-line"></i></a></li>';
            }
            echo '<li><a href="page-single.php?product_id=' . $row['product_id'] . '"><i class="ri-eye-line"></i></a></li>';
            echo '</ul>';
            echo '</div>';
            if ($product_action) {
                echo '<div class="label action"><span>-' . $product_action . '%</span></div>';
            }
            echo '</div>';
            echo '<div class="dot-info">';
            echo '<h2 class="dot-title"><a href="page-single.php?product_id=' . $row['product_id'] . '">' . $product_name . '</a></h2>';
            echo '<div class="product-price">';
            if ($product_action) {
                $discounted_price = $product_price - ($product_price * ($product_action / 100));
                echo '<span class="before">' . $product_price . '$ </span>';
                echo '<span class="current">' . $discounted_price . '$</span>';
            } else {
                echo '<span class="current">' . $product_price . '$</span>';
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "No results found.";
    }
}

