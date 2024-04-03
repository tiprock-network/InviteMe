<?php include './config/db.php' ?>
<?php include './includes/header.php' ?>
<?php
    $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : '';
    $events_qry = "SELECT * FROM eventTbl WHERE customerId='".$user_id."';";
    //execute the query
    $result = mysqli_query($conn,$events_qry);
    
?>
<div class="showcase">
    <div class="block-statement">
        <h1>All Events</h1>
        <p>Edit, trigger emails and phone messages here.</p>
    </div>
    <div class="blur-section">

    </div>
</div>

<div class="events-main-container">
    <?php if(!$result){ echo 'An error occurred'.mysqli_error($conn);?>
            
    <?php    }else{  $myevents = mysqli_fetch_all($result,MYSQLI_ASSOC);?>
        <?php foreach($myevents as $event):?>
            <div class="event-card-item">
                <div class="heading-sect">
                    <h1><a href="./event.php?eventId=<?php echo $event['eventId'];?>"><?php echo $event['eventName'];?></a></h1>
                </div>
                <div class="details-sect">
                    <?php echo date("D. j<\s\u\p>S</\s\u\p>, M. Y",strtotime($event['eventTime'])); ?>
                </div>
                
                <div class="desc-sect">
                    <p><?php echo $event['eventDesc']; ?></p>
                </div>

                <div class="link-section">
                    <a href="edit.php?id=<?php echo $event['eventId']?>">Edit</a>
                    <a href="sms.php?id=<?php echo $event['eventId']?>">Send SMS</a>
                    <a href="email_attendees.php?id=<?php echo $event['eventId']?>">Send Email</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php   }
    ?>

</div>

<?php  include './includes/footer.php' ?>