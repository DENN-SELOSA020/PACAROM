<?php
$db = new mysqli("localhost", "root", "", "cloud_storage");
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>