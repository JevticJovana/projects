<?php 
    require "../controllers/SessionController.php";
    require "../models/ShippingProfileModel.php";
    require "../models/CheckoutModel.php";
    require "../models/ProductModel.php";
    require "../models/SessionModel.php";
    if(isset($_POST['proceed_checkout'])){
        $cart = $_SESSION['ordered_cart'];
        $profile_data['ref_no'] = uniqid();
        $profile_data['user_id'] = $_SESSION['user']['uid'];
        $profile_data['first_name'] = $_POST['first_name'];
        $profile_data['last_name']= $_POST['last_name'];
        $profile_data['address']= $_POST['address'];
        $profile_data['zip_code']= $_POST['zip_code'];
        $profile_data['city']= $_POST['city'];
        $profile_data['country']= $_POST['country'];
        $payment= $_POST['payment'];
        $profileModelInstance = new ShippingProfileModel($profile_data);

        if(ShippingProfileModel::exists($profileModelInstance->user_id) === TRUE){
        // echo "update";

            $profile_id = $profileModelInstance->update();
            // var_dump($profile_id);
        }
        else{
        echo "save";

            $profile_id = $profileModelInstance->save();
        }

        if($payment == 1){
            $card_name= $_POST['card_name'];
            $card_expire= $_POST['card_expire'];
            $cvc_code= $_POST['cvc_code'];
        }
        
        foreach($cart as $key=>$value){
            // break;
            $stock = ProductModel::getProductStock($key);
            // var_dump($stock);
            if($stock > 0 && $stock > $cart['key']){
                $checkoutData['ref_no'] = $profile_data['ref_no'];
                $checkoutData['profile_id'] = $profile_id;
                $checkoutData['product_id'] = $key;
                $checkoutData['quantity'] = $cart[$key];
                $checkoutData['payment'] = $payment;
                $checkoutData['processed'] = 0;
                $checkoutModel = new CheckoutModel($checkoutData);
                $res = $checkoutModel->save();
                echo $res;
                echo '<br>';
                if($res > 0){
                    ProductModel::decreaseStock($key);
                }
            }
        }
        SessionModel::emptyCart();
        setMessage("Uspesno kreiranje porudzbine.",200);
        header("location:../public/home.php");
        return;
    }
    if(isset($_POST['cancel_order'])){
        $ref_no = $_POST['ref_no'];
        $status = [];
        try{
            $result = CheckoutModel::deleteCheckouts($ref_no);
            // echo $result;
            $status['status'] = 200;
            $status['message'] = "Uspesno otkazana porudzbina";
        }
        catch(Exception $e){
            $status['status'] = 500;
            $status['message'] = "Greska pri otkazivanju porudzbine";
        }
        finally{
            echo json_encode($status);
        }
    }
    if(isset($_POST['allow_order'])){
        $ref_no = $_POST['ref_no'];
        $status = [];
        try {
            $result = CheckoutModel::allowOrder($ref_no);
            // echo $result;
            $status['status'] = 200;
            $status['message'] = "Uspesno odobrena porudzbina";
        } catch (Exception $e) {
            $status['status'] = 500;
            $status['message'] = $e->getMessage();
        } finally {
            echo json_encode($status);
        }
    }
    if (isset($_POST['disable_order'])) {
        $ref_no = $_POST['ref_no'];
        $status = [];
        try {
            $result = CheckoutModel::disableOrder($ref_no);
            // echo $result;
            $status['status'] = 200;
            $status['message'] = "Uspesno otkazana porudzbina";
        } catch (Exception $e) {
            $status['status'] = 500;
            $status['message'] = "Greska pri otkazivanju porudzbine";
        } finally {
            echo json_encode($status);
        }
    }
?>