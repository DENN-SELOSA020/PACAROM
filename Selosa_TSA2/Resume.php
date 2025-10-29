<?php
require('requires/header.php');

$page = $_GET['page'] ?? 'personal';

switch ($page) {
    case 'career':
        include('includes/career.php');
        break;
    case 'education':
        include('includes/education.php');
        break;
    case 'skills':
        include('includes/skills.php');
        break;
    case 'affiliation':
        include('includes/affiliation.php');
        break;
    case 'work':
        include('includes/work.php');
        break;
    default:
        include('includes/personal.php');
        break;
}

require('requires/footer.php');
?>