<?php
require "includes/dbconnection.php";
$id = $_GET['id'];
$file = $db->query("SELECT * FROM files WHERE id=$id")->fetch_assoc();

if ($file) {
    header('Content-Type: application/octet-stream');
    header("Content-Disposition: attachment; filename=\"" . $file['filename'] . "\"");
    readfile($file['filepath']);
    exit();
} else {
    echo "File not found.";
}
?>