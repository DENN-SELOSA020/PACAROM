<?php
session_start();
require "includes/dbconnection.php";

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$file = $db->query("SELECT * FROM files WHERE id=$id AND user_id=$user_id")->fetch_assoc();
if ($file) {
    unlink($file['filepath']);
    $db->query("DELETE FROM files WHERE id=$id");
}
header("Location: dashboard.php");
?>