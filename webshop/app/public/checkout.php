<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Placanje</title>
    <?php require("../components/bootstrap.php"); ?>


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
    require "../models/ShippingProfileModel.php";
    $ordered_cart = SessionModel::orderCart($_SESSION['cart']);
    $_SESSION['ordered_cart'] = $ordered_cart;
    $in_cart = ProductModel::getProductDetailsFromArray($ordered_cart);
    $price = 0;
    foreach ($in_cart as $product) {
        $product->main_image = ProductImageModel::getMainImage($product->id);
    }
    $user_profile = ShippingProfileModel::getShippingProfile($_SESSION['user']['uid']);
    ?>
    <div class="container checkout-summary mt-3">
        <div class="checkout-info">
            <form class="neumorphic-form" action="../controllers/CheckoutController.php" method="POST">
                <div id="contact-form" class="neumorphic-form">
                    <div class="neumorphic-input-container">
                        <input id="fname" type="text" class="neumorphic-input" name="first_name" required="required" value="<?php if (isset($user_profile->first_name)) echo $user_profile->first_name; ?>">
                        <label class="neumorphic-label">Ime</label>
                    </div>
                    <div class="neumorphic-input-container ">
                        <input id="lname" type="text" class="neumorphic-input" name="last_name" required="required" value="<?php if (isset($user_profile->last_name)) echo $user_profile->last_name; ?>">
                        <label for=" lname" class="neumorphic-label">Prezime</label>
                    </div>
                    <div class="row">
                        <div class="neumorphic-input-container col-md-6">
                            <input id="address" type="text" class="neumorphic-input" name="address" required="required" value="<?php if (isset($user_profile->address)) echo $user_profile->address; ?>">
                            <label for=" address" class="neumorphic-label">Adresa</label>
                        </div>
                        <div class="neumorphic-input-container col-md-6">
                            <input id="zcode" type="text" class="neumorphic-input" name="zip_code" required="required" value="<?php if (isset($user_profile->zip_code)) echo $user_profile->zip_code; ?>">
                            <label for=" zcode" class="neumorphic-label">Postanski broj</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="neumorphic-input-container col-md-6">
                            <input id="city" type="text" class="neumorphic-input" name="city" required="required" value="<?php if (isset($user_profile->city)) echo $user_profile->city; ?>">
                            <label for=" city" class="neumorphic-label">Grad</label>
                        </div>

                        <div class="neumorphic-input-container col-md-6">
                            <input id="country" type="text" class="neumorphic-input" name="country" required="required" value="<?php if (isset($user_profile->country)) echo $user_profile->country; ?>">
                            <label for=" country" class="neumorphic-label">Drzava</label>
                        </div>
                    </div>
                </div>
                <div id="card-form" class="neumorphic-form">
                    <div class="neumorphic-input-container ">
                        <input id="card-name" type="text" class="neumorphic-input" name="card_name" >
                        <label for="card-name" class="neumorphic-label">Ime i prezime vlasnika</label>
                    </div>
                    <div class="row">
                        <div class="neumorphic-input-container col-md-6">
                            <input id="cardExpire" type="text" class="neumorphic-input" name="card_expire" placeholder="MM/YY">
                            <label for="cardExpire" class="neumorphic-label">Datum isteka</label>
                        </div>
                        <div class="neumorphic-input-container col-md-6">
                            <input id="cvc" type="text" class="neumorphic-input" name="cvc_code">
                            <label for="cvc" class="neumorphic-label">CVC broj</label>
                        </div>
                    </div>
                </div>
                <div class="neumorphic-input-container radio ">
                    <div class="wrapper shadow-custom">
                        <input type="radio" name="payment" id="option-1" value="0" class="hiddenRadio">
                        <input type="radio" name="payment" id="option-2" value="1" class="hiddenRadio">
                        <label for="option-1" class="option option-1 shadow-custom" onclick="hideCardForm()">
                            <div class="dot"></div>
                            <span>Kes</span>
                        </label>
                        <label for="option-2" class="option option-2 shadow-custom" onclick="showCardForm()">
                            <div class="dot"></div>
                            <span>Kartica</span>
                        </label>
                    </div>
                    <input type="hidden" name="proceed_checkout">
                    <button type="submit" class="neumorphic-button">Sacuvaj</button>
                </div>
            </form>
        </div>
        <div class="checkout-items shadow-custom">
            <h5 class='text-center my-3'>Pregled porudzbine</h5>
            <?php foreach ($in_cart as $product) : ?>
                <?php $price += $product->cart_quantity * $product->price; ?>
                <div class="checkout-item">
                    
                    <div class="product-image">
                        <img src="<?php echo $product->main_image; ?>">
                    </div>
                    <div class="product-info">
                        <div class="product-title">
                            <span><?php echo $product->product_name; ?></span>
                        </div>
                        <div class="product-details">
                            <span class="product-price"><?php echo $product->cart_quantity . " x " . $product->price . '.00 = ' . $product->cart_quantity * $product->price . '.00 din '; ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <span class="checkout-total shadow-custom">Ukupno: <?php echo $price . ".00 rsd"; ?> </span>
        </div>
    </div>
    <script src="../resources/js/checkout.js"></script>
</body>

</html>