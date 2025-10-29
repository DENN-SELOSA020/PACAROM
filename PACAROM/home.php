<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pacarom Cloud Home</title>
  <link rel="stylesheet" href="home.css?v=<?php echo time(); ?>">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
<?php 
    session_start();
    require "includes/dbconnection.php";

    if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
        header("Location: login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];

    include("includes/header.php");
?>
<div class="container">
  <div class="welcome-section">
    <h1>Welcome to Pacarom Cloud!</h1>
    <p class="welcome-message">Hello <?php echo htmlspecialchars($username); ?>! Your personal cloud storage solution</p>
  </div>

  <div class="info-section">
    <div class="info-box blue">
      <h3>📘 About Pacarom Storage</h3>
      <p>Pacarom cloud is a simple online storage for your files. You can upload photos, documents, and videos. Your files are saved in one place, and you can access them anytime from your phone or computer.</p>
      <div class="steps">
        <div class="step">
          <div class="step-number">1</div>
          <div class="step-text">Click "Dashboard" to move upload</div>
        </div>
        <div class="step">
          <div class="step-number">2</div>
          <div class="step-text">Click "Upload Files" to add your documents</div>
        </div>
        <div class="step">
          <div class="step-number">3</div>
          <div class="step-text">Manage your account in settings</div>
        </div>
      </div>
      <a href="dashboard.php" class="info-btn">Get Started Now</a>
    </div>

    <div class="info-box dark-blue">
      <h3>🛠 What You Can Do</h3>
      <ul>
        <li>⬆ Upload and store files securely</li>
        <li>⬇ Download your saved files anytime</li>
        <li>🗑 Delete files you no longer need</li>
        <li>🔒 Keep your account safe and secure</li>
        <li>📊 Monitor your storage usage</li>
        <li>🌐 Access files from anywhere</li>
      </ul>
      <a href="settings.php" class="info-btn">Go to Settings</a>
    </div>

    <div class="info-box green">
      <h3>🚀 Quick Tips</h3>
      <p>Make the most of your cloud storage with these helpful tips:</p>
      <ul>
        <li>✅ Organize files with descriptive names</li>
        <li>✅ Regularly backup important documents</li>
        <li>✅ Use strong passwords for security</li>
        <li>✅ Check your storage usage regularly</li>
      </ul>
      <a href="settings.php" class="info-btn">Security Settings</a>
    </div>
  </div>

  <div class="features-section">
    <h2>🌟 Why Choose Pacarom Cloud?</h2>
    <div class="features-grid">
      <div class="feature-card">
        <div class="feature-icon">🔒</div>
        <h4>Secure Storage</h4>
        <p>Your files are protected with advanced security measures and encrypted storage.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">🌐</div>
        <h4>Access Anywhere</h4>
        <p>Access your files from any device, anywhere in the world with internet connection.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">⚡</div>
        <h4>Fast Upload</h4>
        <p>Quick and efficient file uploads with progress tracking and error handling.</p>
      </div>
    </div>
  </div>

  <div class="activity-section">
    <h2>⚡ Quick Actions</h2>
    <div class="activity-grid">
      <div class="activity-card">
        <div class="activity-icon">📤</div>
        <div class="activity-content">
          <h4>Upload New Files</h4>
          <p>Add photos, documents, videos, and more to your cloud storage.</p>
          <a href="dashboard.php#upload" class="activity-link">Start Uploading →</a>
        </div>
      </div>
      <div class="activity-card">
        <div class="activity-icon">📋</div>
        <div class="activity-content">
          <h4>Manage Files</h4>
          <p>View, download, or delete your stored files with easy file management.</p>
          <a href="dashboard.php" class="activity-link">View Files →</a>
        </div>
      </div>
      <div class="activity-card">
        <div class="activity-icon">👤</div>
        <div class="activity-content">
          <h4>Account Settings</h4>
          <p>Update your profile, change password, and manage account preferences.</p>
          <a href="settings.php" class="activity-link">Go to Settings →</a>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>