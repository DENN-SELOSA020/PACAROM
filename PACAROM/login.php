<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pacarom Cloud</title>
    <link rel="stylesheet" href="login.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>

<body>
    <?php
    session_start();
    require "includes/dbconnection.php";

    if (isset($_SESSION['user_id'])) {
        header("Location: dashboard.php");
        exit();
    }

    if (isset($_SESSION['logged_in']) == TRUE) {
        header("Location: home.php");
    }
    ?>

    <main class="login-wrapper">

        <h1 class="login-title">PACAROM CLOUD</h1>
        <p class="login-description">A safe and simple space to keep your files.</p>
        
        <section class="login-card">

            

            <div class="login-header">Login</div>

            <form action="login_submit.php" method="post" class="login-form">

                <div class="input-group">
                    <label for="uname">Username</label>
                    <input type="text" id="uname" name="uname" class="input-field" required>
                </div>

                <div class="input-group">
                    <label for="pword">Password</label>
                    <input type="password" id="pword" name="pword" class="input-field" required>
                </div>

                <?php if (isset($_SESSION['error_message'])): ?>
                <div class="error-alert">
                    <span class="error-icon">❌</span>
                    <?php 
                        echo htmlspecialchars($_SESSION['error_message']); 
                        unset($_SESSION['error_message']);
                    ?>
                </div>
            <?php endif; ?>

            

                <div class="button-group">
                    <input type="submit" class="btn primary-btn" value="Sign In">
                    <input type="reset" class="btn secondary-btn" value="Reset">
                    <a href="register.php" class="btn warning-btn right-align">Sign Up</a>
                </div>
            </form>
        </section>
    </main>
</body>

</html>