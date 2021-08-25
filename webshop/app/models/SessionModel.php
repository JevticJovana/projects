<?php 
    class SessionModel{
        static function addToCart($product_id)
        {
            try{
                require "../models/ProductModel.php";
                $stock = ProductModel::getProductStock($product_id);
                if($stock > 0){
                    array_push($_SESSION['cart'], $product_id);
                    // ProductModel::decreaseStock($product_id);
                    return 1;
                }
                else{
                    return -1;
                }
            }
            catch(Exception $e){
                return -1;
            }
        }
        static function removeFromCart($product_id)
        {
            require "../models/ProductModel.php";
            try{
                $item_index = array_search($product_id, $_SESSION['cart']);
                unset($_SESSION['cart'][$item_index]);
                $_SESSION['cart'] = array_values($_SESSION['cart']);
                // ProductModel::increaseStock($product_id);
                return 1;
            }
            catch(Exception $e){
                return -1;
            }
        }
        static function orderCart($product_ids){
            $products = [];
            $pids = [];
            foreach($product_ids as $product_id){
                if(!array_key_exists(strval($product_id),$pids)){
                    $pids[strval($product_id)] = 1;
                }
                else{
                    $pids[strval($product_id)]++;
                }
            }
            return $pids;
        }
        static function emptyCart(){
            $_SESSION['cart'] = [];
        }
        static function getUserId(){
            // require "../controllers/SessionController.php";
            if(isset($_SESSION['user']['uid'])){
                return $_SESSION['user']['uid'];
            }
            return null;
        }
        static function isLoggedIn(){
            if(isset($_SESSION['user']['uid'])){
                return true;
            }
            return false;
        }
    }
?>