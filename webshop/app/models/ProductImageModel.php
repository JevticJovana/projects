<?php
class ProductImageModel{
    public $id;
    public $product_id;
    public $path;
    public $temp_path;
    function __construct($image_data){
        $this->product_id = $image_data['product_id'];
        $this->path = $image_data['path'];
        if(isset($image_data['temp_path'])){
            $this->temp_path = $image_data['temp_path'];
        }
    }
    function validateData(){
        require "../controllers/SessionController.php";
        if(!isset($this->product_id) || $this->product_id == ""){
            // setMessage("Doslo je do greske prilikom validacije slike", 500);            
            header("location: ../public/seller.php");
            return;
        }
        if (!isset($this->path) || $this->path == "") {
            // setMessage("Doslo je do greske prilikom validacije putanje slike proizvoda", 500);
            header("location: ../public/seller.php");
            return;
        }
    }
    function save(){
        require "../controllers/DatabaseController.php";

        $query = "INSERT INTO product_images(product_id,path) VALUES({$this->product_id},'{$this->path}')";
        if($database->query($query) === TRUE){
            try{
                move_uploaded_file($this->temp_path,$this->path);
                return true;
            }
            catch(Exception $e){
                echo $database->error;
                return false;
            }
        }
        else{
            echo $database->error;
            return false;
        }
    }
    static function getProductImages($product_id){
        require "../controllers/DatabaseController.php";

        $query = "SELECT * FROM product_images WHERE product_id = {$product_id}";

        $results = $database->query($query);
        $product_images = [];
        while($row = $results->fetch_assoc()){
            $productImageModelInstance = new ProductImageModel($row);
            array_push($product_images, $productImageModelInstance);
        }
        return $product_images;
    }
    static function getMainImage($product_id){
        require "../controllers/DatabaseController.php";

        $query = "SELECT * FROM product_images WHERE product_id = {$product_id} LIMIT 1";

        $image = $database->query($query)->fetch_assoc()['path'];
        return $image;
    }
}

?>