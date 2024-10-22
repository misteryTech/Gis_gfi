<?php
// Start the session
session_start();

// Destroy all session data
session_unset();        // Free all session variables
session_destroy();      // Destroy the session

// Redirect to login or home page
header("Location: ../student_login.php");  // Change this to the page you want to redirect to
exit();
?>
