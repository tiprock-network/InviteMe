<?php include './config/config.php' ?>
<?php include './config/db.php' ?>
<?php include './includes/header.php' ?>
<?php
    //redirect back to login.php if there are no parameters
    if(isset($_GET['key']) && isset($_GET['reset'])){
        $email=$_GET['key'];
        $password=$_GET['reset'];

        //time
        $timestamp=time();
        $timestamp_value=intval(date('YmdHis',$timestamp));
        

        //query
        $query="SELECT customerEmail,customerPassword FROM customerTbl WHERE customerPassword='$password' AND CAST(resetExpiration AS UNSIGNED)>='$timestamp_value'";
        $res=mysqli_query($conn,$query);
        //collect rows
        if(mysqli_num_rows($res)==1){
    
    ?>

   <div class="accounts-main-container">
        <div class="header-section-accounts">
            <h1>Change Password</h1>
        </div>

        <form action="./app/update_password.php" method="POST">
            <div class="accounts-form-section">
                <label for="uname">Confirm Email</label>
                <br>
                <input type="email" name="uemail" placeholder="e.g. myemail@example.com">
                <div class="msg-box" id="msg-box-email">
                    <p class="success"><i class="fa fa-circle-check"></i> Email is valid.</p>
                </div>
            </div>

            <div class="accounts-form-section">
                <label for="uname">New Password</label>
                <br>
                <input type="password" name="upass">
                <div class="msg-box" id="msg-box-email">
                    <p class="success"><i class="fa fa-circle-check"></i> Email is valid.</p>
                </div>
            </div>

            
            <div class="accounts-form-section btn-section">
                <button type="submit" name="submit">Change Password</button>
            </div>
        </form>
   </div>
   <?php

        }else{
        echo '
        <div class="main-container border-line" style="border: none; margin-top: 5%;">
        <div class="field info">
            <center><p style="color:rgb(211, 37, 37); font-size: 30px"><b>Oops...something has failed</b></p></center>
            <center><p style="color:rgb(211, 37, 37);"> Your reset link has expired. Kindly go back and send another email.</p></center>
                <div class="container-image">
                    <img src="../static/pics/cry.gif">
                </div>
            
        </div>
        </div>
        ';
    }
    }else{
        //redirect
        header('Location: login.php');
        echo '<script>
        window.location.href = \'http://localhost/inviteme/login.php\';
        </script>';
    }
?>
<?php include './includes/footer.php'; ?>