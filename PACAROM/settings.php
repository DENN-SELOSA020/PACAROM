<?php 
    session_start();
    require "includes/dbconnection.php";

    if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
        header("Location: login.php");
        exit();
    }

    if (isset($_POST['cleanup_files'])) {
        $user_id = $_SESSION['user_id'];
        $files_deleted = 0;
        $space_freed = 0;
        
        $cutoff_date = date('Y-m-d', strtotime('-30 days'));
        $stmt = $db->prepare("SELECT id, filepath FROM files WHERE user_id = ? AND upload_date < ?");
        $stmt->bind_param("is", $user_id, $cutoff_date);
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $file_path = $row['filepath'];
            if (file_exists($file_path)) {
                $file_size = filesize($file_path);
                if (unlink($file_path)) {
                    $delete_stmt = $db->prepare("DELETE FROM files WHERE id = ?");
                    $delete_stmt->bind_param("i", $row['id']);
                    $delete_stmt->execute();
                    
                    $files_deleted++;
                    $space_freed += $file_size;
                }
            } else {
                $delete_stmt = $db->prepare("DELETE FROM files WHERE id = ?");
                $delete_stmt->bind_param("i", $row['id']);
                $delete_stmt->execute();
            }
        }
        
        $space_freed_mb = round($space_freed / (1024 * 1024), 2);
        header("Location: settings.php?success=cleanup&files=$files_deleted&space=$space_freed_mb");
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $total_size = 0;
    $file_count = 0;
    $max_storage = 16 * 1024 * 1024 * 1024;

    $stmt = $db->prepare("SELECT filepath FROM files WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $file_path = $row['filepath'];
        if (file_exists($file_path)) {
            $total_size += filesize($file_path);
            $file_count++;
        } else {
            $cleanup_stmt = $db->prepare("DELETE FROM files WHERE filepath = ? AND user_id = ?");
            $cleanup_stmt->bind_param("si", $file_path, $user_id);
            $cleanup_stmt->execute();
        }
    }

    $used_space_mb = round($total_size / (1024 * 1024), 2);
    $available_space_mb = round(($max_storage - $total_size) / (1024 * 1024), 2);
    $usage_percentage = round(($total_size / $max_storage) * 100, 1);

    $storage_warning = '';
    $storage_error = '';
    $is_storage_full = false;

    if ($total_size >= $max_storage) {
        $is_storage_full = true;
        $storage_error = 'Storage limit exceeded! You have reached your 16GB limit. Please delete some files to free up space.';
        $available_space_mb = 0;
    } elseif ($usage_percentage >= 95) {
        $storage_warning = 'Warning: You are using ' . $usage_percentage . '% of your storage. Consider cleaning up files to avoid reaching the limit.';
    } elseif ($usage_percentage >= 80) {
        $storage_warning = 'Notice: You are using ' . $usage_percentage . '% of your storage space.';
    }

    if ($available_space_mb < 0) {
        $available_space_mb = 0;
    }

    include("includes/header.php");
?>

<link rel="stylesheet" href="settings.css?v=<?php echo time(); ?>">

<div class="settings-wrapper">
    <div class="settings-container">
        <div class="settings-header">
            <h1 class="settings-title">PACAROM CLOUD</h1>
            <p class="settings-subtitle">Account Settings & Preferences</p>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="success-alert">
                <span class="alert-icon">✅</span>
                <?php 
                    if ($_GET['success'] == 'theme_updated') {
                        echo "Theme updated successfully!";
                    } elseif ($_GET['success'] == 'account_updated') {
                        echo "Account updated successfully!";
                    } elseif ($_GET['success'] == 'cleanup') {
                        $files_deleted = isset($_GET['files']) ? (int)$_GET['files'] : 0;
                        $space_freed = isset($_GET['space']) ? $_GET['space'] : '0';
                        echo "File cleanup completed! Deleted $files_deleted old files and freed $space_freed MB of space.";
                    }
                ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($storage_error)): ?>
            <div class="error-alert">
                <span class="alert-icon">❌</span>
                <?php echo $storage_error; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($storage_warning)): ?>
            <div class="warning-alert">
                <span class="alert-icon">⚠️</span>
                <?php echo $storage_warning; ?>
            </div>
        <?php endif; ?>

        <!-- Account Settings Section -->
        <div class="settings-card">
            <div class="card-header">
                <h3 class="card-title">
                    <span class="card-icon">👤</span>
                    Account Settings
                </h3>
            </div>
            <div class="card-body">
                <div class="settings-grid">
                    <div class="settings-section">
                        <h4 class="section-title">Profile Information</h4>
                        <div class="info-group">
                            <div class="info-item">
                                <label>Username</label>
                                <span class="info-value"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                            </div>
                            <div class="info-item">
                                <label>Full Name</label>
                                <span class="info-value"><?php echo htmlspecialchars(($_SESSION['fname'] ?? '') . ' ' . ($_SESSION['lname'] ?? '')); ?></span>
                            </div>
                        </div>
                        <a href="update_account.php" class="btn primary-btn">Update Account</a>
                    </div>
                    <div class="settings-section">
                        <h4 class="section-title">Security</h4>
                        <div class="info-group">
                            <div class="info-item">
                                <label>Password</label>
                                <span class="info-value">••••••••</span>
                            </div>
                            <div class="info-item">
                                <label>Last Login</label>
                                <span class="info-value"><?php echo date('M d, Y H:i'); ?></span>
                            </div>
                        </div>
                        <a href="update_account.php" class="btn warning-btn">Change Password</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Storage Settings Section -->
        <div class="settings-card">
            <div class="card-header">
                <h3 class="card-title">
                    <span class="card-icon">💾</span>
                    Storage Settings
                </h3>
            </div>
            <div class="card-body">
                <div class="settings-grid">
                    <div class="settings-section">
                        <h4 class="section-title">Storage Usage (Your Files Only)</h4>
                        <div class="info-group">
                            <div class="info-item">
                                <label>Used Space</label>
                                <span class="info-value"><?php echo $used_space_mb; ?> MB</span>
                            </div>
                            <div class="info-item">
                                <label>Available Space</label>
                                <span class="info-value"><?php echo $available_space_mb; ?> MB</span>
                            </div>
                            <div class="storage-progress">
                                <div class="progress-label">Storage Usage: <?php echo $usage_percentage; ?>%</div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: <?php echo $usage_percentage; ?>%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="settings-section">
                        <h4 class="section-title">File Management</h4>
                        <div class="info-group">
                            <div class="info-item">
                                <label>Your Total Files</label>
                                <span class="info-value"><?php echo $file_count; ?></span>
                            </div>
                        </div>
                        <form method="POST" style="display: inline;">
                            <button type="submit" name="cleanup_files" class="btn secondary-btn" 
                                    onclick="return confirm('This will delete YOUR files older than 30 days. Are you sure?')">
                                Clean Up My Files
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Actions -->
        <div class="settings-card danger-card">
            <div class="card-header danger-header">
                <h3 class="card-title">
                    <span class="card-icon">⚠️</span>
                    Account Actions
                </h3>
            </div>
            <div class="card-body">
                <div class="danger-section">
                    <h4 class="danger-title">Logout</h4>
                    <p class="danger-description">End your current session and return to the login page.</p>
                    <a href="logout.php" class="btn danger-btn">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>