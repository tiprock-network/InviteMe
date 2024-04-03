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
    //speakerName, speakerEmail, speakerSocial, eventLoc, eventCountry, speakerCompany, speakerCountry
    $id = isset($_POST['id']) ? mysqli_real_escape_string($conn, $_POST['id']) : null;
    $spkr_id = isset($_POST['speakerId']) ? mysqli_real_escape_string($conn, $_POST['speakerId']) : null;

    //query to update data
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
        if(!isset($_POST['speakerName'],$_POST['speakerEmail'],$_POST['speakerSocial'],$_POST['speakerLoc'],$_POST['speakerCountry'],$_POST['speakerCompany'])){
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
            $speakerId=$spkr_id;
            $speakerEmail = cleanInput($_POST['speakerEmail']);
            $speakerSocials = cleanInput($_POST['speakerSocial']);
            $speakerLoc = cleanInput($_POST['speakerLoc']);
            $speakerCountry = cleanInput($_POST['speakerCountry']);
            $speakerCompany = cleanInput($_POST['speakerCompany']);
            $speakerDesc = $_POST['speakerDesc'];
            $speakerName = $_POST['speakerName'];

                 //eventTbl
                 $event_query = 'SELECT * FROM speakerTbl WHERE speakerEmail="'.$speakerEmail.'" AND eventId="'.$id.'";';
                 //update the table
                 $event_qry_res = mysqli_query($conn,$event_query);
                 //found speakers
                 $found_speakers = mysqli_fetch_all($event_qry_res,MYSQLI_ASSOC);
                 
                 if(count($found_speakers)>0){
                    echo '<div class="event_creationCont">
                    <div class="message_pic">
                        <img src="../images/event_fail.png" alt ="man sitting on a rock">
                    </div>
                
                    <div class="body">
                        <h2>A speaker with the email, '.$speakerEmail.', already exists.</h2>
                        <p>'.mysqli_error($conn).'</p>
                        <br><br>
                        <a>Kindly go back</a>
                    </div>
                </div>';
                 }else{


            
                $speaker_query = "INSERT INTO speakerTbl VALUES ('$speakerId','$id','$speakerName','$speakerDesc','$speakerCountry','$speakerCompany','$speakerEmail','$speakerSocials');";
                $res = mysqli_query($conn,$speaker_query);
                if(!$res){
                    echo '<div class="event_creationCont">
                    <div class="message_pic">
                        <img src="../images/event_fail.png" alt ="man sitting on a rock">
                    </div>
                
                    <div class="body">
                        <h2>Something went wrong during add '.$speakerName.'.</h2>
                        <p>'.mysqli_error($conn).'</p>
                        <br><br>
                        <a>Kindly go back</a>
                    </div>
                </div>';
                }else{
                    //update new registration count in the eventTbl
                     //query to update data
                    
                        echo '<div class="event_creationCont">
                            <div class="message_pic">
                                <img src="../images/event_created.png" alt ="man and woman carrying message bubbles">
                            </div>
                        
                            <div class="body">
                                <h2>You just added a speaker!</h2>
                                <p>That\'s neat, make sure to contact '.$speakerName.' and tell him/ her of <strong>'.$event['eventName'].'</strong></p>
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
