<?php
/**
 * Update User Profile API
 * FlatFinders - Property Rental Platform
 */

require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../includes/functions.php';

// Only allow POST/PUT requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'PUT') {
    jsonResponse(false, 'Method not allowed', null, 405);
}

// Verify user session
$currentUser = verifySession();
$userId = $currentUser['user_id'];

// Get input data
$input = json_decode(file_get_contents('php://input'), true);

// Get database connection
$conn = getDbConnection();

// Validate and prepare update fields
$updateFields = [];
$params = [];
$types = '';

// Name update
if (isset($input['name']) && !empty(trim($input['name']))) {
    $updateFields[] = "name = ?";
    $params[] = sanitizeInput($input['name']);
    $types .= 's';
}

// Phone update
if (isset($input['phone'])) {
    $updateFields[] = "phone = ?";
    $params[] = sanitizeInput($input['phone']);
    $types .= 's';
}

// Profile image update
if (isset($input['profile_image'])) {
    $updateFields[] = "profile_image = ?";
    $params[] = sanitizeInput($input['profile_image']);
    $types .= 's';
}

// Password update (if provided)
if (isset($input['current_password']) && isset($input['new_password'])) {
    // Verify current password
    $verifyStmt = $conn->prepare("SELECT password_hash FROM users WHERE id = ?");
    $verifyStmt->bind_param("i", $userId);
    $verifyStmt->execute();
    $verifyResult = $verifyStmt->get_result();
    $userData = $verifyResult->fetch_assoc();
    $verifyStmt->close();
    
    if (!verifyPassword($input['current_password'], $userData['password_hash'])) {
        closeDbConnection($conn);
        jsonResponse(false, 'Current password is incorrect', null, 400);
    }
    
    // Validate new password
    if (strlen($input['new_password']) < PASSWORD_MIN_LENGTH) {
        closeDbConnection($conn);
        jsonResponse(false, 'New password must be at least ' . PASSWORD_MIN_LENGTH . ' characters', null, 400);
    }
    
    $updateFields[] = "password_hash = ?";
    $params[] = hashPassword($input['new_password']);
    $types .= 's';
}

// Check if there are fields to update
if (empty($updateFields)) {
    closeDbConnection($conn);
    jsonResponse(false, 'No fields to update', null, 400);
}

// Build and execute update query
$sql = "UPDATE users SET " . implode(", ", $updateFields) . " WHERE id = ?";
$params[] = $userId;
$types .= 'i';

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
    $stmt->close();
    
    // Get updated user data
    $userStmt = $conn->prepare("
        SELECT id, name, email, phone, role, profile_image, status 
        FROM users 
        WHERE id = ?
    ");
    $userStmt->bind_param("i", $userId);
    $userStmt->execute();
    $result = $userStmt->get_result();
    $updatedUser = $result->fetch_assoc();
    $userStmt->close();
    
    // Update session
    $_SESSION['user_name'] = $updatedUser['name'];
    
    closeDbConnection($conn);
    jsonResponse(true, 'Profile updated successfully', ['user' => $updatedUser]);
} else {
    $stmt->close();
    closeDbConnection($conn);
    jsonResponse(false, 'Failed to update profile', null, 500);
}
?>
