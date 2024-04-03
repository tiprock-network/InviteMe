<?php include './config/db.php' ?>
<?php
    if( isset($_GET['id'])){
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        //sql query
        $delete_query = "DELETE FROM eventTbl WHERE eventId = '".$id."';";
        $result_query = mysqli_query($conn,$delete_query);

        if($result_query){
            header("Location: index.php");
        }

    }
    
    
?>