<?php
/**
 * Get User Profile API
 * FlatFinders - Property Rental Platform
 */

require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../includes/functions.php';

// Only allow GET requests
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    jsonResponse(false, 'Method not allowed', null, 405);
}

// Verify user session
$currentUser = verifySession();

// Get user ID from query parameter or use current user
$userId = isset($_GET['id']) ? intval($_GET['id']) : $currentUser['user_id'];

// Get database connection
$conn = getDbConnection();

// Get user profile
$stmt = $conn->prepare("
    SELECT id, name, email, phone, role, profile_image, status, 
           email_verified, created_at, last_login
    FROM users 
    WHERE id = ?
");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    closeDbConnection($conn);
    jsonResponse(false, 'User not found', null, 404);
}

$user = $result->fetch_assoc();
$stmt->close();

// If owner, get property statistics
if ($user['role'] === 'owner') {
    $statsStmt = $conn->prepare("
        SELECT 
            COUNT(*) as total_properties,
            SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved_properties,
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_properties,
            SUM(views) as total_views
        FROM properties
        WHERE owner_id = ?
    ");
    $statsStmt->bind_param("i", $userId);
    $statsStmt->execute();
    $statsResult = $statsStmt->get_result();
    $user['property_stats'] = $statsResult->fetch_assoc();
    $statsStmt->close();
}

// If customer, get favorites count
if ($user['role'] === 'customer') {
    $favStmt = $conn->prepare("SELECT COUNT(*) as total FROM favorites WHERE user_id = ?");
    $favStmt->bind_param("i", $userId);
    $favStmt->execute();
    $favResult = $favStmt->get_result();
    $user['favorites_count'] = $favResult->fetch_assoc()['total'];
    $favStmt->close();
}

closeDbConnection($conn);

// Remove sensitive data
unset($user['password_hash']);

jsonResponse(true, 'Profile retrieved successfully', ['user' => $user]);
?>
