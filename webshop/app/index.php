<?php
    include("./controllers/DatabaseController.php");
    include("./controllers/SessionController.php");
    if(!isset($_SESSION['user'])){
        $_SESSION['user']['uid'] = null;
        $_SESSION['user']['username'] = null;
        $_SESSION['user']['role'] = "guest";
    }
    $_SESSION['cart'] = [];
    header("location: ../app/public/home.php");
?>