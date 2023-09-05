<?php

include 'php/config.php';
include 'php/db_config.php';

$pdo = connectDatabase($dsn, $pdoOptions);


$sql = "SELECT * FROM products WHERE 1"; // Default SQL query

if (isset($_POST['searchTerm'])) {
    $searchTerm = $_POST['searchTerm'];
    $sql .= " AND product_name LIKE :searchTerm";

    $sql2 = "UPDATE search SET count = count + 1";
    $pdo->exec($sql2);
}

$conditions = []; // An array to store conditions for the query

if (isset($_POST['selectedSizes']) && !empty($_POST['selectedSizes'])) {
    $selectedSizes = $_POST['selectedSizes'];

    $sizePlaceholders = [];
    foreach ($selectedSizes as $index => $size) {
        $sizePlaceholder = ":size$index";
        $sizePlaceholders[] = $sizePlaceholder;
        $conditions[$sizePlaceholder] = '%' . $size . '%';
    }

    $sizeConditions = [];
    foreach ($sizePlaceholders as $placeholder) {
        $sizeConditions[] = "product_size LIKE $placeholder";
    }

    $sql .= " AND (" . implode(' OR ', $sizeConditions) . ")";
}


if (isset($_POST['selectedBrands']) && !empty($_POST['selectedBrands'])) {
    $selectedBrands = $_POST['selectedBrands'];

    $brandPlaceholders = [];
    foreach ($selectedBrands as $index => $brand) {
        $brandPlaceholder = ":brand$index";
        $brandPlaceholders[] = $brandPlaceholder;
        $conditions[$brandPlaceholder] = $brand;
    }

    $brandConditions = [];
    foreach ($brandPlaceholders as $placeholder) {
        $brandConditions[] = "product_brand = $placeholder";
    }

    $sql .= " AND (" . implode(' OR ', $brandConditions) . ")";
}

if (isset($_POST['selectedCategories']) && !empty($_POST['selectedCategories'])) {
    $selectedCategories = $_POST['selectedCategories'];

    // If multiple categories are selected, create a placeholder for each
    $categoryPlaceholders = [];
    foreach ($selectedCategories as $index => $category) {
        $categoryPlaceholder = ":category$index";
        $categoryPlaceholders[] = $categoryPlaceholder;
        $conditions[$categoryPlaceholder] = $category;
    }

    $categoryConditions = implode(',', $categoryPlaceholders);
    $sql .= " AND product_category IN ($categoryConditions)";
}

$stmt = $pdo->prepare($sql);

if (isset($searchTerm)) {
    $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
}

foreach ($conditions as $placeholder => $value) {
    $stmt->bindValue($placeholder, $value);
}

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


//$sql = "SELECT * FROM products WHERE 1"; // Alapértelmezett SQL lekérdezés
//
//// Kereső név alapján szűrés
//if (isset($_POST['searchTerm'])) {
//    $searchTerm = $_POST['searchTerm'];
//    $sql .= " AND product_name LIKE :searchTerm";
//}
//
//if (isset($_POST['selectedSizes']) && !empty($_POST['selectedSizes'])) {
//    $selectedSizes = $_POST['selectedSizes'];
//
//    // Az adatbázisban lévő méretekkel összevetjük a kiválasztott méreteket
//    $sizeConditions = [];
//    foreach ($selectedSizes as $size) {
//        $sizeConditions[] = "FIND_IN_SET('$size', product_size) > 0";
//    }
//
//    // Lekérdezés feltétel hozzáadása
//    $sql .= " AND (" . implode(' OR ', $sizeConditions) . ")";
//}
//
//if (isset($_POST['selectedBrands']) && !empty($_POST['selectedBrands'])) {
//    $selectedBrands = $_POST['selectedBrands'];
//    $brandPlaceholders = implode(',', array_fill(0, count($selectedBrands), '?'));
//
//    $sql .= " AND product_brand IN ($brandPlaceholders)";
//}
//
//if (isset($_POST['selectedCategories']) && !empty($_POST['selectedCategories'])) {
//    $selectedCategories = $_POST['selectedCategories'];
//    $categoryPlaceholders = implode(',', array_fill(0, count($selectedCategories), '?'));
//
//    $sql .= " AND product_category IN ($categoryPlaceholders)";
//}
//
//$stmt = $pdo->prepare($sql);
//
//// Kereső név paraméter hozzáadása
//if (isset($searchTerm)) {
//    $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
//}
//
//// Paraméterek hozzáadása és végrehajtás
//if (isset($selectedSizes) && !empty($selectedSizes)) {
//    $stmt->execute($selectedSizes);
//} else if (isset($selectedBrands) && !empty($selectedBrands)) {
//    $stmt->execute($selectedBrands);
//} else if (isset($selectedCategories) && !empty($selectedCategories)) {
//    $stmt->execute($selectedCategories);
//} else {
//    $stmt->execute();
//}
//
//
//$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
//
//    if ($results) {
//        foreach ($results as $row) {
//            $product_name = $row["product_name"];
//            $product_price = $row["product_price"];
//            $product_size = $row["product_size"];
//            $product_images = explode(",", $row["product_img"]); // Képek tömbbe szétválasztása
//            $product_action = $row["product_action"];
//
//            $discounted_price = $product_price - ($product_price * ($product_action / 100));
//
//            echo '<div class="item">';
//            echo '<div class="dot-image">';
//            echo '<a href="page-single.php?product_id=' . $row['product_id'] . '" class="product-permalink"></a>';
//            echo '<div class="thumbnail">';
//            echo '<img src="uploaded_images/' . $product_images[0] . '" alt="">';
//            echo '</div>';
//            echo '<div class="thumbnail hover">';
//            echo '<img src="uploaded_images/' . $product_images[1] . '" alt="">';
//            echo '</div>';
//            echo '<div class="actions">';
//            echo '<ul>';
//            if (!empty($id)) {
//                echo '<li><a href="?product_id=' . $row['product_id'] . '"><i class="ri-heart-line"></i></a></li>';
//            }
//            echo '<li><a href="page-single.php?product_id=' . $row['product_id'] . '"><i class="ri-eye-line"></i></a></li>';
//            echo '</ul>';
//            echo '</div>';
//            if ($product_action) {
//                echo '<div class="label action"><span>-' . $product_action . '%</span></div>';
//            }
//            echo '</div>';
//            echo '<div class="dot-info">';
//            echo '<h2 class="dot-title"><a href="page-single.php?product_id=' . $row['product_id'] . '">' . $product_name . '</a></h2>';
//            echo '<div class="product-price">';
//            if ($product_action) {
//                $discounted_price = $product_price - ($product_price * ($product_action / 100));
//                echo '<span class="before">' . $product_price . '$ </span>';
//                echo '<span class="current">' . $discounted_price . '$</span>';
//            } else {
//                echo '<span class="current">' . $product_price . '$</span>';
//            }
//            echo '</div>';
//            echo '</div>';
//            echo '</div>';
//        }
//    } else {
//        echo "No results found.";
//    }
//
