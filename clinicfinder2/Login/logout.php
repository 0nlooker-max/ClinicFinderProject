<?php
session_start();

// Clear all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect the user to the login page
header('Location: login.php');
exit;
?>
