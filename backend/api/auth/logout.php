<?php
/**
 * User Logout API
 * FlatFinders - Property Rental Platform
 */

require_once '../../config/config.php';

// Start session
session_start();

// Destroy all session data
$_SESSION = array();

// Delete session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-3600, '/');
}

// Destroy session
session_destroy();

// Return response
header('Content-Type: application/json; charset=UTF-8');
echo json_encode([
    'success' => true,
    'message' => 'Logged out successfully'
]);
exit();
?>

