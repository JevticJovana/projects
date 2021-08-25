<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pocetna</title>
    <?php include("../components/bootstrap.php"); ?>

</head>

<body>
    <?php include("../components/header.php"); ?>
    <?php include("../components/search.php"); ?>
    <?php include("../components/message.php"); ?>
    <?php include("../controllers/MiddlewareController.php"); ?>

    <div id="alertPlaceholder"></div>
    <div class="container">
        <div class="container mt-5">
            <h3 class="text-center">Pregled proizvoda</h3>
            <?php require "../models/ProductModel.php";
            require "../models/UserModel.php";
            require "../models/CategoryModel.php";
            require "../models/ProductReviewModel.php";
            $products = ProductModel::getAllProducts();
            ?>
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
                                    <span class="product-price">Cena: <?php echo $product->price . '.00 rsd'; ?></span>
                                    <div class="product-rate text-center">
                                        <?php $rate = round(ProductReviewModel::getAvgRate($product->id),2);?>
                                        <?php for($i = 0; $i< $rate; $i++):?>
                                            <i class = "fas fa-star"></i>
                                        <?php endfor;?><br>
                                        <?php for($i = 0; $i < 5 - round($rate,0); $i++):?>
                                            <i class = "far fa-star"></i>
                                            <?php endfor;?>
                                    </div>
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
                                    <div class="product-action shadow-custom border-animate-primary" onclick = "addToWishlist(<?php echo $product->id;?>)"><i class="fas fa-bookmark action-icon"></i>
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
    <script src="../resources/js/home.js"></script>
</body>

</html>