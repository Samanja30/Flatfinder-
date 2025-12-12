<?php
/**
 * Mark Notification as Read API
 * FlatFinders - Property Rental Platform
 */

require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../includes/functions.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Method not allowed', null, 405);
}

// Verify user is logged in
$user = verifySession();

// Get input data
$input = json_decode(file_get_contents('php://input'), true);

// Get database connection
$conn = getDbConnection();

// Check if marking all as read
if (isset($input['mark_all']) && $input['mark_all'] === true) {
    $stmt = $conn->prepare("
        UPDATE notifications 
        SET is_read = 1, read_at = NOW() 
        WHERE user_id = ? AND is_read = 0
    ");
    $stmt->bind_param("i", $user['user_id']);
    
    if ($stmt->execute()) {
        $affectedRows = $stmt->affected_rows;
        $stmt->close();
        closeDbConnection($conn);
        jsonResponse(true, "Marked $affectedRows notifications as read");
    } else {
        $stmt->close();
        closeDbConnection($conn);
        jsonResponse(false, 'Failed to mark notifications as read', null, 500);
    }
} else {
    // Mark single notification as read
    if (!isset($input['notification_id']) || empty($input['notification_id'])) {
        jsonResponse(false, 'Notification ID is required', null, 400);
    }
    
    $notificationId = intval($input['notification_id']);
    
    $stmt = $conn->prepare("
        UPDATE notifications 
        SET is_read = 1, read_at = NOW() 
        WHERE id = ? AND user_id = ?
    ");
    $stmt->bind_param("ii", $notificationId, $user['user_id']);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $stmt->close();
            closeDbConnection($conn);
            jsonResponse(true, 'Notification marked as read');
        } else {
            $stmt->close();
            closeDbConnection($conn);
            jsonResponse(false, 'Notification not found or already read', null, 404);
        }
    } else {
        $stmt->close();
        closeDbConnection($conn);
        jsonResponse(false, 'Failed to mark notification as read', null, 500);
    }
}
?>
