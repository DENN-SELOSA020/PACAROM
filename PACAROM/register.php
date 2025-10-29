<link rel="stylesheet" href="register.css">

<?php
session_start();
require "includes/dbconnection.php";

if (isset($_SESSION['logged_in']) == TRUE) {
  header("Location: home.php");
}
?>

<body>
  <main class="register-wrapper">


    <h1 class="register-title">Create your pacarom account</h1>

    <section class="register-card">

      

      <div class="register-header">Register</div>
      <form action="register_submit.php" method="post" class="register-form">

        <div class="input-group">
          <label for="uname">Username</label>
          <input type="text" name="uname" id="uname" class="input-field" required>
        </div>

        <div class="input-group">
          <label for="pword">Password</label>
          <input type="password" name="pword" id="pword" class="input-field" required>
        </div>

        <div class="input-group">
          <label for="cfpword">Confirm Password</label>
          <input type="password" name="cfpword" id="cfpword" class="input-field" required>
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
          <input type="submit" class="btn primary-btn" value="Sign Up">
          <input type="reset" class="btn secondary-btn" value="Reset">
          <a href="login.php" class="btn warning-btn right-align">Sign In</a>
        </div>
      </form>
    </section>




  </main>
</body>