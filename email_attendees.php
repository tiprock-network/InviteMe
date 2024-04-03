<?php include './config/db.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invite Me</title>
    <script src="https://kit.fontawesome.com/912e452282.js" crossorigin="anonymous"></script>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Moirai+One&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,500;1,600;1,700;1,800;1,900&family=Pacifico&display=swap');
        *{
            margin: 0;
        }

        

        body{
            font-family: "Montserrat", sans-serif;
            font-size: 16px;
            font-weight: 600;
            color: #333;
            overflow-x: hidden;
        }

        .email-confirmation{
            width: 60%;
            height: 50px;
            transform: translateX(40%);
            background-color: #f4f4f4;
            color: #333;
            padding: 16px;
            margin-bottom: 15px;
        }

        .fa-check{
            color: #318f60;
        }

        .emailPage{
            padding: 16px;
            margin-bottom: 15px;
            color: #352258;
            width: 60%;
            transform: translateX(40%);
        }
        .emailPage>p{
            font-size: 22px;
            font-weight: 900;
            border-bottom: 1px solid #ccc;
        }
</style>
<body>
    <?php
        //import phpmailer libraries
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;

        $id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : null;
        $reg_qry = "SELECT eventTbl.eventId, eventTbl.eventName, registrationTbl.ticketId, registrationTbl.attendeeName, registrationTbl.attendeeEmail, eventTbl.eventTime
        FROM eventTbl CROSS JOIN registrationTbl WHERE eventTbl.eventId='".$id."';";

        $reg_qry_res = mysqli_query($conn,$reg_qry);


        if(!$reg_qry_res){
            echo '<div class="event_creationCont">
                                <div class="message_pic">
                                    <img src="./images/event_fail.png" alt ="man sitting on a rock">
                                </div>
                            
                                <div class="body">
                                    <h2>Could not find any number!</h2>
                                    <p>'.mysqli_error($conn).'</p>
                                    <br><br>
                                    <a href="events.php">Click here to go back</a>
                                </div>
                            </div>';
        }else{
            echo '<div class="emailPage">
                <p>Emails Status</p>
            </div>';

            $registered_participants = mysqli_fetch_all($reg_qry_res,MYSQLI_ASSOC);
            
           
            //add all the numbers inside the array from db
            foreach($registered_participants as $participant){
                //create the reset link
            $event_link = 'http://localhost/inviteme/event.php?eventId='.$participant['eventId'].'';
                // send email to each participant
                    

                    require('./vendor/autoload.php');
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
                    $mail->addAddress($participant['attendeeEmail'], $participant['attendeeName']); // Set the recipient's email address and name

                    // Email content
                    $mail->isHTML(true);
                    $mail->addEmbeddedImage('./images/events.png','image1');
                    $mail->addEmbeddedImage('./images/inviteme2.png','image2');
                    $mail->Subject = 'Event Reminder '.$participant['eventName'];
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
                                    <p>Hi, thank you for registering for the event, '.$participant['eventName'].'. Kindly keep in mind that the event will be held on '.$participant['eventTime'].'. Your ticked no. is <strong><u>'.$participant['ticketId'].'</u></strong></p>
                                    <br>
                                    
                                    <p>Find the event link here: <a href="'.$event_link.'" style="color: #444;">'.$event_link.'</a></p>
                                </div>
                            </div>
                        </body>
                        </html>
                    ';

                    //TODO: FORMAT THE CONFIRMATION AND ERROR MESSAGES

                    if($mail->Send()){
                        echo '
                            <div class="email-confirmation">
                                <p><span style="color:#7e41ee;"> '.$participant['attendeeName'].'</span> - '.$participant['attendeeEmail'].' <i class="fa-regular fa-check-circle"></i></p>
                            </div>
                            <br>
                        
                        ';
                    }
                    

                }catch(Exception $e){
                    echo '
                     
                     <div class="email-confirmation">
                     <p><span style="color:#7e41ee;"> '.$mail->ErrorInfo.'</span> - Error  <i class="fa-regular fa-xmark-circle"></i></p>
                 </div>
                 <br>
                    ';
                }
                }

            

        }
    ?>
</body>
</html>