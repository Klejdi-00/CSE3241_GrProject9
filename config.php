<?php
    /* Connect to MySQLi database */
    $connect = mysqli_connect('localhost', 'root', 'mysql', 'parkingmaster');
    
    /* Check for error */
    if($connect == false){
        die("ERROR: Could not connect to mysql.");
    }
?>