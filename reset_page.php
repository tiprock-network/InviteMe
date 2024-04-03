<?php include './config/config.php' ?>
<?php include './config/db.php' ?>
<?php include './includes/header.php' ?>

   <div class="accounts-main-container">
        <div class="header-section-accounts">
            <h1>Send reset link</h1>
        </div>

        <form action="./app/reset_email.php" method="POST">
            <div class="accounts-form-section">
                <label for="uname">Email</label>
                <br>
                <input type="email" name="uemail" placeholder="e.g. myemail@example.com">
                <div class="msg-box" id="msg-box-email">
                    <p class="success"><i class="fa fa-circle-check"></i> Email is valid.</p>
                </div>
            </div>

            
            <div class="accounts-form-section btn-section">
                <button type="submit" name="submit">Send Link</button>
            </div>
        </form>
   </div>
