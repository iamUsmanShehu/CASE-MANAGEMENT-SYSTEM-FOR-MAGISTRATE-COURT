<?php
session_start();

// Destroy session
session_unset(); // Remove all session variables
session_destroy(); // Destroy the session

// Redirect to login page
header("Location: index.php");
exit();
?>
