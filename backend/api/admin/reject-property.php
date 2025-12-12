<?php
/**
 * Reject Property API (Admin Only)
 * FlatFinders - Property Rental Platform
 */

require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../includes/functions.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Method not allowed', null, 405);
}

// Verify user is admin
$user = requireRole(['admin']);

// Get property ID and reason
$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['property_id']) || empty($input['property_id'])) {
    jsonResponse(false, 'Property ID is required', null, 400);
}

$propertyId = intval($input['property_id']);
$reason = isset($input['reason']) ? sanitizeInput($input['reason']) : 'Property did not meet our guidelines';

// Get database connection
$conn = getDbConnection();

// Check if property exists
$checkStmt = $conn->prepare("SELECT id, owner_id, title FROM properties WHERE id = ?");
$checkStmt->bind_param("i", $propertyId);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows === 0) {
    $checkStmt->close();
    closeDbConnection($conn);
    jsonResponse(false, 'Property not found', null, 404);
}

$property = $checkResult->fetch_assoc();
$checkStmt->close();

// Update property status
$stmt = $conn->prepare("UPDATE properties SET status = 'rejected' WHERE id = ?");
$stmt->bind_param("i", $propertyId);

if ($stmt->execute()) {
    $stmt->close();
    
    // Create notification for property owner
    $notifStmt = $conn->prepare("
        INSERT INTO notifications (user_id, title, message, type, link) 
        VALUES (?, ?, ?, 'warning', ?)
    ");
    $notifTitle = "Property Rejected";
    $notifMessage = "Your property '{$property['title']}' was rejected. Reason: $reason";
    $notifLink = "/owner-dashboard.html";
    $notifStmt->bind_param("isss", $property['owner_id'], $notifTitle, $notifMessage, $notifLink);
    $notifStmt->execute();
    $notifStmt->close();
    
    closeDbConnection($conn);
    jsonResponse(true, 'Property rejected successfully');
} else {
    $stmt->close();
    closeDbConnection($conn);
    jsonResponse(false, 'Failed to reject property', null, 500);
}
?>

