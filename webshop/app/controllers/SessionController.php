<?php 
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
    // var_dump($_SESSION);
    function setMessage($message,$status){
        $_SESSION['message']['text'] = $message;
        $_SESSION['message']['status'] = $status;
    }

?>