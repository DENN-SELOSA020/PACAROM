<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="includes/header.css">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>

<body>
    <nav class="vertical-nav">
        <div class="profile-section">
            <div class="profile-avatar">
                👤
            </div>
            <h4 class="profile-name">My Cloud</h4>
        </div>

        <ul class="nav-list">
            <li <?php echo ($current_page == 'home.php') ? 'class="active"' : ''; ?>>
                <a href="home.php">
                    <span class="nav-icon home-icon"></span>
                    Home
                </a>
            </li>
            <li <?php echo ($current_page == 'dashboard.php') ? 'class="active"' : ''; ?>>
                <a href="dashboard.php">
                    <span class="nav-icon dashboard-icon"></span>
                    Dashboard
                </a>
            </li>
        </ul>

        <div class="nav-bottom">
            <ul class="nav-list">
                <li <?php echo ($current_page == 'settings.php') ? 'class="active"' : ''; ?>>
                    <a href="settings.php">
                        <span class="nav-icon settings-icon"></span>
                        Settings
                    </a>
                </li>
                <li <?php echo ($current_page == 'logout.php') ? 'class="active"' : ''; ?>>
                    <a href="logout.php">
                        <span class="nav-icon logout-icon"></span>
                        Log out
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    
    <div class="main-content">