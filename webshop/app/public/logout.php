<?php 
    include_once("../controllers/SessionController.php");
    $_SESSION['user'] = [];
    $_SESSION['user']['role'] = 'guest';

    header('location:../index.php');
?>