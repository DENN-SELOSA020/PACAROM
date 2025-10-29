<?php
session_start();
require "includes/dbconnection.php";

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) { 
    header("Location: login.php"); 
    exit(); 
}

function formatFileSize($bytes) {
    if ($bytes == 0) return '0 B';
    
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $base = log($bytes, 1024);
    $unit = floor($base);
    
    return round(pow(1024, $base - $unit), 2) . ' ' . $units[$unit];
}

$user_id = $_SESSION['user_id'];
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

$available_space = $max_storage - $total_size;
$usage_percentage = round(($total_size / $max_storage) * 100, 1);
$available_space_mb = round($available_space / (1024 * 1024), 2);

$storage_full = $total_size >= $max_storage;
$storage_almost_full = $usage_percentage >= 95;

error_log("Dashboard - User ID: $user_id, Total size: $total_size, Max storage: $max_storage, Available: $available_space, Storage full: " . ($storage_full ? 'YES' : 'NO'));

include("includes/header.php");

?>

<link rel="stylesheet" href="dashboard.css?v=<?php echo time(); ?>">
<div class="container-fluid dashboard-container">
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <p class="text-muted">Welcome back!</p>
                <h2><?php echo htmlspecialchars($_SESSION['username']); ?></h2>
                
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-info">
                <strong>Notice:</strong> 
                Total Size: <?php echo round($total_size / (1024*1024), 2); ?>MB | 
                Max Storage: <?php echo round($max_storage / (1024*1024*1024), 2); ?>GB | 
                Available: <?php echo $available_space_mb; ?>MB | 
                Usage: <?php echo $usage_percentage; ?>% | 
                Storage Full: <?php echo $storage_full ? 'YES' : 'NO'; ?>
            </div>
        </div>
    </div>

    <?php if (isset($_GET['error'])): ?>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                    <?php 
                        if ($_GET['error'] == 'storage_full') {
                            echo "Upload failed: Your storage is full! You have exceeded your 16GB limit.";
                        } elseif ($_GET['error'] == 'file_too_large') {
                            echo "Upload failed: File is too large. Maximum file upload size is 1GB.";
                        } elseif ($_GET['error'] == 'upload_failed') {
                            echo "Upload failed: Could not upload the file.";
                        }
                    ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['success']) && $_GET['success'] == 'uploaded'): ?>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success">
                    <span class="glyphicon glyphicon-ok"></span>
                    File uploaded successfully!
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($storage_full): ?>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                    <strong>Storage Full!</strong> You have reached your 16GB storage limit. Please delete some files before uploading new ones.
                </div>
            </div>
        </div>
    <?php elseif ($storage_almost_full): ?>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-warning">
                    <span class="glyphicon glyphicon-warning-sign"></span>
                    <strong>Storage Almost Full!</strong> You are using <?php echo $usage_percentage; ?>% of your storage (<?php echo $available_space_mb; ?>MB remaining).
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <div class="split-view-container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-icon">
                    <span class="glyphicon glyphicon-cloud-upload"></span>
                </div>
                <h3 class="panel-title">Upload Files</h3>
            </div>
            <div class="panel-body">
                <p class="upload-section-header">Drag & drop or browse to upload your files</p>
                
                <?php if ($storage_full): ?>
                    <div class="upload-area disabled" id="uploadArea">
                        <div class="upload-icon">
                            <span class="glyphicon glyphicon-ban-circle"></span>
                        </div>
                        <div class="upload-text">Storage Full</div>
                        <div class="upload-subtext">Delete some files to free up space</div>
                        
                        <div class="file-formats">
                            Available Space: 0 MB | Total Limit: 16GB
                        </div>
                    </div>
                    
                    <button type="button" class="btn btn-danger btn-block" style="margin-top: 20px;" disabled>
                        <span class="glyphicon glyphicon-ban-circle"></span> Upload Disabled
                    </button>
                <?php else: ?>
                    <form action="upload.php" method="post" enctype="multipart/form-data" id="uploadForm">
                        <div class="upload-area" id="uploadArea">
                            <div class="upload-icon">
                                <span class="glyphicon glyphicon-cloud-upload"></span>
                            </div>
                            <div class="upload-text">Drop files here</div>
                            <div class="upload-subtext">or click to browse</div>
                            
                            <input type="file" name="userfile" id="userfile" required onchange="checkFileSize(this)">
                            <label for="userfile" class="file-browse-btn">
                                <span class="glyphicon glyphicon-folder-open"></span>
                                Choose Files
                            </label>
                            
                            <div class="file-formats">
                                Supports all file types • Maximum size: 1GB
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-block" style="margin-top: 20px;" id="uploadBtn">
                            <span class="glyphicon glyphicon-upload"></span> Upload File
                        </button>
                    </form>

                    <script>
                    function checkFileSize(input) {
                        const file = input.files[0];
                        const uploadBtn = document.getElementById('uploadBtn');
                        const availableSpace = <?php echo $available_space; ?>;
                        const maxFileSize = 1024 * 1024 * 1024;
                        
                        if (file) {
                            if (file.size > maxFileSize) {
                                alert('File is too large! Maximum file upload size is 1GB.');
                                input.value = '';
                                uploadBtn.disabled = true;
                                return;
                            }
                            
                            if (file.size > availableSpace) {
                                alert('File is too large for available space! You only have <?php echo $available_space_mb; ?>MB remaining.');
                                input.value = '';
                                uploadBtn.disabled = true;
                                return;
                            }
                            
                            uploadBtn.disabled = false;
                        }
                    }
                    </script>
                <?php endif; ?>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-icon">
                    <span class="glyphicon glyphicon-folder-open"></span>
                </div>
                <h3 class="panel-title">Your Files</h3>
            </div>
            <div class="panel-body">
                <p class="files-section-header">View and manage your uploaded files</p>
                
                <div class="search-sort-container">
                    <div class="search-container">
                        <span class="search-icon glyphicon glyphicon-search"></span>
                        <input type="text" class="search-input" id="fileSearch" placeholder="Search files..." onkeyup="searchFiles()">
                    </div>
                    <select class="sort-dropdown" id="sortDropdown" onchange="sortFiles()">
                        <option value="newest">🔄 Newest First</option>
                        <option value="oldest">Oldest First</option>
                        <option value="name">Name A-Z</option>
                        <option value="size">File Size</option>
                    </select>
                </div>

                <?php
                if (isset($_SESSION['user_id'])) {
                    $user_id = intval($_SESSION['user_id']);
                    $stmt = $db->prepare("SELECT * FROM files WHERE user_id = ?");
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $files = $stmt->get_result();

                    if ($files->num_rows > 0) {
                        echo '<div class="table-responsive">';
                        echo '<table class="table table-striped table-hover" id="filesTable">';
                        echo '<thead><tr>';
                        echo '<th><span class="glyphicon glyphicon-file"></span> File Name</th>';
                        echo '<th><span class="glyphicon glyphicon-hdd"></span> File Size</th>';
                        echo '<th><span class="glyphicon glyphicon-time"></span> Upload Date</th>';
                        echo '<th><span class="glyphicon glyphicon-cog"></span> Actions</th>';
                        echo '</tr></thead><tbody id="filesTableBody">';

                        while($file = $files->fetch_assoc()) {
                            $file_size = 0;
                            $file_size_formatted = 'N/A';
                            if (file_exists($file['filepath'])) {
                                $file_size = filesize($file['filepath']);
                                $file_size_formatted = formatFileSize($file_size);
                            }
                            
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($file['filename']) . '</td>';
                            echo '<td class="file-size-cell" data-size="' . $file_size . '">' . $file_size_formatted . '</td>';
                            echo '<td>' . (isset($file['upload_date']) ? date('M j, Y', strtotime($file['upload_date'])) : 'N/A') . '</td>';
                            echo '<td>';
                            echo '<a href="download.php?id=' . intval($file['id']) . '" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-download"></span> Download</a> ';
                            echo '<a href="delete.php?id=' . intval($file['id']) . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this file?\');"><span class="glyphicon glyphicon-trash"></span> Delete</a>';
                            echo '</td></tr>';
                        }

                        echo '</tbody></table></div>';
                    } else {
                        echo '<div class="empty-state">';
                        echo '<div class="empty-state-icon">📁</div>';
                        echo '<h3>No files yet</h3>';
                        echo '<p>Upload your first file to get started!</p>';
                        echo '</div>';
                    }

                    $stmt->close();
                } else {
                    echo '<div class="alert alert-danger text-center">';
                    echo '<span class="glyphicon glyphicon-exclamation-sign"></span> Session error. Please log in again.';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
function searchFiles() {
    const searchInput = document.getElementById('fileSearch');
    const searchTerm = searchInput.value.toLowerCase();
    const table = document.getElementById('filesTable');
    const tbody = document.getElementById('filesTableBody');
    const emptyState = document.querySelector('.empty-state');
    
    if (!table) return;
    
    const rows = tbody.getElementsByTagName('tr');
    let visibleRows = 0;
    
    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const fileName = row.cells[0].textContent.toLowerCase();
        const fileSize = row.cells[1].textContent.toLowerCase();
        const uploadDate = row.cells[2].textContent.toLowerCase();
        
        if (fileName.includes(searchTerm) || fileSize.includes(searchTerm) || uploadDate.includes(searchTerm)) {
            row.style.display = '';
            visibleRows++;
        } else {
            row.style.display = 'none';
        }
    }
    
    if (visibleRows === 0 && searchTerm !== '') {
        if (!document.getElementById('noResultsMessage')) {
            const noResultsDiv = document.createElement('div');
            noResultsDiv.id = 'noResultsMessage';
            noResultsDiv.className = 'empty-state';
            noResultsDiv.innerHTML = `
                <div class="empty-state-icon">🔍</div>
                <h3>No files found</h3>
                <p>No files match your search for "${searchInput.value}"</p>
            `;
            table.parentNode.appendChild(noResultsDiv);
        }
        table.style.display = 'none';
    } else {
        table.style.display = '';
        const noResultsMessage = document.getElementById('noResultsMessage');
        if (noResultsMessage) {
            noResultsMessage.remove();
        }
    }
}

