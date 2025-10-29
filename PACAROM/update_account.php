<link rel="stylesheet" href="update_account.css">

<?php
session_start();
require "includes/dbconnection.php";

if (!isset($_SESSION['logged_in']) == TRUE) {
    header("Location: home.php");
}
?>

<body>
    <main class="update-wrapper">

        <h1 class="update-title">Modify your account details</h1>
        <section class="update-card">
            <div class="update-header">Update Account</div>

            <form action="update_account_submit.php" method="post" class="update-form">

                <div class="input-group">
                    <label for="uname">Current Username</label>
                    <input type="text" name="uname" id="uname" class="input-field" required>
                </div>

                <div class="input-group">
                    <label for="newuname">New Username</label>
                    <input type="text" name="newuname" id="newuname" class="input-field" required>
                </div>

                <div class="input-group">
                    <label for="pword">Current Password</label>
                    <input type="password" name="pword" id="pword" class="input-field" required>
                </div>

                <div class="input-group">
                    <label for="nwpword">New Password</label>
                    <input type="password" name="nwpword" id="nwpword" class="input-field" required>
                </div>

                <div class="input-group">
                    <label for="fname">First Name</label>
                    <input type="text" name="fname" id="fname" class="input-field" required>
                </div>

                <div class="input-group">
                    <label for="lname">Last Name</label>
                    <input type="text" name="lname" id="lname" class="input-field" required>
                </div>

                <div class="button-group">
                    <input type="submit" class="btn primary-btn" value="Update">
                    <input type="reset" class="btn secondary-btn" value="Reset">
                    <a href="login.php" class="btn warning-btn right-align">Sign In</a>
                </div>
            </form>
        </section>
    </main>
</body>