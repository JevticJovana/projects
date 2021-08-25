<?php
    require "../controllers/SessionController.php";
    require "../models/SessionModel.php";

    if(isset($_POST['add_to_cart'])){
        $status = [];
        try{        
            $product_id = $_POST['product_id'];
            $result = SessionModel::addToCart($product_id);
            if($result == 1){
                $status['status'] = "200";
                $status['message'] = "Proizvod uspesno dodat u korpu";
                $status['response'] = count($_SESSION['cart']);
            }
            else{
                $status['status'] = "500";
                $status['message'] = "Proizvod nije na stanju i stoga ne moze biti dodat u korpu";
                $status['response'] = count($_SESSION['cart']);
            }
        }
        catch(Exception $e){
            $status['status'] = "500";
            $status['message'] = "Greska prilikom dodavanja proizvoda u korpu";
            $status['response'] = count($_SESSION['cart']);
        }
        finally{
            echo json_encode($status);
        }
    }
    if(isset($_POST['remove_from_cart'])){
        $status = [];
        try{
            $product_id = $_POST['product_id'];
            SessionModel::removeFromCart($product_id);
            $status['status'] = 200;
            $status['message'] = "Proizvod uspesno uklonjen iz korpe";
            $status['response'] = count($_SESSION['cart']);
        }
        catch(Exception $e){
            $status['status'] = "500";
            $status['message'] = "Greska prilikom uklanjanja proizvoda iz korpe";
            $status['response'] = count($_SESSION['cart']);
        }
        finally{
        echo json_encode($status);
        }
    }
    if(isset($_POST['empty_cart'])){
        $status = [];
        try{
            SessionModel::emptyCart();
            $status['status'] = 200;
            $status['message'] = "Korpa je uspesno ispraznjenja";
            $status['response'] = count($_SESSION['cart']);
        }
        catch(Exception $e){
            $status['status'] = "500";
            $status['message'] = "Greska prilikom uklanjanja proizvoda iz korpe";
            $status['response'] = count($_SESSION['cart']);
        }
        finally{
            echo json_encode($status);
        }
        
    }
?>