<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rezultati pretrage</title>
    <?php include("../components/bootstrap.php"); ?>

</head>

<body>
    <?php include("../components/header.php"); ?>
    <?php include("../components/message.php"); ?>
    <?php include("../controllers/MiddlewareController.php"); ?>
    <?php include("../models/ProductModel.php"); ?>
    <?php include("../models/ProductImageModel.php"); ?>
    <?php include("../models/CategoryModel.php"); ?>
    <?php require "../models/UserModel.php"; ?>
    <?php
    $search_text = $_GET['search_text'];
    $products = ProductModel::getSearchProducts($search_text);
    if (isset($_GET['sort'])) {
        $products = ProductModel::getSearchProductsSorted($_GET['sort']);
    }
    foreach ($products as $product) {
        $product->main_image = ProductImageModel::getMainImage($product->id);
        $product->category_title = CategoryModel::getCategoryTitle($product->category_id);
    }
    ?>
    <?php include("../components/search.php"); ?>
    <div id="alertPlaceholder"></div>
    <div class="container">
        <div class="container mt-5">
            <h3 class="text-center">Rezultati za pretragu "<?php echo $_GET['search_text']; ?>"</h3>
            <div class="container text-center">
                <h5>Sortiraj po:</h5>
                <div class="sort-options">
                    <div class="sort-option product-action border-animate-primary <?php if (isset($_GET['sort']) && $_GET['sort'] == "DESC") echo 'active' ?>" onclick="location.href = './search_results.php?search_text=<?php echo $_GET['search_text'] . '&sort=DESC'; ?>'">
                        <i class="fas fa-dollar-sign"></i>
                        <i class="fas fa-chevron-down"></i>
                        <div class="action-text">Ceni opadajuce</div>
                    </div>
                    <div class="sort-option product-action border-animate-danger <?php if (isset($_GET['sort']) && $_GET['sort'] == "ASC") echo 'active' ?>" onclick="location.href = './search_results.php?search_text=<?php echo $_GET['search_text'] . '&sort=ASC'; ?>'">
                        <i class="fas fa-dollar-sign"></i>
                        <i class="fas fa-chevron-up"></i>
                        <div class="action-text">Ceni rastuce</div>

                    </div>

                </div>
            </div>
            <div class="user products-container">
                <?php foreach ($products as $product) : ?>
                    <div class="user product shadow-custom">
                        <div class="product-image">
                            <img src="<?php echo $product->main_image; ?>">
                        </div>
                        <div class="product-info">
                            <div class="product-title">
                                <span><?php echo $product->product_name . " - " . CategoryModel::getCategoryTitle($product->category_id); ?></span>
                            </div>
                            <div class="product-details">
                                <div class="product-data">
                                    <span class="product-seller">Prodaje: <b><?php echo UserModel::getUsername($product->owner_id); ?></b></span>
                                    <span class="product-price">Cena: <?php echo $product->price . '.00'; ?></span>
                                </div>
                                <div class="product-actions mb-2">
                                    <?php if ($product->stock > 0) : ?>
                                        <div class="product-action shadow-custom border-animate-primary" onclick="addToCart(<?php echo $product->id; ?>)"><i class="fas fa-shopping-cart  action-icon"></i>
                                            <span class="action-text">Dodaj u korpu</span>
                                        </div>
                                    <?php else : ?>
                                        <div class="product-action shadow-custom border-animate-danger"><i class="fas fa-shopping-cart  action-icon"></i>
                                            <span class="action-text">Nema na stanju</span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="product-action shadow-custom border-animate-primary" onclick="addToWishlist(<?php echo $product->id; ?>)"><i class="fas fa-bookmark action-icon"></i>
                                        <span class="action-text">Dodaj u listu zelja</span>
                                    </div>
                                    <a href="./product_details.php?product_id=<?php echo $product->id; ?>" class="product-action shadow-custom border-animate-primary">
                                        <i class="fas fa-eye action-icon"></i>
                                        <span class="action-text">Pogledaj proizvod</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>

</html>