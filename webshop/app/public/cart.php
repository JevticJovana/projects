<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moja korpa</title>
    <?php include("../components/bootstrap.php"); ?>

</head>

<body>
    <?php require("../components/header.php"); ?>
    <?php require("../components/message.php"); ?>
    <?php include("../controllers/MiddlewareController.php"); ?>

    <div id="alertPlaceholder"></div>
    <?php
    require("../models/ProductModel.php");
    require "../models/ProductImageModel.php";
    require "../models/UserModel.php";
    require "../models/SessionModel.php";
    $ordered_cart = SessionModel::orderCart($_SESSION['cart']);
    $in_cart = ProductModel::getProductDetailsFromArray($ordered_cart);
    $price = 0;
    foreach ($in_cart as $product) {
        $product->main_image = ProductImageModel::getMainImage($product->id);
        $price += $product->price * $product->cart_quantity;
    }
    ?>
    <div class=" cart-grid mt-5">
        <div class="cart-summary shadow-custom">
            <h3 class="text-center">Moja korpa</h3>
            <span class="cart-count">Broj proizvoda u korpi: <?php echo count($_SESSION['cart']); ?></span><br>
            <span class="cart-price">Ukupna cena svih proizvoda u korpi: <?php echo $price . '.00 rsd'; ?></span>
            <div class="cart-actions">
                <?php if (count($in_cart) > 0) : ?>
                    <?php if (isset($_SESSION['user']['uid'])) : ?>
                        <div class="cart-action text-center shadow-custom" onclick="location.href = './checkout.php'">
                            <span><i class="fas fa-shopping-cart action-icon"></i><br>Nastavi na placanje</span>
                        </div>
                    <?php else : ?>
                        <div class="cart-action text-center shadow-custom" onclick="location.href = './login.php'">
                            <span><i class="fas fa-user action-icon"></i><br>Ulogujte se kako biste nastavili na placanje</span>
                        </div>
                    <?php endif; ?>
                    <div class="cart-action text-center shadow-custom border-animate-danger" onclick="emptyCart()">
                        <span><i class="fas fa-times action-icon"></i><br>Isprazni korpu</span>
                    </div>
                <?php else : ?>
                    <a href="./home.php" class="cart-action text-center shadow-custom ">
                        <span><i class="fas fa-home action-icon"></i><br>Pocetna stranica</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="cart-items">
            <?php if (count($in_cart) == 0) : ?>
                <h3 class="text-center">
                    ¯\_(ツ)_/¯<br>
                    Nazalost, nemate proizvoda u korpi.
                </h3>
            <?php else : ?>
                <div class="user products-container">
                    <?php foreach ($in_cart as $product) : ?>
                        <div class="user product shadow-custom">
                            <div class="product-image">
                                <img src="<?php echo $product->main_image; ?>">
                            </div>
                            <div class="product-info">
                                <div class="product-title">
                                    <span><?php echo $product->product_name; ?></span>
                                </div>
                                <div class="product-details">
                                    <div class="product-data">
                                        <span class="product-quantity">Kolicina u korpi: <b><?php echo $product->cart_quantity; ?></b></span>

                                        <span class="product-seller">Prodaje: <b><?php echo UserModel::getUsername($product->owner_id); ?></b></span>
                                        <span class="product-price">Cena: <?php echo $product->price . '.00'; ?></span>
                                    </div>
                                    <div class="product-actions mb-2">
                                        <div class="product-action shadow-custom border-animate-danger w-100" onclick="removeFromCart(<?php echo $product->id; ?>)"><i class="fas fa-trash action-icon"></i>
                                            <span class="action-text">Ukloni iz korpe</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <script src="../resources/js/cart.js"></script>
</body>

</html>