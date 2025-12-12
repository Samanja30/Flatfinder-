<?php
/**
 * Check Session API
 * FlatFinders - Property Rental Platform
 */

require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../includes/functions.php';

// Only allow GET requests
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    jsonResponse(false, 'Method not allowed', null, 405);
}

// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    jsonResponse(false, 'No active session', null, 401);
}

// Get database connection
$conn = getDbConnection();

// Get user data
$stmt = $conn->prepare("
    SELECT id, name, email, phone, role, status, profile_image 
    FROM users 
    WHERE id = ?
");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    closeDbConnection($conn);
    
    // Destroy invalid session
    session_destroy();
    jsonResponse(false, 'Invalid session', null, 401);
}

$user = $result->fetch_assoc();
$stmt->close();
closeDbConnection($conn);

// Check if account is still active
if ($user['status'] !== 'active') {
    session_destroy();
    jsonResponse(false, 'Account is no longer active', null, 403);
}

// Return user data
jsonResponse(true, 'Session is valid', ['user' => [
    'id' => $user['id'],
    'name' => $user['name'],
    'email' => $user['email'],
    'phone' => $user['phone'],
    'role' => $user['role'],
    'profile_image' => $user['profile_image']
]]);
?>

