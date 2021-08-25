<?php 
    require "../controllers/DatabaseController.php";
    require("../models/ProductModel.php");
    require("../models/SessionModel.php");
    require("../models/CheckoutModel.php");
    require("../controllers/SessionController.php");
    require "../models/UserModel.php";
// require "../controllers/DatabaseController.php";
// require "../models/ProductModel.php";
    $user_data = [];
    // var_dump(UserModel::doesExist(1,"test508","tp@101.com"));
    // var_dump(UserModel::doesExist(1, "test6", "test@6.com"));
    // var_dump(UserModel::doesExist(1, "test1", "test@1.com"));
    // var_dump(UserModel::doesExist(1, "test6", "test@4.com"));
    // var_dump(UserModel::doesExist(1, "test3", "test@4.com"));
    // var_dump(UserModel::doesExist(1, "test3", "test@3.com"));
    // var_dump(UserModel::doesExist(1, "test6", "test@4.com"));
    var_dump(UserModel::doesExist(null, "test3", "test@1.com"));



?>