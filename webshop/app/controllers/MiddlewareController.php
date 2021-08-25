<?php 
    include_once("../controllers/SessionController.php");
    $uri = $_SERVER['REQUEST_URI'];
    $user = $_SESSION['user'];
    // var_dump($uri);
    // var_dump($user);
    // return;

    //check if user is allowed on admin page
    if(str_contains($uri,'admin') && $user['role'] != "admin"){
        setMessage('Nazalost, nemate pristup administracionom delu. Proverite vase podatke za logovanje i pokusajte ponovo.', 500);
        header("location: ../index.php");
    }
    //check if user is allowed on account page
    if(str_contains($uri,'account') && $user['role'] != 'buyer'){
        setMessage('Nazalost, nemate pristup delu za personalizaciju naloga. Proverite vase podatke za logovanje i pokusajte ponovo.',500);
        header("location:../index.php");
    }
    //check if user is allowed on seller page
    if(str_contains($uri,'seller') && $user['role'] != 'seller'){
        setMessage('Nazalost, nemate pristup prodavackom delu. Proverite vase podatke za logovanje i pokusajte ponovo.',500);
        header("location:../index.php");
    }
    if(str_contains($uri,'checkout') && $user['role'] == 'guest'){
    setMessage('Nazalost, nemate pristup placanju. Ulogujte se i pokusajte ponovo.',500);
    header("location:../index.php");
    }

?>