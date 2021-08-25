<?php 
    class WishlistModel{
        public $id;
        public $user_id;
        public $product_id;
        public $created_at;
        public $updated_at;

        public function __construct($wld){
            if(isset($wld['id'])){
                $this->id = $wld['id'];
            }
            $this->user_id = $wld['user_id'];
            $this->product_id = $wld['product_id'];

        }
        public function save(){
            require "../controllers/DatabaseController.php";

            $query = "INSERT INTO wishlist(user_id,product_id) VALUES({$this->user_id},{$this->product_id})";
            // return $query;
            if($database->query($query) === TRUE){
                return $database->insert_id;
            }
            else{
                return -1;
            }
        }
        public function delete(){
            require "../controllers/DatabaseController.php";

            $query = "DELETE FROM wishlist WHERE user_id = {$this->user_id} AND product_id = {$this->product_id}";
            if($database->query($query) === TRUE){
                return 1;
            }
            else{
                return 1;
            }
        }
        public static function getUserWishlist($user_id){
            require "../controllers/DatabaseController.php";
            // require_once "./ProductModel.php";
            // require_once "./ProductImageModel.php";
            
            $query = "SELECT * FROM wishlist WHERE user_id = {$user_id}";
            $results = $database->query($query);
            $wishlistItems = [];
            while($row = $results->fetch_assoc()){
                $wishlistItem = new WishlistModel($row);
                $product = ProductModel::getFromId($wishlistItem->product_id);
                $product->main_image = ProductImageModel::getMainImage($wishlistItem->product_id);
                array_push($wishlistItems,$product);
            }
            return $wishlistItems;
        }
        public static function doesExist($wishlistItem){
            require "../controllers/DatabaseController.php";

            $query = "SELECT * FROM wishlist WHERE user_id = {$wishlistItem->user_id} AND product_id = {$wishlistItem->product_id}";

            if($database->query($query)->num_rows > 0){
                return true;
            }
            return false;
        }
    }
?>