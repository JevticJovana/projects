<?php
    class CheckoutModel{
        public $id;
        public $ref_no;
        public $profile_id;
        public $product_id;
        public $quantity;
        public $payment;
        public $processed;       
        public $created_at;
        public $updated_at;

        public function __construct($checkout_data){
            $this->product_id = $checkout_data['product_id'];
            $this->ref_no = $checkout_data['ref_no'];
            $this->profile_id = $checkout_data['profile_id'];
            $this->quantity = $checkout_data['quantity'];
            $this->payment = $checkout_data['payment'];
            $this->processed = 0;
        }
        public function save(){
            require "../controllers/DatabaseController.php";

            $query = "INSERT INTO checkout(ref_no,profile_id,product_id,quantity,payment) VALUES ('{$this->ref_no}',{$this->profile_id},{$this->product_id},{$this->quantity},{$this->payment})";
            if($database->query($query) === TRUE){
                return $database->insert_id;
            }
            else{
                return $database->error;
            }
        }
        public static function getCustomerOrders($user_id){
            require "../controllers/DatabaseController.php";
            // require "../models/ProductModel.php";
            // require "../models/ProductImageModel.php";
            // require "../models/CategoryModel.php";
            
            $query = "SELECT checkout.* FROM checkout INNER JOIN shipping_profiles on checkout.profile_id = shipping_profiles.user_id WHERE shipping_profiles.user_id = {$user_id}";
            $results = $database->query($query);
            $checkoutModels = [];
            while($row = $results->fetch_assoc()){
                $cModel = new CheckoutModel($row);
                if(array_key_exists($cModel->ref_no, $checkoutModels)){
                    array_push($checkoutModels[$cModel->ref_no],$cModel);
                }
                else{
                    $checkoutModels[$cModel->ref_no][] = $cModel;
                }
            }
            return $checkoutModels;
        }
        public static function getCheckoutStatus($ref_no){
            require "../controllers/DatabaseController.php";

            $query = "SELECT processed FROM checkout WHERE ref_no = '{$ref_no}'";
            $rows = $database->query($query);

            while($row = $rows->fetch_assoc()){
                if($row['processed'] == 0){
                    return 0;
                }
            }
            return 1;
        }
        public static function getProductsFromOrder($ref_no){
            require "../controllers/DatabaseController.php";

            $query = "SELECT * FROM checkout WHERE ref_no = '{$ref_no}'";

            $result = $database->query($query);
            $checkout_products = [];
            while($row = $result->fetch_assoc()){
                $checkoutProduct = new CheckoutModel($row);
                array_push($checkout_products,$checkoutProduct);
            }
            return $checkout_products;
        }
        public static function deleteCheckouts($ref_no){
            require "../controllers/DatabaseController.php";
            // require "../models/ProductModel.php";
            $query = "DELETE FROM checkout WHERE ref_no = '{$ref_no}'";
            $checkout_products = CheckoutModel::getProductsFromOrder($ref_no);
            foreach($checkout_products as $checkout_product){
                $productModelInstance = ProductModel::getFromId($checkout_product->product_id);
                $productModelInstance->stock+= $checkout_product->quantity;
                $productModelInstance->update();
            }
            if($database->query($query) === TRUE){
                return 1;
            }
            else{
                // return $database->error;
                throw new Exception($database->error);
            }
        }
        public static function getSellerOrders($seller_id){
            require "../controllers/DatabaseController.php";

            $query = "SELECT checkout.* FROM checkout INNER JOIN products on products.id = checkout.product_id WHERE products.owner_id = {$seller_id}";
            $orders = [];
            $results = $database->query($query);
            while($row = $results->fetch_assoc()){
                $checkoutModel = new CheckoutModel($row);
                $orders[$checkoutModel->ref_no][] = $checkoutModel;
            }
            return $orders;
        }
        public static function getNumberOfOrders($product_id){
            require "../controllers/DatabaseController.php";

            $query = "SELECT SUM(quantity) as 'count' FROM checkout WHERE product_id = {$product_id}";
            $res = $database->query($query)->fetch_assoc();

            return $res['count'];
        }
        public static function allowOrder($ref_no){
            require "../controllers/DatabaseController.php";

            $query = "UPDATE checkout SET processed = 1 WHERE ref_no = '{$ref_no}'";
            if($database->query($query) === TRUE){
                return 1;
            }
            else{
                throw new Exception($database->error);
                return -1;
            }
        }
        public static function disableOrder($ref_no){
            require "../controllers/DatabaseController.php";

            $query = "UPDATE checkout SET processed = 0 WHERE ref_no = '{$ref_no}'";
            if ($database->query($query) === TRUE) {
                return 1;
            } else {
                throw new Exception($database->error);
                return -1;
            }
        }
    }
?>