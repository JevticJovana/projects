<?php
    require './DatabaseController.php';
    require "../models/CategoryModel.php";
    if(isset($_GET['get_categories'])){
        try{
            $categories = CategoryModel::getAllCategories();
                $status['status'] = 200;
                $status['message'] = "All ok";
                $status['response'] = $categories;
                echo json_encode($status);
        }
        catch(Exception $e){
            $status['status'] = 500;
            $status['message'] = "Greska prilikom prikupljanja kategorija";
        }
    }

?>