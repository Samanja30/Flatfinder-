<?php
/**
 * Approve Property API (Admin Only)
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

// Get property ID
$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['property_id']) || empty($input['property_id'])) {
    jsonResponse(false, 'Property ID is required', null, 400);
}

$propertyId = intval($input['property_id']);

// Get database connection
$conn = getDbConnection();

// Check if property exists
$checkStmt = $conn->prepare("SELECT id, owner_id, title, status FROM properties WHERE id = ?");
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

// Check if already approved
if ($property['status'] === 'approved') {
    closeDbConnection($conn);
    jsonResponse(false, 'Property is already approved', null, 400);
}

// Update property status
$stmt = $conn->prepare("UPDATE properties SET status = 'approved' WHERE id = ?");
$stmt->bind_param("i", $propertyId);

if ($stmt->execute()) {
    $stmt->close();
    
    // Create notification for property owner
    $notifStmt = $conn->prepare("
        INSERT INTO notifications (user_id, title, message, type, link) 
        VALUES (?, ?, ?, 'success', ?)
    ");
    $notifTitle = "Property Approved";
    $notifMessage = "Your property '{$property['title']}' has been approved and is now live!";
    $notifLink = "/property-detail.html?id=$propertyId";
    $notifStmt->bind_param("isss", $property['owner_id'], $notifTitle, $notifMessage, $notifLink);
    $notifStmt->execute();
    $notifStmt->close();
    
    closeDbConnection($conn);
    jsonResponse(true, 'Property approved successfully');
} else {
    $stmt->close();
    closeDbConnection($conn);
    jsonResponse(false, 'Failed to approve property', null, 500);
}
?>

