<?php
session_start();
// Clear all session data
$_SESSION = [];
session_destroy();

// Clear the “remember me” cookie (if used)
setcookie('remember_me', '', time() - 3600, '/echoliving');

// Redirect back to login (or home)  
header('Location: /echoliving/frontend/res/pages/login.php');
exit;
