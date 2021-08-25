<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prodavac</title>
    <?php include("../components/bootstrap.php"); ?>
    <?php include("../controllers/MiddlewareController.php"); ?>
</head>

<body>
    <?php include("../components/header.php"); ?>
    <?php include("../components/message.php"); ?>
    <?php include("../controllers/MiddlewareController.php"); ?>
    <?php
    require "../models/ProductModel.php";
    require "../models/CategoryModel.php";

    require "../models/CheckoutModel.php";
    // require "../models/ProductModel.php";
    // require "../models/ProductImageModel.php";
    require "../models/ProductReviewModel.php";
    require "../models/ShippingProfileModel.php";
    require "../models/SessionModel.php";
    require "../models/WishlistModel.php";
    require "../models/UserModel.php";
    $checkouts = CheckoutModel::getSellerOrders($_SESSION['user']['uid']);
    ?>
    <div id="alertPlaceholder"></div>
    <div class="container mt-5">
        <h1 class="text-center">Pocetna</h1>
    </div>
    <div class="quick-actions">
        <div class="action shadow-custom" onclick="display('order-view')">
            <div class="icon">
                <i class="fas fa-list"></i>
            </div>
            <div class="action-text">
                Pregled porudzbina
            </div>
        </div>
        <div class="action shadow-custom" onclick="display('product-view')">
            <div class=" icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="action-text">
                Pregled proizvoda
            </div>
        </div>

    </div>
    <div id="order-view">
        <div class="container mt-5">
            <h3 class="text-center">Pregled porudzbina</h3>
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
                            <?php if ($orderStatus == 0) : ?>
                                <div class=" product-action border-animate-primary" onclick="processOrder('<?php echo $ref_no; ?>')">
                                    <i class="fas fa-check"></i>
                                    <span class="action-text">Odobri porudzbinu</span>
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
                                    ?>
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
    <div id="product-view">
        <div class="quick-actions mt-3">
            <div class="action shadow-custom" id="addProductAction" data-toggle="modal" data-target="#addProduct">
                Dodaj proizvod
            </div>
            <!-- <div class="action" id = "produc">
            Pregled proizvoda
        </div> -->

        </div>
        <div class="container mt-5">
            <h3 class="text-center">Pregled proizvoda</h3>
            <?php
            $products = ProductModel::getProductsFromSeller($_SESSION['user']['uid']);
            ?>
            <div class="products-container">
                <?php foreach ($products as $product) : ?>
                    <div class="seller product shadow-custom">
                        <div class="product-image">
                            <img src="<?php echo $product->main_image; ?>">
                        </div>
                        <div class="product-info">
                            <div class="product-title">
                                <span><?php echo $product->id; ?></span>
                                <span><?php echo $product->product_name; ?></span>
                            </div>
                            <div class="product-details">
                                <div class="product-data">
                                    <span class="product-stock">Stanje: <?php echo $product->stock; ?></span>
                                    <span class="product-price">Cena: <?php echo $product->price; ?></span>
                                    <span class="product-orders">Broj porudzbina: <?php echo CheckoutModel::getNumberOfOrders($product->id); ?></span>
                                </div>
                                <div class="product-actions">
                                    <div class="product-action shadow-custom border-animate-warning" data-toggle="modal" data-target="#editModal" onclick="getProductDetails(<?php echo $product->id; ?>)"><i class="fas fa-edit  action-icon"></i>
                                        <span class="action-text">Izmeni proizvod</span>
                                    </div>
                                    <div class="product-action shadow-custom border-animate-danger" data-toggle="modal" data-target="#deleteConfirm" onclick="prepareDelete(<?php echo $product->id; ?>)"><i class="fas fa-trash  action-icon"></i>
                                        <span class="action-text">Ukloni proizvod</span>
                                    </div>
                                    <div class="product-action shadow-custom border-animate-primary" onclick="displayReviews()">
                                        <i class="fas fa-eye  action-icon"></i>
                                        <span class="action-text">Prikazi recenzije proizvoda</span>
                                    </div>
                                </div>
                            </div>

                            <div class="product-reviews">
                                <?php $reviews = ProductReviewModel::getAllProductReviews($product->id); ?>
                                <?php foreach ($reviews as $review) : ?>
                                    <div class="product-review shadow-custom mt-3 p-3">
                                        <div class="review-header">
                                            <div class="user-info">
                                                <div class="user-avatar">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div class="username">
                                                    <?php
                                                    $username = UserModel::getUsername($review->user_id);
                                                    echo $username;
                                                    ?>

                                                </div>

                                            </div>
                                            <div class="product-rate">
                                                <?php echo $review->rate; ?> / 5;
                                            </div>
                                        </div>
                                        <div class="review-comment lead">
                                            <?php echo $review->review; ?>
                                        </div>
                                        <div class="review-footer">
                                            <?php echo $review->updated_at; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content bg-default px-5 py-3 br-2">
                <div class="modal-header">
                    <h5 class="modal-title">Potvrda uklanjanja</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid text-center">
                        Uklanjanjem proizvoda iz baze podataka brisu se svi tragovi postojanja proizvoda u prodavnici, ukljucujuci statistiku prodaje. <br>
                        Nastavi dalje?
                    </div>
                    <input type="hidden" id="delete_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="neumorphic-button px-5 py-3 border-animate-warning" data-dismiss="modal">Otkazi</button>
                    <button type="button" class="neumorphic-button px-5 py-3 border-animate-danger" onclick="confirmDelete()">Nastavi</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content bg-default px-5 py-3 br-2">
                <div class="modal-header">
                    <h5 class="modal-title">Izmena proizvoda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <div class="neumorphic-form">
                        <div id="alert-placeholder"></div>
                        <div class="neumorphic-input-container">
                            <input class="neumorphic-input" required="required" type="text" class="form-control" name="product_name" id="edit_product_name" aria-describedby="helpId" placeholder="">
                            <label class="neumorphic-label" for="edit_product_name">Naziv proizvoda</label>
                        </div>
                        <div class="neumorphic-input-container">
                            <select class="neumorphic-input" required="required" id="edit_category">
                                <?php
                                $categories = CategoryModel::getAllCategories();
                                ?>
                                <?php foreach ($categories as $category) : ?>
                                    <option value=<?php echo $category->id; ?>><?php echo $category->title; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label class="neumorphic-label" for="edit_category">Kategorija</label>
                        </div>
                        <div class="neumorphic-input-container">
                            <input class="neumorphic-input" required="required" type="text" class="form-control" name="edit_product_stock" id="edit_product_stock" aria-describedby="helpId" placeholder="">
                            <label class="neumorphic-label" for="edit_product_stock">Stanje</label>
                        </div>
                        <div class="neumorphic-input-container">
                            <input class="neumorphic-input" required="required" type="text" class="form-control" name="edit_product_price" id="edit_product_price" aria-describedby="helpId" placeholder="">
                            <label class="neumorphic-label" for="edit_product_price">Cena</label>
                        </div>
                        <div class="neumorphic-input-container my-1">
                            <textarea class="neumorphic-input p-3" required="required" name="product_description" id="edit_description"></textarea>
                            <label class="neumorphic-label" for="edit_description">Opis</label>
                        </div>
                    </div>
                    <input type="hidden" id="edit_product_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="neumorphic-button px-5 py-3 mr-5 border-animate-warning" data-dismiss="modal">Otkazi</button>
                    <button type="button" class="neumorphic-button px-5 py-3 ml-5 border-animate-danger" onclick="editSubmit()">Potvrdi</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="addProduct" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content  bg-default px-5 py-3 br-2">
                <div class="modal-header">
                    <h5 class="modal-title">Dodavanje proizvoda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="neumorphic-form" method="POST" action="../controllers/ProductController.php" enctype="multipart/form-data">
                        <div class="neumorphic-input-container my-2">
                            <input class="neumorphic-input p-3" required="required" type="text" name="product_name" id="product_name" class="form-control" placeholder="">
                            <label class="neumorphic-label" for="offerName">Naziv proizvoda</label>
                        </div>
                        <div class="neumorphic-input-container my-1">
                            <select class="neumorphic-input p-3" type="text" name="category" id="category" required="required" placeholder=""></select>
                            <label class="neumorphic-label" for="category">Kategorija</label>
                        </div>
                        <div class="neumorphic-input-container my-1">
                            <input class="neumorphic-input p-3" required="required" type="number" id="price" name="price" class="form-control" placeholder="">
                            <label class="neumorphic-label" for="price">Cena</label>
                        </div>
                        <div class="neumorphic-input-container my-1">
                            <input class="neumorphic-input p-3" required="required" type="number" id="stock" name="stock" class="form-control">
                            <label class="neumorphic-label" for="stock">Stanje</label>
                        </div>
                        <div class="neumorphic-input-container my-1">
                            <textarea class="neumorphic-input p-3" required="required" name="product_description" id="description"></textarea>
                            <label class="neumorphic-label" for="description">Opis</label>
                        </div>
                        <div id="imageInputs">
                            <div class="image-input m-1">
                                <input class="d-none finput" onchange="changeFileLabel()" required="required" type="file" name="product_images[]" id="image-input-1" accept="image/png, image/gif, image/jpeg, image/webp" aria-describedby="inputGroupFileAddon01">
                                <label class="neumorphic-file-label" for="image-input-1">Odaberi sliku</label>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary" id="addImage">Dodaj jos slika</button>
                        <input type="hidden" name="add_product" value=1>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Dodaj proizvod</button>
                </div>
                </form>
            </div>
        </div>

    </div>

    <script src="../resources/js/seller.js"></script>

</body>

</html>