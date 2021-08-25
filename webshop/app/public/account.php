<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moj nalog</title>
    <?php include("../components/bootstrap.php"); ?>

</head>

<body>
    <?php include("../components/header.php"); ?>
    <?php include("../components/message.php"); ?>
    <?php include("../controllers/MiddlewareController.php"); ?>

    <?php require "../models/CheckoutModel.php";
            require "../models/ProductModel.php";
            require "../models/ShippingProfileModel.php";
            require "../models/SessionModel.php";
            require "../models/WishlistModel.php";
            require "../models/ProductImageModel.php";
    $checkouts = CheckoutModel::getCustomerOrders($_SESSION['user']['uid']);
    // var_dump($checkouts);
    ?>
    <div id="alertPlaceholder"></div>
    <div class="container mt-5">
        <h3 class="text-center">Pregled porudzbina</h3>
        <div class="orders-container mt-5">
            <?php if (count($checkouts) > 0) : ?>
                <?php foreach ($checkouts as $ref_no => $checkout) : ?>
                    <div class="order shadow-custom my-3">
                        <div class="order-header">
                            <div>
                                <div class="order-number p-3">
                                    <?php echo $ref_no; ?>
                                </div>
                                <div class="order-details p-3">
                                    <?php
                                    $shippingProfile = ShippingProfileModel::getShippingProfile($checkout[0]->profile_id);
                                    ?>
                                    <div class="order-info">
                                        <div class="orderer-info ">
                                            <?php echo $shippingProfile->first_name . ", " . $shippingProfile->last_name . ", " . $shippingProfile->address . ", " . $shippingProfile->city . ", " . $shippingProfile->zip_code . ", " . $shippingProfile->country  ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $orderStatus = CheckoutModel::getCheckoutStatus($ref_no);
                            ?>
                            <?php if ($orderStatus == 1) : ?>
                                <div class=" product-action border-animate-primary">
                                    <i class="fas fa-check"></i>
                                    <span class="action-text">Porudzbina je odobrena</span>
                                </div>
                            <?php else : ?>
                                <div class=" product-action border-animate-danger" onclick="cancelOrder('<?php echo $ref_no; ?>')">
                                    <i class="fas fa-times"></i>
                                    <span class="action-text">Otkazi porudzbinu</span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="show-details" onclick="showDetails('ref<?php echo $ref_no; ?>')">
                            <i class="fas fa-sort-down"></i>
                        </div>
                        <div class="order-items" id="ref<?php echo $ref_no; ?>">
                            <?php foreach ($checkout as $order_item) : ?>
                                <div class="order-item mt-3 shadow-custom border-animate">
                                    <?php
                                    $product = ProductModel::getProductDetails($order_item->product_id);
                                    $product->main_image = ProductImageModel::getMainImage($order_item->product_id);
                                    ?>
                                    <div class="product-image">
                                        <img src="<?php echo $product->main_image; ?>">
                                    </div>
                                    <div class="product-details">
                                        <span class="product-name"><?php echo $product->product_name; ?></span>
                                        <span class="product-price">Cena: <?php echo $product->price . ".00 rsd"; ?></span>
                                        <span class="product-quantity">Kolicina: <?php echo $order_item->quantity; ?></span>

                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="order-actions">

                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <h1 class="text-center">
                    ¯\_(ツ)_/¯
                </h1>
                <h4 class="text-center">Ups...Izgleda da nemate ni jednu porudzbinu u nasoj prodavnici.</h4>
            <?php endif; ?>
        </div>
    </div>
    <div class="container my-5">
        <h3 class="text-center">
            Lista zelja
        </h3>
        <?php
        $wishlistItems = WishlistModel::getUserWishlist(SessionModel::getUserId());
        ?>
        <div class="wishlist-items">
            <?php if (count($wishlistItems) > 0) : ?>
                <?php foreach ($wishlistItems as $product) : ?>
                    <div class="wishlist-item shadow-custom">
                        <div class="wishlist-image" onclick="location.href = './product_details.php?product_id=<?php echo $product->id; ?>'">
                            <img src="<?php echo $product->main_image; ?>" alt="">
                        </div>
                        <div class="product-name mt-2" onclick="location.href = './product_details.php?product_id=<?php echo $product->id; ?>'">
                            <b><?php echo $product->product_name; ?></b>
                        </div>
                        <div class="product-price">
                            <?php echo $product->price . ".00 rsd"; ?>
                        </div>
                        <div class="remove-from-wishlist" onclick="removeFromWishlist(<?php echo $product->id; ?>)">
                            <i class="fas fa-trash"></i>
                            Ukloni iz liste zelja
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class = "mt-5">
                    <h1 class="text-center">
                        ¯\_(ツ)_/¯
                    </h1>
                    <h4 class="text-center">Ups...Izgleda da nemate ni jedan proizvod u listi zelja.</h4>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <script src="../resources/js/account.js"></script>
</body>

</html>