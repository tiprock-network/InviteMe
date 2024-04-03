<?php include './config/db.php' ?>
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
    if (session_status() == PHP_SESSION_NONE) session_start();
    //TODO: Check for login
    if(isset($_POST['submit'])){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $id = isset($_POST['id']) ? mysqli_real_escape_string($conn, $_POST['id']) : null;
            $spkr_id = isset($_POST['speakerId']) ? mysqli_real_escape_string($conn, $_POST['speakerId']) : null;
            if(!$_POST['eventfrmhead'] || !$_POST['eventDateTime'] || !$_POST['eventType'] || !$_POST['eventLoc'] || !$_POST['eventCountry'] || !$_POST['eventDuration'] || !$_POST['eventfrmdesc']){
                header("Location: create.php");

            }else{
               if(isset($_SESSION['id'])){
                $eId = $id;
                $custId = $_SESSION['id'];
                $ehead = cleanInput($_POST['eventfrmhead']);
                $etimedate = cleanInput($_POST['eventDateTime']);
                $etype = cleanInput($_POST['eventType']);
                $eLoc = cleanInput($_POST['eventLoc']);
                $eCountry = cleanInput($_POST['eventCountry']);
                $eDuration = cleanInput($_POST['eventDuration'] );
                $ePrice = cleanInput($_POST['eventPrice'])?cleanInput($_POST['eventPrice']):0;
                $elimit = cleanInput($_POST['eventLimit'])?cleanInput($_POST['eventLimit']):50;
                $eDesc = cleanInput($_POST['eventfrmdesc']);

                //create sql query
                $insert_event = "UPDATE eventTbl SET eventName='".$ehead."',eventLoc='".$eLoc."',eventCountry='".$eCountry."',eventDesc='".$eDesc."',eventType='".$etype."',eventTime='".$etimedate."',eventDuration='".$eDuration."',eventPrice='".$ePrice."',eventLimit='".$elimit."' WHERE eventId='".$id."';";

                //echo $insert_event;

                //execute query
                $result = mysqli_query($conn,$insert_event);
                if(!$result){
                    
                    echo '<div class="event_creationCont">
                        <div class="message_pic">
                            <img src="./images/event_fail.png" alt ="man sitting on a rock">
                        </div>
                    
                        <div class="body">
                            <h2>Failed to update event!</h2>
                            <p>'.mysqli_error($conn).'</p>
                            <br><br>
                            <a>Kindly go back.</a>
                        </div>
                    </div>';
                }else{
                    echo '<div class="event_creationCont">
                        <div class="message_pic">
                            <img src="./images/event_created.png" alt ="man and woman carrying message bubbles">
                        </div>
                    
                        <div class="body">
                            <h2>You have updated '.$ehead.' successfully!</h2>
                            <p>You have successfully created <strong>'.$ehead.'</strong>: <u><i>'.$eId.'</i></u></p>
                            <br><br>
                            <a href="events.php">Go to the event page</a>
                        </div>
                    </div>';
                    
                   
                }
               }else{
                header("Location: login.php");
               }
            }
        }
    }


    function cleanInput($input){
        return htmlentities($input);
    }
?>



</body>
</html>