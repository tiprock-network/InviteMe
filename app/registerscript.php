<?php include '../config/db.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Moirai+One&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,500;1,600;1,700;1,800;1,900&family=Pacifico&display=swap');
    *{
        margin: 0;
    }
    body{
        font-family: "Montserrat", sans-serif;
        font-size: 14px;
        font-weight: 500px;
    }
    .event_creationCont{
        width: 60%;
        transform: translate(35%,50%);
        box-shadow: 0px 2px 4px 0px #ccc;
        padding: 15px;
        border-radius: 10px;
        text-align: center;
    }

    .message_pic{
        width: 100%;
        height: 150px;
        
    }
    .message_pic>img{
        width: 150px;
        height: 150px;
        object-fit: cover;
    }

    .body>h2{
        color: #352258;
        font-size: 30px;
    }

    .body>p{
        color: #444;
        font-weight: 600;
    }

    .body>a{
        font-size: 14px;
        text-decoration: none;
        color: #352258;
        font-weight: 700;
    }
        
</style>
<body>


<?php
    $id = isset($_POST['id']) ? mysqli_real_escape_string($conn, $_POST['id']) : null;
    
    //query to fetch data
    $qry = "SELECT * FROM eventTbl WHERE eventId='$id';";
    //result
    $result = mysqli_query($conn,$qry);
    //get the array for the event
    $event = mysqli_fetch_assoc($result);
    if(!$event){
        echo '<div class="event_creationCont">
        <div class="message_pic">
            <img src="../images/event_fail.png" alt ="man sitting on a rock">
        </div>
    
        <div class="body">
            <h2>Oops, look like you forgot all the inputs!</h2>
            <p>'.mysqli_error($conn).'</p>
            <br><br>
            <a>Kindly go back</a>
        </div>
    </div>';
    }


    //form input data
    if(isset($_POST['submit'])){
        if(!isset($_POST['uemail'],$_POST['uname'],$_POST['uphone'],$_POST['inst'],$_POST['urole'])){
            echo '<div class="event_creationCont">
            <div class="message_pic">
                <img src="../images/event_fail.png" alt ="man sitting on a rock">
            </div>
        
            <div class="body">
                <h2>Oops, look like you forgot all the inputs!</h2>
                <p>'.mysqli_error($conn).'</p>
                <br><br>
                <a>Kindly go back</a>
            </div>
        </div>';
        }else{
            $email=cleanInput($_POST['uemail']);
            $name = cleanInput($_POST['uname']);
            $phone = cleanInput($_POST['uphone']);
            $institution = cleanInput($_POST['inst']);
            $role = cleanInput($_POST['urole']);
            //define the ticket number constant
            $ticketNo=uniqid();
            $event_id = $event['eventId'];
            $event_name = $event['eventName'];
            $regTime =  date("Y-m-d H:i:s", time());
            //insert the new attendee details
            //attendeeTbl
            //TODO: prevent double creation select 
            //select from registration tbl
            $reg_query = "SELECT eventId,attendeeEmail FROM registrationTbl WHERE eventId='".$event_id."' AND attendeeEmail='".$email."';";
            $reg_res = mysqli_query($conn,$reg_query);
            $registrations = mysqli_fetch_array($reg_res);
            if($registrations !== null && count($registrations)>0){
                //TODO: return to events page
                //change picture to success
                echo '<div class="event_creationCont">
                <div class="message_pic">
                    <img src="../images/event_fail.png" alt ="man sitting on a rock">
                </div>
            
                <div class="body">
                    <h2>You have already registered for this event. See you there!</h2>
                    <p>'.mysqli_error($conn).'</p>
                    <br><br>
                    <a>Kindly go back</a>
                </div>
            </div>';
            }else{
                $attendee_query = "INSERT INTO registrationTbl VALUES ('$ticketNo','$event_id','$regTime','$name','$role','$institution','$email','$phone');";
                $res = mysqli_query($conn,$attendee_query);
                if(!$res){
                    echo '<div class="event_creationCont">
                    <div class="message_pic">
                        <img src="../images/event_fail.png" alt ="man sitting on a rock">
                    </div>
                
                    <div class="body">
                        <h2>Something went wrong during registration.</h2>
                        <p>'.mysqli_error($conn).'</p>
                        <br><br>
                        <a>Kindly go back</a>
                    </div>
                </div>';
                }else{
                    //update new registration count in the eventTbl
                    //get registration count
                    $regCount = $event['eventNoRegistered'] + 1;
                    //eventTbl
                    $event_query = "UPDATE eventTbl SET eventNoRegistered=".$regCount.";";
                    //update the table
                    mysqli_query($conn,$event_query);

                    echo '<div class="event_creationCont">
                        <div class="message_pic">
                            <img src="../images/event_created.png" alt ="man and woman carrying message bubbles">
                        </div>
                    
                        <div class="body">
                            <h2>Registration Complete!</h2>
                            <p>You have successfully registered for <strong>'.$event_name.'</strong>: Ticket No. <u><i>'.$ticketNo.'</i></u></p>
                            <br><br>
                            <a href="../index.php">Go back home.</a>
                        </div>
                    </div>';
                }

            }
            
            

        }

    }

    //clean chars
    function cleanInput($data){
        return htmlspecialchars($data);
    }

   
?>

</body>
</html>
