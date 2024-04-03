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
require_once 'vendor/autoload.php'; // Composer autoloader
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

function getDateDifference($dateToCompare) {
    // Get current date and time
    $currentDateTime = new DateTime();

    // Convert $dateToCompare to DateTime object
    $dateToCompareObj = new DateTime($dateToCompare);

    // Calculate difference
    $interval = $currentDateTime->diff($dateToCompareObj);

    // Initialize an array to hold non-zero interval units
    $nonZeroIntervals = [];

    // Check and store non-zero interval units
    if ($interval->m > 0) {
        $nonZeroIntervals[] = $interval->m . " months";
    }
    if ($interval->d > 0) {
        $nonZeroIntervals[] = $interval->d . " days";
    }
    if ($interval->h > 0) {
        $nonZeroIntervals[] = $interval->h . " hours";
    }
    if ($interval->i > 0) {
        $nonZeroIntervals[] = $interval->i . " minutes";
    }

    // Return the difference as a string
    return implode(', ', $nonZeroIntervals);
}


$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : null;
$reg_qry = "SELECT eventTbl.eventId, eventTbl.eventName, registrationTbl.ticketId, registrationTbl.attendeeName, registrationTbl.attendeePhone, eventTbl.eventTime
FROM eventTbl LEFT JOIN registrationTbl ON eventTbl.eventId=registrationTbl.eventId WHERE eventTbl.eventId = '".$id."';";


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
    $registered_participants = mysqli_fetch_all($reg_qry_res,MYSQLI_ASSOC);
    //create array of numbers
    $reg_phone_numbers = array();
    //add all the numbers inside the array from db
    foreach($registered_participants as $participant){
       // Append phone number to the array
        $reg_phone_numbers[] = $participant['attendeePhone'];
        //echo $participant['attendeePhone'];
    }

    //echo implode(" ",$phone_numbers);
    //https://e1m442.api.infobip.com/sms/1/text/query
    //https://e1m442.api.infobip.com/sms/2/text/advanced
    

    $url = 'https://e1m442.api.infobip.com/sms/2/text/advanced';
    $api_key = '0a1a33bcc5de12d5b11b8a3718119767-74c17902-2a25-4e58-b9f3-c38e5ab365d5'; // replace with your actual API key
    $phone_numbers = $reg_phone_numbers;//$reg_phone_numbers;//['254758885970']; // replace with the desired phone numbers

    $client = new Client();

   
    try {
        $response = $client->post($url, [
            'headers' => [
                'Authorization' => 'App ' . $api_key,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'json' => [
                'messages' => array_map(function ($number,$participant) {
                    return [
                        'destinations' => [
                            ['to' => $number],
                        ],
                        'from' => 'Invite Me',
                        'text' => 'Hello '.$participant['attendeeName'].', This is a reminder that the event - '.$participant['eventName'].' starts in '.getDateDifference($participant['eventTime']).'.',
                    ];
                }, $phone_numbers,$registered_participants),
            ],
        ]);

        if ($response->getStatusCode() == 200) {
            // REPLACE WITH MESSAGE after all have been sent use a counter
           // echo $response->getBody();
           echo '<div class="event_creationCont">
           <div class="message_pic">
               <img src="./images/event_created.png" alt ="man and woman carrying message bubbles">
           </div>
       
           <div class="body">
               <h2>An SMS reminder about the event has been sent!</h2>
               <p>You have successfully sent bulk SMS.</p>
               <br><br>
               <a href="events.php">Go to the event page.</a>
           </div>
       </div>';
        } else {
            echo 'Unexpected HTTP status: ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase();
        }
    } catch (RequestException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>

</body>
</html>
