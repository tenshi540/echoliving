<?php
// Start or resume the session
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect back to the login page (adjust path as needed)
header('Location: /echoliving/frontend/res/pages/login.php');
exit;