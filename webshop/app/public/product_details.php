<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalji proizvoda</title>
    <?php include "../components/bootstrap.php"; ?>

</head>

<body>
    <?php include "../components/header.php"; ?>
    <?php include "../components/message.php"; ?>
    <?php include("../controllers/MiddlewareController.php"); ?>

    <div id="alertPlaceholder"></div>
    <?php
    require "../models/ProductModel.php";
    require "../models/ProductImageModel.php";
    require "../models/ProductReviewModel.php";
    require "../models/SessionModel.php";
    require "../models/UserModel.php";

    $product_id = $_GET['product_id'];
    $product = ProductModel::getProductDetails($product_id);
    // $product->id = $product_id;
    $product->main_image = ProductImageModel::getMainImage($product->id);
    $product->images = ProductImageModel::getProductImages($product->id);
    if (SessionModel::isLoggedIn()) {
        $reviewable = $product->checkIfReviewable();
        if ($reviewable) {
            $review = ProductReviewModel::getReview($product_id, $_SESSION['user']['uid']);
            if($review->id === NULL){
                $review = NULL;
            }
        }
    }
    $reviews = ProductReviewModel::getAllProductReviews($product_id);
    ?>
    <div class="product-showcase">
        <div class="product-images">
            <div class="main-image">
                <img src="<?php echo $product->main_image; ?>" id="mainImage">
            </div>
            <div class="thumbnails">
                <?php $i = 0; foreach ($product->images as $image) : $i++;?>
                    <img class="thumbnail" src="<?php echo $image->path; ?>" id = "tb-<?php echo $i;?>" onclick = "setActive()">
                <?php endforeach ?>
            </div>
        </div>
        <div class="product-details shadow-custom">
            <span class="product-title"><?php echo $product->product_name; ?></span>
            <?php if (isset($product->product_description)) : ?>
                <span class="product-description"><?php echo $product->product_description; ?></span>
            <?php endif; ?>
            <span class="product-price"><?php echo $product->price . ".00 rsd"; ?></span>
            <span class="product-rating">
                <?php $rate = round(ProductReviewModel::getAvgRate($product->id),2); ?>
                <?php for ($i = 0; $i < $rate; $i++) : ?>
                    <i class="fas fa-star"></i>
                <?php endfor; ?>
                <?php for ($i = 0; $i < 5 - round($rate,0); $i++) : ?>
                    <i class="far fa-star"></i>
                <?php endfor; ?>
                <br>
                <small>(<?php echo $rate;?>)</small>

            </span>
        </div>
        <div class="showcase-actions shadow-custom">
            <div class="showcase-action shadow-custom border-animate-primary " onclick="addToCart(<?php echo $product->id; ?>)"><i class="fas fa-shopping-cart action-icon"></i>
                <span class="action-text">Dodaj u korpu</span>
            </div>
            <div class="showcase-action shadow-custom border-animate-warning " onclick="addToWishlist(<?php echo $product->id; ?>)"><i class="fas fa-bookmark action-icon"></i>
                <span class="action-text">Dodaj u listu zelja</span>
            </div>
        </div>
        <div class="personal-review m-5">
            <?php if (isset($_SESSION['user']['uid'])) : ?>
                <?php if ($reviewable) : ?>
                    <form class="neumorphic-form" action="../controllers/ProductReviewController.php" method="POST">
                        <div id="contact-form" class="neumorphic-form">

                            <div class="neumorphic-input-container">
                                <div class="showcase">
                                    <h3 class="rating-text mb-3">Ocena proizvoda</h3>
                                    <div class="rating-system3">
                                        <input class="rating-input" type="radio" name='rate' id="star5_3" value="5" <?php if (isset($review) && $review->rate == 5) echo 'checked'; ?> />
                                        <label class="rating-label" for="star5_3"></label>

                                        <input class="rating-input" type="radio" name='rate' id="star4_3" value="4" <?php if (isset($review) && $review->rate == 4) echo 'checked'; ?> />
                                        <label class="rating-label" for="star4_3"></label>

                                        <input class="rating-input" type="radio" name='rate' id="star3_3" value="3" <?php if (isset($review) && $review->rate == 3) echo 'checked'; ?> />
                                        <label class="rating-label" for="star3_3"></label>

                                        <input class="rating-input" type="radio" name='rate' id="star2_3" value="2" <?php if (isset($review) && $review->rate == 2) echo 'checked'; ?> />
                                        <label class="rating-label" for="star2_3"></label>

                                        <input class="rating-input" type="radio" name='rate' id="star1_3" value="1" <?php if (isset($review) && $review->rate == 1) echo 'checked'; ?> />
                                        <label class="rating-label" for="star1_3"></label>

                                        <div class="text"></div>
                                    </div>
                                </div>
                                <label class="neumorphic-label">Komentar</label><br>
                                <textarea id="fname" type="text" class="neumorphic-input" name="review" required="required"><?php if (isset($review)) echo $review->review; ?></textarea>
                                <input type="hidden" name="product_id" value="<?php echo $_GET['product_id']; ?>">
                            </div>

                            <input type="hidden" name="leave_review">
                            <button type="submit" class="neumorphic-button"><?php if (isset($review)) echo 'Azuriraj';
                                                                            else echo 'Sacuvaj'; ?></button>
                        </div>
                    </form>
                <?php else : ?>
                    <h4 class="text-center">Trenutno nije omoguceno ocenjivanje proizvoda. Kada porudzbina bude procesovana, mozete se vratiti i proizvodu dati ocenu.</h4>
                <?php endif; ?>
            <?php else : ?>
                <div class="">
                    <h4 class="text-center">Morate biti ulogovani da biste ostavili ocenu na proizvod. Ulogujte se i pokusajte ponovo.</h4>
                    <a href="./login.php" class="d-block text-center">Uloguj me.</a>
                </div>
        </div>

            <?php endif; ?>
    </div>

        <div class="product-reviews">
            <?php foreach ($reviews as $review) : ?>
                <div class="product-review shadow-custom">
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
                            <?php for ($i = 0; $i < $review->rate; $i++) : ?>
                                <i class="fas fa-star"></i>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <div class="review-comment">
                        <?php echo $review->review; ?>
                    </div>
                    <div class="review-footer">
                        <?php echo $review->updated_at; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="../resources/js/details.js"></script>
</body>

</html>