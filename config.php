<?php

    $host = "localhost";
    $user = "root";
    $password = "";
    $dbname = "storecsv";

    $connection = mysqli_connect($host, $user, $password, $dbname);    

    set_time_limit(36000);

    if(!$connection){
        die('Connection failed :' .mysqli_connect_error());
    }
?>