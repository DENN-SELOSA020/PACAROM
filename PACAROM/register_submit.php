<?php
require "includes/dbconnection.php";

$username           = $_POST['uname'];
$password           = $_POST['pword'];
$confirmpassword    = $_POST['cfpword'];
$firstname          = $_POST['fname'];
$lastname           = $_POST['lname'];

if($password != $confirmpassword){
    echo "<script>
    alert('Passwords do not match');
    location.href='register.php';
    </script>";
}else{


    $dbusername = $db->query("SELECT username FROM users WHERE username = '$username'");
    if($dbusername->num_rows > 0){
        echo "<script>
        alert('Username already exists');
        location.href='register.php';
        </script>";
        exit();
    }

    $query = $db->query("
INSERT into users (username,password,fname,lname)
VALUES ('$username','$password','$firstname','$lastname')
    ");
    header("Location: login.php");


}
?>