<?php include '../config/db.php' ?>
<?php
    //import php mailer
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    if(isset($_POST['submit'])){
        //get userpassword and email while checking if it exists
        //check if the email box was filled
        if(isset($_POST['uemail'])){
            //sql query
            $sql_query = "SELECT customerEmail,customerPassword,customerName FROM customerTbl WHERE customerEmail='".$_POST['uemail']."';";
            $result = mysqli_query($conn,$sql_query);
            //check if only one result is being returned
            if(mysqli_num_rows($result)==1){
                $user = mysqli_fetch_assoc($result);
                //hash the password
                $encrypted_pass = $user['customerPassword'];
                $hashed_email = password_hash($user['customerEmail'],PASSWORD_BCRYPT);

                //create the password reset link
                //reset token
                $time_stamp= time()+600; //expires in 10 minutes
                $time_stampVal = date('Y-m-d H:i:s',$time_stamp);
                //store the timestamp
                $update_query = "UPDATE customerTbl SET resetExpiration='$time_stampVal' WHERE customerEmail='".$_POST['uemail']."';";
                //update the resetExpiration attribute
                mysqli_query($conn,$update_query);

                //create the reset link
                $reset_link = 'http://localhost/inviteme/update_pass.php?key='.$hashed_email.'&reset='.$encrypted_pass.'';
                
                //create the email
                require('../vendor/autoload.php');
                $mail = new PHPMailer(true);

                //try catch for the email
                //try sending email
            try{
                $mail->isSMTP();
                $mail->Host = "smtp.gmail.com";//smtp.gmail.com
                $mail->SMTPAuth = true;
                $mail->Username = 'theophiluslowiti@gmail.com'; // SMTP username
                $mail->Password = 'pdeabxhddsbejxgc'; // gmail App password
                $mail->SMTPSecure = "ssl"; 
                $mail->Port =465 ; // Set the SMTP port
                // Sender and recipient
                $mail->setFrom('theophiluslowiti@inviteme.com', 'Invite Me'); // Set the sender's email address and name
                $mail->addAddress($user['customerEmail'], $user['customerName']); // Set the recipient's email address and name

                // Email content
                $mail->isHTML(true);
                $mail->addEmbeddedImage('../images/events.png','image1');
                $mail->addEmbeddedImage('../images/inviteme2.png','image2');
                $mail->Subject = 'Password Reset Link';
                $mail->Body = '
                <html>
                    <head>
                        <style>
                            @import url(\'https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Moirai+One&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,500;1,600;1,700;1,800;1,900&family=Pacifico&display=swap\');
                            *{
                                margin: 0;
                            }
                            body{
                                font-family: "Montserrat", sans-serif;
                                font-size: 14px;
                                font-weight: 700px;
                            }
                            .outer-div {
                                background-image: url(\'cid:image1\');
                                background-size: cover;
                                padding: 30px;
                                height: 500px;
                                width: 90%;
                                transform: translateX(30%);
                                color: #fff;
                                position: relative; /* Required for absolute positioning */
                            }
                            .inner-div {
                                background-color: rgba(255, 255, 255, 0.8); /* White background with transparency */
                                color: #444;
                                width: 80%;
                                height: 450px;
                                font-size: 16px;
                                transform: translateX(20%);
                                padding: 20px;
                            }
                            h2{
                                color:#444;
                            }
                            p{
                                color:#444;
                            }
                            .logo-div{
                                height: 80px;
                                width: 100%;
                            }
                            .logo-div>img{
                                height: 60px;
                                width: 64px;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="outer-div">
                            <div class="inner-div">
                                <div class="logo-div">
                                    <img src="cid:image2">
                                </div>
                                <h2>Invite Me</h2>
                                <p>You can now reset your password using the link below:</p>
                                <br>
                                
                                <p>Reset link: <a href="'.$reset_link.'" style="color: #444;">'.$reset_link.'</a></p>
                            </div>
                        </div>
                    </body>
                    </html>
                ';

                //TODO: FORMAT THE CONFIRMATION AND ERROR MESSAGES

                if($mail->Send()){
                    echo '
                    
                    <div class="main-container border-line success" style="border: none; margin-top: 5%;>
                    <div class="field info">
                    <center><p style="color:rgb(24, 155, 78); font-size: 30px"><b>Email sent successfully</b></p></center>
                    <center><p style="color:rgb(24, 155, 78);">There is a reset link that has been sent.</p></center>
                        <div class="container-image">
                            <img src="../static/pics/happy.gif">
                    </div>
                    </div>
                    
                    ';
                }
                

            }catch(Exception $e){
                echo '
                <div class="main-container border-line" style="border: none; margin-top: 5%;">
                <div class="field info">
                <center><p style="color:rgb(211, 37, 37); font-size: 30px"><b>Oops...something has failed</b></p></center>
                <center><p style="color:rgb(211, 37, 37);">Failed to send message with error- '.$mail->ErrorInfo.'</p></center>
                        <div class="container-image">
                            <img src="../static/pics/cry.gif">
                        </div>
                    
                </div>
                </div>
                ';
            }
            }
        }
    }
?>