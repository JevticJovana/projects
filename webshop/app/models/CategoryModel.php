<?php 
    class CategoryModel{
        public $id;
        public $title;
        public $created_at;
        public $updated_at;

        function __construct($category_data){
            if(isset($category_data['id'])){
                $this->id = $category_data['id'];
            }
            if (isset($category_data['created_at'])) {
                $this->created_at = $category_data['created_at'];
            }
            if (isset($category_data['updated_at'])) {
                $this->updated_at = $category_data['updated_at'];
            }
            $this->title = $category_data['title'];
        }
        static function doesExist($category_id){
            require "../controllers/DatabaseController.php";

            $query = "SELECT * FROM categories WHERE id = {$category_id} LIMIT 1";
            if($database->query($query)->num_rows > 0){
                return true;
            }
            return false;
        }    
        function save(){
            require "../controllers/DatabaseController.php";
            
            $query = "INSERT INTO categories(title) VALUES({$this->title})";
            if($database->query($query) === TRUE){
                return $database->insert_id;
            }
            else return -1;
        }
        static function getAllCategories(){
            require "../controllers/DatabaseController.php";
            
            $query = "SELECT * from categories";
            $results = $database->query($query);

            $categories = [];
            while($category = $results->fetch_assoc()){
                $category_data = [];
                $category_data['id'] = $category['id'];
                $category_data['created_at'] = $category['created_at'];
                $category_data['updated_at'] = $category['updated_at'];
                $category_data['title'] = $category['title'];
                $categoryInstance = new CategoryModel($category_data);
                array_push($categories,$categoryInstance);
            }
            return $categories;
        }
        static function getCategoryTitle($cat_id){
            require "../controllers/DatabaseController.php";
            $query = "SELECT * FROM categories WHERE id = {$cat_id} LIMIT 1";
            $result = $database->query($query)->fetch_assoc();
            return $result['title'];
        }
    }
?>