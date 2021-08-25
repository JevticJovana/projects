<?php
    $config = parse_ini_file("../../app.ini");
    $database = mysqli_connect($config['host'],$config['user'], $config['password'], $config['db_name']);
    if($database->connect_error){
        echo "Error while connecting to the database";
        die();
    }
?>