function sortFiles() {
    const sortValue = document.getElementById('sortDropdown').value;
    const tbody = document.getElementById('filesTableBody');
    
    if (!tbody) return;
    
    const rows = Array.from(tbody.getElementsByTagName('tr'));
    
    rows.sort((a, b) => {
        let aValue, bValue;
        
        switch(sortValue) {
            case 'name':
                aValue = a.cells[0].textContent.toLowerCase();
                bValue = b.cells[0].textContent.toLowerCase();
                return aValue.localeCompare(bValue);
                
            case 'size':
                aValue = parseInt(a.cells[1].getAttribute('data-size')) || 0;
                bValue = parseInt(b.cells[1].getAttribute('data-size')) || 0;
                return bValue - aValue;
                
            case 'newest':
                aValue = new Date(a.cells[2].textContent);
                bValue = new Date(b.cells[2].textContent);
                return bValue - aValue;
                
            case 'oldest':
                aValue = new Date(a.cells[2].textContent);
                bValue = new Date(b.cells[2].textContent);
                return aValue - bValue;
                
            default:
                return 0;
        }
    });
    
    tbody.innerHTML = '';
    rows.forEach(row => tbody.appendChild(row));
}

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('fileSearch');
    if (searchInput) {
        searchInput.value = '';
    }
});
</script>