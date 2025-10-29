<?php
session_start();
require "includes/dbconnection.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['last_attempt_time'] = time();
}

if (isset($_SESSION['last_attempt_time']) && (time() - $_SESSION['last_attempt_time'] > 180)) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['last_attempt_time'] = time();
}

if ($_SESSION['login_attempts'] >= 5) {
    $remaining_time = 180 - (time() - $_SESSION['last_attempt_time']);
    if ($remaining_time > 0) {
        $minutes_left = ceil($remaining_time / 60);
        $_SESSION['error_message'] = "Too many failed login attempts. Please wait $minutes_left minutes before trying again.";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['login_attempts'] = 0;
        $_SESSION['last_attempt_time'] = time();
    }
}

if (empty($_POST['uname']) || empty($_POST['pword'])) {
    $_SESSION['error_message'] = "Please fill in all fields.";
    header("Location: login.php");
    exit();
}

$username = trim($_POST['uname']);
$password = trim($_POST['pword']);

$stmt = $db->prepare("SELECT id, username, password, fname, lname FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    
  
    if ($username !== $user['username']) {
        $_SESSION['login_attempts']++;
        $_SESSION['last_attempt_time'] = time();
        
        usleep(100000);
        $_SESSION['error_message'] = "Invalid username or password. Please try again.";
        header("Location: login.php");
        exit();
    }
    
    if ($password === $user['password']) {
        $_SESSION['login_attempts'] = 0;
        unset($_SESSION['last_attempt_time']);
        
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['fname'] = $user['fname'];
        $_SESSION['lname'] = $user['lname'];
        $_SESSION['logged_in'] = true;
        
        session_regenerate_id(true);
        
        header("Location: home.php");
        exit();
    } else {
        $_SESSION['login_attempts']++;
        $_SESSION['last_attempt_time'] = time();
        
        usleep(100000);
        $_SESSION['error_message'] = "Invalid username or password. Please try again.";
        header("Location: login.php");
        exit();
    }
} else {
    $_SESSION['login_attempts']++;
    $_SESSION['last_attempt_time'] = time();
    
    usleep(100000);
    $_SESSION['error_message'] = "Invalid username or password. Please try again.";
    header("Location: login.php");
    exit();
}

$stmt->close();
?>