<?php include '../config/db.php' ?>
<?php
    function removeSpecialChars($myval){
        return htmlspecialchars($myval);
    }

    $cust_id = strval(date('YmdHis')).uniqid();
    $email = removeSpecialChars($_POST['uemail2']);
    $addr = removeSpecialChars($_POST['addr']);
    $country = removeSpecialChars($_POST['country']);
    $reg = removeSpecialChars($_POST['reg']);
    $phone = removeSpecialChars($_POST['uphone']);
    $organization_name = removeSpecialChars($_POST['orgname']);
    $role = removeSpecialChars($_POST['orgpost']);
    $options = [ 
        'cost' => 12, 
    ]; 
    $upass = password_hash(removeSpecialChars($_POST['upass2']),PASSWORD_BCRYPT,$options);
    //TODO: Implement Check for all empty or null values

    //create query
    $insert_new_customer = "INSERT INTO customerTbl(customerId,customerName,customerType,customerStreet,customerPhone,customerEmail,customerCountry,customerRegion,customerPassword) VALUES('$cust_id','$organization_name','$role','$addr','$phone','$email','$country','$reg','$upass');";
    //execute sql
    $result = mysqli_query($conn,$insert_new_customer);

    if(!$result){
        echo "No customer added.";
    }else{
        echo "Customer added successfully";
    }

?>