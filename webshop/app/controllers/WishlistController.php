<?php
    require "../controllers/DatabaseController.php";
    require "../models/WishlistModel.php";
    require "../models/SessionModel.php";
    require "../controllers/SessionController.php";
    
    if(isset($_POST['add_to_wishlist'])){
        $product_id = $_POST['product_id'];
        $status = [];
        try{
            $user_id = SessionModel::getUserId();
            if($user_id == NULL){
                throw new Exception("Morate biti ulogovani kako biste dodali proizvod u listu zelja");
            }
            $wishlist_data['user_id'] = $user_id;
            $wishlist_data['product_id'] = $product_id;
            $wishlistModel = new WishlistModel($wishlist_data);
            // var_dump($wishlistModel);
            if(!WishlistModel::doesExist($wishlistModel)){
                $res = $wishlistModel->save();
                // echo $res;
                $status['status'] = 200;
                $status['message'] = "Uspesno dodat proizvod u listu zelja";
            }
            else{
                throw new Exception("Proizvod vec postoji u listi zelja");
            }
        }
        catch(Exception $e){
            $status['status'] = 500;
            if($e->getMessage() == NULL || $e->getMessage() == "")
                $status['message'] = "Doslo je do greske prilikom dodavanja proizvoda u listu zelja";
            else{
                $status['message'] = $e->getMessage();
            }    
        }
        finally{
            echo json_encode($status);
        }
    }
    if(isset($_POST['remove_from_wishlist'])){
        $product_id = $_POST['product_id'];
        $status = [];
        try {
            $user_id = SessionModel::getUserId();
            $wishlist_data['user_id'] = $user_id;
            $wishlist_data['product_id'] = $product_id;
            $wishlistModel = new WishlistModel($wishlist_data);
            $wishlistModel->delete();
            $status['status'] = 200;
            $status['message'] = "Uspesno uklonjen proizvod iz listu zelja";
        } catch (Exception $e) {
            $status['status'] = 500;
            $status['message'] = "Doslo je do greske prilikom uklanjanja proizvoda iz liste zelja";
        } finally {
            echo json_encode($status);
        }
    }

?>