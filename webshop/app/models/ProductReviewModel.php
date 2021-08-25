<?php 
    class ProductReviewModel{
        public $id;
        public $product_id;
        public $user_id;
        public $review;
        public $rate;
        public $created_at;
        public $updated_at;

        public function __construct($review_data){
            if(isset($review_data['id'])){
                $this->id = $review_data['id'];
            }
            if(isset($review_data['product_id'])){
                $this->product_id = $review_data['product_id'];
            }
            if(isset($review_data['user_id'])){
                $this->user_id = $review_data['user_id'];
            }
            if(isset($review_data['review'])){
                $this->review = $review_data['review'];
            }
            if(isset($review_data['rate'])){
                $this->rate = $review_data['rate'];
            }
        if (isset($review_data['created_at'])) {
            $this->created_at = $review_data['created_at'];
        }
        if (isset($review_data['updated_at'])) {
            $this->updated_at = $review_data['updated_at'];
        }    
    }
        public function save(){
            require "../controllers/DatabaseController.php";

            $query = "INSERT INTO product_reviews(product_id,user_id,rate,review) VALUES({$this->product_id},{$this->user_id},{$this->rate},'{$this->review}')";

            if($database->query($query) === TRUE){
                return $database->insert_id;
            }
            else{
                return $database->error;
            }
        }
        public function update(){
            require "../controllers/DatabaseController.php";

            $query = "UPDATE product_reviews SET rate = $this->rate, review = '{$this->review}', updated_at = CURRENT_TIMESTAMP WHERE product_id = {$this->product_id} AND user_id = {$this->user_id}";

            if($database->query($query) === TRUE){
                return 1;
            }
            else{
                return $database->error;
            }
        }
        public function doesExist(){
            require "../controllers/DatabaseController.php";

            $query = "SELECT * FROM product_reviews WHERE user_id = {$this->user_id} AND product_id = {$this->product_id}";
            $res = $database->query($query);
            if($res->num_rows > 0){
                return true;
            }
            else{
                return false;   
            }
        }
        public static function getReview($product_id, $user_id){
            require "../controllers/DatabaseController.php";

            $query = "SELECT * FROM product_reviews WHERE user_id = {$user_id} AND product_id = {$product_id} LIMIT 1";
            try{
                $review = new ProductReviewModel($database->query($query)->fetch_assoc());
                return $review;
            }
            catch(Exception $e){
                return $database->error;
            }
        }
        public static function getAllProductReviews($product_id){
            require "../controllers/DatabaseController.php";

            $query = "SELECT * FROM product_reviews WHERE product_id = {$product_id}";
            $results = $database->query($query);
            $reviews = [];
            while($row = $results->fetch_assoc()){
                $review = new ProductReviewModel($row);
                array_push($reviews, $review);
            }
            return $reviews;
        }
        public static function getAvgRate($product_id){
            require "../controllers/DatabaseController.php";

            $query = "SELECT AVG(rate) as 'rate' FROM product_reviews WHERE product_id = {$product_id}";
            $result = $database->query($query)->fetch_assoc();
            $rate = $result['rate'];
            return $rate;
        }
    }
?>