<?php 
    require "../controllers/DatabaseController.php";
    require "../controllers/SessionController.php";
    require "../models/ProductModel.php";
    require "../models/ProductImageModel.php";
    if(isset($_POST['add_product'])){
        if($_SESSION['user']['role'] != 'seller'){
            setMessage("Nije vam dozvoljeno dodavanje proizvoda ukoliko niste prodavac",500);
            header("location:../public/home.php");
        }
        else{
            $product_data = [];
            $product_data['product_name'] = $_POST['product_name'];
            $product_data['owner_id'] = $_SESSION['user']['uid'];
            $product_data['category_id'] = $_POST['category'];
            $product_data['price'] = $_POST['price'];
            $product_data['stock'] = $_POST['stock'];
            $product_data['product_description'] = $_POST['product_description'];

            $productModelInstance = new ProductModel($product_data);
            $productModelInstance->validateData($product_data);
            // var_dump($_POST);
            $productModelInstance->save();
            if($productModelInstance->id == -1){
                // setMessage("Doslo je do greske prilikom dodavanja proizvoda u bazu.",500);
                header("location: ../public/seller.php");
                return;
            }
            $fileCount = count($_FILES['product_images']['name']);
            for($i = 0; $i < $fileCount; $i++){
                $product_image_data['product_id'] = $productModelInstance->id;
                $product_image_data['temp_path'] = $_FILES['product_images']['tmp_name'][$i];
                $product_image_data['path'] = "../resources/product_images/". $_FILES['product_images']['name'][$i];
                $productImageModelInstance = new ProductImageModel($product_image_data);
                // $productImageModelInstance->validateData();
                $result = $productImageModelInstance->save();
                if($result != 1){
                    setMessage("Doslo je do greske prilikom dodavanja fotografija proizvoda u bazu podataka.",500);
                    header( "location:../public/seller.php");
                    return;
                }                
            }
            setMessage("Uspesno dodavanje proizvoda",200);
            header("location:../public/seller.php");
        }
        
    }
    if (isset($_POST['delete_product'])) {
        $product_id = $_POST['product_id'];
        // echo 'here';
        try{
            $delete_res = ProductModel::deleteProduct($product_id);
            $status['status'] = 200;
            $status['message'] = "Uspesno uklanjanje proizvoda iz baze podataka";
        }
        catch(Exception $e){
            $status['status'] = 500;
            $status['message'] = "Doslo je do greske prilikom uklanjanja proizvoda iz baze podataka.";
        }
        finally{
            echo json_encode($status);
        }
    }
    if(isset($_POST['find_product'])){
        $product_id = $_POST['product_id'];
        $product = ProductModel::getFromId($product_id);
        $status['status'] = 200;
        $status['message'] = "Proizvod pronadjen";
        $status['response'] = $product;
        echo json_encode($status);
    } 
    if(isset($_POST['edit_product'])){
        $product = new ProductModel($_POST);
        // var_dump($product);
        // return;
        $status = [];
        try{
            $product->update();
            $status['status'] = 200;
            $status['message'] = "Uspesna izmena proizvoda";
        }
        catch(Exception $e){
            $status['status'] = 500;
            $status['message'] = $e->getMessage();
        }
        finally{
            echo json_encode($status);
        }
    }


?>