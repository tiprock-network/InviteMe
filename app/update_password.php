<?php
    require('../config/db.php');
    if(isset($_POST['submit']))
    {
        $email=$_POST['uemail'];
        $pass=password_hash($_POST['upass'],PASSWORD_BCRYPT);
        $query="UPDATE customerTbl SET customerPassword='$pass' WHERE customerEmail='$email'";
        mysqli_query($conn,$query);
        header("Location: ../login.php");
        exit();
    }
    
?>