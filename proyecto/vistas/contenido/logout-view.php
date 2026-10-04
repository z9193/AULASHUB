<?php
// 1. Only start session if one isn't already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Clear all session variables
$_SESSION = array();

// 3. Destroy the session
session_destroy();

// 4. Redirect (This will work now because we suppressed the Notice)
header("Location: " . SERVERURL . "login/");
exit();