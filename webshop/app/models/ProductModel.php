<?php 
    class ProductModel{
        public $id;
        public $product_name;
        public $product_description;
        public $category_id;
        public $price;
        public $stock;
        public $owner_id;
        public $images;
        public $main_image;
        public $category_title;

        function __construct($product_data){
            if(isset($product_data['id'])){
                $this->id = $product_data['id'];
            }
            $this->product_name = $product_data['product_name'];
            if(isset($product_data['product_description'])){
            $this->product_description = $product_data['product_description'];
            }
            $this->category_id = $product_data['category_id'];
            $this->price = $product_data['price'];
            $this->stock = $product_data['stock'];
            if(isset($product_data['owner_id'])){
                $this->owner_id = $product_data['owner_id'];
            }
        }
        function validateData($product_data){
            if(!isset($product_data['product_name']) || $product_data['product_name'] == null || $product_data['product_name'] == ""){
                setMessage("Naziv proizvoda ne sme biti prazan",500);
                header("location:../public/seller.php");
                return;
            }
            if (!isset($product_data['category_id']) || $product_data['category_id'] == null || $product_data['category_id'] == "") {
                setMessage("Molimo odaberite kategoriju proizvoda", 500);
                header("location:../public/seller.php");
                return;
            }
            if (!isset($product_data['price']) || $product_data['price'] == null || $product_data['price'] == "") {
                setMessage("Molimo navedite cenu proizvoda", 500);
                header("location:../public/seller.php");
                return;
            }
            if (!isset($product_data['stock']) || $product_data['stock'] == null || $product_data['stock'] == "") {
                setMessage("Molimo navedite stanje proizvoda", 500);
                header("location:../public/seller.php");
                return;
            }
        }
        function save(){
            require "../controllers/DatabaseController.php";
            require_once "../controllers/SessionController.php";
            $query = "INSERT INTO products(product_name,owner_id,category_id,price,stock,product_description) 
                      VALUES ('{$this->product_name}',{$this->owner_id},{$this->category_id},{$this->price},{$this->stock},'{$this->product_description}')";
            if($database->query($query) === TRUE){
                setMessage("Uspesno dodat proizvod u bazu podataka",200);
                $this->id =  $database->insert_id;
            }
            else{
                $this->id = -1;
                setMessage($database->error,500);
            }
            // header("location: ../public/seller.php");
        }
        function update(){
            require "../controllers/DatabaseController.php";
            
            $query = "UPDATE products SET product_name = '{$this->product_name}', category_id = '{$this->category_id}', product_description = '{$this->product_description}',price = {$this->price},stock = {$this->stock}, updated_at = CURRENT_TIMESTAMP() WHERE id = {$this->id}";
            if($database->query($query) === TRUE){
                return 1;
            }
            else{
                throw new Exception($database->error);
            }
        }
        static function getAllProducts(){
            require "../controllers/DatabaseController.php";
            require "../models/ProductImageModel.php";

            $query = "SELECT * FROM products";

            $products = [];

            $results = $database->query($query);
            while($row = $results->fetch_assoc()){
                // var_dump($row);
                $product = new ProductModel($row);
                $product->main_image = ProductImageModel::getMainImage($product->id);
                array_push($products,$product);
            }
            return $products;
        }
        static function getSearchProductsSorted($sort){
            require "../controllers/DatabaseController.php";
            // require "../models/ProductImageModel.php";

            $query = "SELECT * FROM products ORDER BY price {$sort}";

            $products = [];

            $results = $database->query($query);
            while ($row = $results->fetch_assoc()) {
                // var_dump($row);
                $product = new ProductModel($row);
                $product->main_image = ProductImageModel::getMainImage($product->id);
                array_push($products, $product);
            }
            return $products;
        }
        static function getProductsFromSeller($seller_id)
        {
            require "../controllers/DatabaseController.php";
            require "../models/ProductImageModel.php";

            $query = "SELECT * FROM products WHERE owner_id = {$seller_id}";

            $products = [];

            $results = $database->query($query);
            while ($row = $results->fetch_assoc()) {
                // var_dump($row);
                $product = new ProductModel($row);
                $product->main_image = ProductImageModel::getMainImage($product->id);
                array_push($products, $product);
            }
            return $products;
        }
        static function deleteProduct($product_id){
            require "../controllers/DatabaseController.php";

            $query = "DELETE from products WHERE id = {$product_id}";

                if($database->query($query) === TRUE){
                    return 1;
                }
                else{
                    return $database->error;
                }
        }
        static function getProductDetails($pid){
            require "../controllers/DatabaseController.php";
            $query = "SELECT * FROM products WHERE id = {$pid} LIMIT 1";
            try{
                $product = new ProductModel($database->query($query)->fetch_assoc());
                // $product->category_title = CategoryModel::getCategoryTitle($product->category_id);
                return $product;
            }
            catch(Exception $e){
                return $database->error;
            }
        }
        static function getProductDetailsFromArray($ordered_cart){
            require "../controllers/DatabaseController.php";
            $products = [];
            foreach($ordered_cart as $key=>$value){
                
                $product = ProductModel::getProductDetails($key);
                $product->cart_quantity = $value;
                array_push($products,$product);                
            }
            return $products;
        }
        static function increaseStock($product_id){
            $product = ProductModel::getProductDetails($product_id);
            $product->stock++;
            $result = $product->update();
            return $result;
        }
        static function decreaseStock($product_id){
            $product = ProductModel::getProductDetails($product_id);
            $product->stock--;
            $result = $product->update();
            return $result;
        }   
        static function getProductStock($product_id){
            // return 1;
            $product = ProductModel::getProductDetails($product_id);
            return $product->stock;
        }
        static function getFromId($product_id){
            require "../controllers/DatabaseController.php";
            // try{
                $query = "SELECT * from products WHERE id = {$product_id} LIMIT 1";
                $product = new ProductModel($database->query($query)->fetch_assoc());
                return $product;
            // }
            // catch(Exception $e){
                // return $database->error;
            // }
        }
        function checkIfReviewable(){
            require "../controllers/DatabaseController.php";
            require_once "../controllers/SessionController.php";
            $query = "SELECT checkout.processed FROM checkout INNER JOIN products on products.id = checkout.product_id WHERE checkout.processed = 1 AND checkout.product_id = {$this->id} AND checkout.profile_id = {$_SESSION['user']['uid']}";
            $results = $database->query($query);
            if($results->num_rows > 0){
                return true;
            }
            else{
                return false;
            }
        }
        static function getSearchProducts($search_text){
            require "../controllers/DatabaseController.php";

            $query = "SELECT products.* FROM products INNER JOIN categories on products.category_id = categories.id WHERE products.product_name LIKE '%{$search_text}%' OR categories.title LIKE '%{$search_text}%'";

            $results = $database->query($query);
            $products = [];
            while($row = $results->fetch_assoc()){
                $product = new ProductModel($row);
                array_push($products,$product);
            }
            return $products;
        }
    }
?>