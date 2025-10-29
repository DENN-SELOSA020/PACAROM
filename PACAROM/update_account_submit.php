<?php

require "includes/dbconnection.php";

$username = $_POST['uname'];
$newusername = $_POST['newuname'];
$password = $_POST['pword'];
$newpassword = $_POST['nwpword'];
$firstname = $_POST['fname'];
$lastname = $_POST['lname'];


$result = $db->query("SELECT * FROM users WHERE username='$username' AND password='$password'");
if ($result->num_rows == 0) {
    echo "<script>
                alert('Incorrect username or password');
                location.href='update_account.php';
              </script>";
    exit;
} else {
    $query = $db->query("UPDATE users SET username = 
     '$newusername', password = '$newpassword', fname = '$firstname', 
     lname = '$lastname' WHERE username = '$username' ");

    if ($query) {
        echo "<script>
                alert('Account updated successfully');
                location.href='home.php';
              </script>";
    } else {
        echo "<script>
                    alert('Update failed. Please try again.');
                    location.href='update_account.php';
                  </script>";
    }

}
?>