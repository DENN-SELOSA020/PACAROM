<?php
session_start();
require "includes/dbconnection.php";

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in'] || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_FILES["userfile"])) {
    $_SESSION['upload_error'] = "Upload failed: No file was selected.";
    header("Location: dashboard.php?error=upload_failed");
    exit();
}

// Handle different upload errors
switch ($_FILES["userfile"]["error"]) {
    case UPLOAD_ERR_OK:
        break;
    case UPLOAD_ERR_INI_SIZE:
        $_SESSION['upload_error'] = "Upload failed: File exceeds the upload_max_filesize directive in php.ini (currently " . ini_get('upload_max_filesize') . ").";
        header("Location: dashboard.php?error=file_too_large");
        exit();
    case UPLOAD_ERR_FORM_SIZE:
        $_SESSION['upload_error'] = "Upload failed: File exceeds the MAX_FILE_SIZE directive in the HTML form.";
        header("Location: dashboard.php?error=file_too_large");
        exit();
    case UPLOAD_ERR_PARTIAL:
        $_SESSION['upload_error'] = "Upload failed: File was only partially uploaded.";
        header("Location: dashboard.php?error=upload_failed");
        exit();
    case UPLOAD_ERR_NO_FILE:
        $_SESSION['upload_error'] = "Upload failed: No file was uploaded.";
        header("Location: dashboard.php?error=upload_failed");
        exit();
    case UPLOAD_ERR_NO_TMP_DIR:
        $_SESSION['upload_error'] = "Upload failed: Missing temporary folder.";
        header("Location: dashboard.php?error=upload_failed");
        exit();
    case UPLOAD_ERR_CANT_WRITE:
        $_SESSION['upload_error'] = "Upload failed: Failed to write file to disk.";
        header("Location: dashboard.php?error=upload_failed");
        exit();
    case UPLOAD_ERR_EXTENSION:
        $_SESSION['upload_error'] = "Upload failed: File upload stopped by extension.";
        header("Location: dashboard.php?error=upload_failed");
        exit();
    default:
        $_SESSION['upload_error'] = "Upload failed: Unknown error occurred.";
        header("Location: dashboard.php?error=upload_failed");
        exit();
}

$user_id = $_SESSION['user_id'];
$target_dir = "uploads/";
$filename = basename($_FILES["userfile"]["name"]);
$target_file = $target_dir . time() . "_" . $filename;
$uploadDate = date("Y-m-d");

$max_storage = 16 * 1024 * 1024 * 1024;
$total_size = 0;

$stmt = $db->prepare("SELECT filepath FROM files WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $file_path = $row['filepath'];
    if (file_exists($file_path)) {
        $total_size += filesize($file_path);
    }
}

$upload_file_size = $_FILES["userfile"]["size"];

error_log("User ID: $user_id, Current storage: $total_size bytes, Upload size: $upload_file_size bytes, Max storage: $max_storage bytes");

if ($total_size >= $max_storage) {
    $_SESSION['upload_error'] = "Upload failed: Your storage is full (" . round($total_size / (1024*1024*1024), 2) . "GB used). Please delete some files first.";
    header("Location: dashboard.php?error=storage_full");
    exit();
}

if (($total_size + $upload_file_size) > $max_storage) {
    $used_gb = round($total_size / (1024*1024*1024), 2);
    $file_mb = round($upload_file_size / (1024*1024), 2);
    $_SESSION['upload_error'] = "Upload failed: File ($file_mb MB) would exceed your 16GB storage limit. You have used $used_gb GB. Please delete some files first.";
    header("Location: dashboard.php?error=storage_full");
    exit();
}

$max_file_size = 1024 * 1024 * 1024;
if ($upload_file_size > $max_file_size) {
    $_SESSION['upload_error'] = "Upload failed: File is too large. Maximum file size is 1GB.";
    header("Location: dashboard.php?error=file_too_large");
    exit();
}

if (move_uploaded_file($_FILES["userfile"]["tmp_name"], $target_file)) {
    $stmt = $db->prepare("INSERT INTO files (user_id, filename, filepath, upload_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $filename, $target_file, $uploadDate);
    $stmt->execute();
    header("Location: dashboard.php?success=uploaded");
} else {
    $_SESSION['upload_error'] = "Upload failed: Could not move uploaded file.";
    header("Location: dashboard.php?error=upload_failed");
}
?>