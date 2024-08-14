<?php
session_start();

// Clear all session variables and destroy the session
session_unset();    // Remove all session variables
session_destroy(); // Destroy the session

// Redirect the user to the login page and stop further script execution
header('Location: login.php');
exit;

