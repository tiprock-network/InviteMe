<?php
    // Start the session if it hasn't already started
    if (session_status() == PHP_SESSION_NONE) session_start();
   
        
    if(isset($_SESSION['time'])){
        //1 minute = 60 seconds; 45 minutes = 2700 seconds
        if((time()-$_SESSION['time'])>2700){
        
            header("Location: logout.php");
        }
    }


    // Now you can safely access session variables
    //$user_name = isset($_SESSION['name']) ? $_SESSION['name'] : '';
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invite Me</title>
    <script src="https://kit.fontawesome.com/912e452282.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Moirai+One&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,500;1,600;1,700;1,800;1,900&family=Pacifico&display=swap" rel="stylesheet">
    
</head>
<style>
    <?php include './css/style.css';?>
</style>
<body>
    <?php
        //condition for present login
        if(!isset($_SESSION['time'])){
    ?>
        <header class="headerBtn">
       <nav>
            <ul>
                <li>
                    <a href="">
                        <div class="logo-container">
                            <img src="./images/inviteme2.png" alt="">
                        </div>
                        <span class="name"></span>
                    </a>
                </li>
                <li class="listItems"><a href="/inviteme"><i class="fa fa-house"></i> Home</a></li>
                <li class="listItems"><a href="about.php"><i class="fa fa-circle-question"></i> About</a></li>
                <li class="listItems"><i class="fa-regular fa-user" id="dropdown"></i> Accounts <?php echo isset($_SESSION['name']) ? ': '.$_SESSION['name'] : ''?>
                <div class="dropdown-content">
                    <?php
                        if(isset($_SESSION['name'])){
                            echo '
                            <a href="./logout.php">Logout</a>
                            <br>
                            <a href="./profile.php">Profile</a>
                            <br>'
                            ;
                        }else{
                            echo '
                            <a href="./login.php">Login</a>
                            <br>
                            ';
                        }
                    ?>
                    
                    
                </div>
            </li>
            </ul>
       </nav>
</header>
    <?php }else{?>
        <header class="headerBtn">
       <nav>
            <ul>
                <li>
                    <a href="">
                        <div class="logo-container">
                            <img src="./images/inviteme2.png" alt="">
                        </div>
                        <span class="name"></span>
                    </a>
                </li>
                <li class="listItems"><a href="/inviteme"><i class="fa fa-house"></i> Home</a></li>
                <li class="listItems"><a href="events.php"><i class="fa fa-calendar"></i> My Events</a></li>
                <li class="listItems"><a href="create.php"><i class="fa fa-calendar-plus"></i> Create Event</a></li>
                <li class="listItems"><a href="about.php"><i class="fa fa-circle-question"></i> About</a></li>
                <li class="listItems"><i class="fa-regular fa-user" id="dropdown"></i> Accounts <?php echo isset($_SESSION['name']) ? ': '.$_SESSION['name'] : ''?>
                <div class="dropdown-content">
                    <?php
                        if(isset($_SESSION['name'])){
                            echo '
                            <a href="./logout.php">Logout</a>
                            <br>
                            '
                            ;
                        }else{
                            echo '
                            <a href="./login.php">Login</a>
                            <br>
                            <a href="./register.php">Create Account</a>
                            <br>
                            ';
                        }
                    ?>
                    
                    
                </div>
            </li>
            </ul>
       </nav>
</header>
    <?php } ?>

