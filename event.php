<?php include './config/db.php' ?>
<?php include './includes/header.php' ?>
<?php
    $id = isset($_GET['eventId']) ? mysqli_real_escape_string($conn, $_GET['eventId']) : null;
    $event_qry = 'SELECT eventName FROM eventTbl WHERE eventId="'.$id.'"';
    
    $event_result = mysqli_query($conn,$event_qry);
    $single_event = mysqli_fetch_assoc($event_result);

    

    $events_qry = "SELECT eventTbl.eventId, eventTbl.eventName, registrationTbl.ticketId, registrationTbl.attendeeName, registrationTbl.attendeePhone, eventTbl.eventTime
    FROM eventTbl LEFT JOIN registrationTbl ON eventTbl.eventId=registrationTbl.eventId WHERE eventTbl.eventId = '".$id."';";
    //execute the query
    $result = mysqli_query($conn,$events_qry);

    //Count registered participants
    
?>
<div class="showcase">
    <div class="block-statement">
        <h1><?php echo $single_event['eventName'];?> Event</h1>
        <p>Edit, trigger emails and phone messages here.</p>
    </div>
    <div class="blur-section">

    </div>
</div>

<div class="events-main-container one-event">
    <h2 style="color: #7216eb7a;">Attendees</h2>
    <br>
    <?php if(!$result){ echo 'An error occurred'.mysqli_error($conn);?>
            
    <?php    }else{  $myevents = mysqli_fetch_all($result,MYSQLI_ASSOC);?>
        <table>
            <thead>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach($myevents as $event):?>
                 <tr>
                    <td><?php echo $event['attendeeName'];?></td>
                    <td><?php echo $event['attendeePhone'];?></td>
                    <td><?php echo $event['attendeeEmail'];?></td>
                <tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
    <?php   }
    ?>

</div>

<?php  include './includes/footer.php' ?>