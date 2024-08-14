<?php
session_start();

// Check if a user session is set. If so, redirect to the admin page; otherwise, redirect to the login page. 
// In both cases, stop further script execution.
if (isset($_SESSION['user'])) {
    header("Location: admin.php");
    exit;
} else {
    header("Location: login.php");
    exit;
}
?>
