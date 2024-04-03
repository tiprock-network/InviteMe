<?php include './config/db.php' ?>
<?php include './includes/header.php' ?>
<?php
    $id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : null;
    //query to fetch data
    $qry = "SELECT * FROM eventTbl WHERE eventId='$id';";
    //result
    $result = mysqli_query($conn,$qry);
    //get the array for the event
    $event = mysqli_fetch_assoc($result);
    if(!$event){
        echo 'No event found';
    }

    
?>

<!--body-->
<div class="registration-container">
    <div class="reg-head">
    
        <div class="section">
            <img src="./images/inviteme2.png" alt="">
        </div>

        <div class="section">
            <h2><?php echo $event['eventName']; ?></h2>
            <h3>Registration Form</h3>
            <p><i class="fa fa-circle-exclamation"></i> Kindly enter your information carefully.</p>
        </div>
    </div>

    <form action="./app/registerscript.php" method="POST">
        <h3>Personal Information</h3>
        <div class="frm-section">
            
            <div class="sub-section">
                <label for="uemail">Email</label>
                <br>
                <input type="email" name="uemail" placeholder="johndoe@gmail.com">
                <input type="hidden" name="id" value=<?php echo $id;?>>
            </div>

            <div class="sub-section">
                <label for="uname">Name</label>
                <br>
                <input type="text" name="uname" placeholder="first last">
            </div>

            <div class="sub-section">
                <label for="uphone">Phone</label>
                <br>
                <input type="text" name="uphone" placeholder="254x xxxx x97">
            </div>
        </div>

        <h3>Institution Information</h3>
        <div class="frm-section">
            
            <div class="sub-section">
                <label for="inst">Organization or Institution</label>
                <br>
                <input type="text" name="inst" placeholder="e.g. ABC Bank or Royal College">
            </div>

            <div class="sub-section">
                <label for="urole">Role</label>
                <br>
                <input type="text" name="urole" placeholder="Software Engineer or Student">
            </div>

            <div class="sub-section">
                <button type="submit" name="submit">Register</button>
            </div>

            
        </div>
    </form>

</div>

<?php  include './includes/footer.php' ?>