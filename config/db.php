<?php
    $host = "localhost";
    $user = "root";
    $pass = "southACT41#8$";
    $db_name = "inviteme";

    $conn = mysqli_connect($host,$user,$pass,$db_name);

    if(!$conn){
        echo "Connection to the Database Failed.";
        //exit(1);
    }

    
?>