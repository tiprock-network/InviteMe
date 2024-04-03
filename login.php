<?php include './config/config.php' ?>
<?php include './config/db.php' ?>
<?php include './includes/header.php' ?>
<?php
    //get the email and pass
    if(isset($_POST['submit'])){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
           
            if(!$_POST['uemail'] ||  !$_POST['upass']){
                echo '<div class="account-msg-wrong">
                    <p>Your password or email should not be empty, kindly fill them.</p>
                </div>';
            }else{
                $uemail = $_POST['uemail'];
                $upass = $_POST['upass'];
                //get the user with this email from the database
                //create query
                $get_qry = "SELECT * FROM customerTbl WHERE customerEmail='$uemail';";
                $result = mysqli_query($conn,$get_qry);
                $customer = mysqli_fetch_assoc($result);
                
                //check if passwords match
                $options=[
                    'cost'=> 12,
                ];

               if(!$customer){
                    echo '<div class="account-msg-wrong back-red">
                        <p>A user with this email does not exist.</p>
                    </div>';

               }else{
                if(password_verify($upass,$customer['customerPassword'])){
                    
                    //start a session on successful login
                    
                    $_SESSION['name'] = $customer['customerName'];
                    $_SESSION['id'] = $customer['customerId'];
                    $_SESSION['phone'] = $customer['customerPhone'];
                    $_SESSION['area'] = $customer['customerType'];
                    $_SESSION['country'] = $customer['customerCountry'];
                    $_SESSION['login_true'] = true;
                    $_SESSION['time'] = time();

                    //redirect to the home page
                    echo '<div class="account-msg-green">
                        <p>You have successfully logged in. Kindly click the link below to go back home.</p>
                        <a href="index.php">Go to home page.</a>
                    </div>';
                    
                }else{
                    echo '<div class="account-msg-wrong">
                    <p>Your password or email is incorrect, kindly re-enter them carefully.</p>
                </div>';
                }
               }

            }
            
        }
    }
?>
   <div class="accounts-main-container">
        <div class="header-section-accounts">
            <h1>Login</h1>
        </div>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
            <div class="accounts-form-section">
                <label for="uname">Email</label>
                <br>
                <input type="email" name="uemail" placeholder="e.g. myemail@example.com">
                <div class="msg-box" id="msg-box-email">
                   
                </div>
            </div>

            <div class="accounts-form-section">
                <label for="upass">Password</label>
                <br>
                <input type="password" name="upass">
                <div class="msg-box" id="msg-box-pass">
                    
                </div>
            </div>

            <div class="accounts-form-section links-sec">
                <a href="reset_page.php" class="login-links">Forgot your password?</a>
                <br>
                <br>
                <a href="register.php" class="login-links">Or signup</a>
            </div>
            
            <div class="accounts-form-section btn-section">
                <button type="submit" name="submit">Sign in</button>
            </div>
        </form>
   </div>
