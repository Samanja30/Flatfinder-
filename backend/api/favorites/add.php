<?php
/**
 * Add to Favorites API
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

// Validate property_id
if (!isset($input['property_id']) || empty($input['property_id'])) {
    jsonResponse(false, 'Property ID is required', null, 400);
}

$propertyId = intval($input['property_id']);

// Get database connection
$conn = getDbConnection();

// Check if property exists
$checkStmt = $conn->prepare("SELECT id FROM properties WHERE id = ? AND status = 'approved'");
$checkStmt->bind_param("i", $propertyId);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows === 0) {
    $checkStmt->close();
    closeDbConnection($conn);
    jsonResponse(false, 'Property not found', null, 404);
}
$checkStmt->close();

// Check if already in favorites
$favCheckStmt = $conn->prepare("SELECT id FROM favorites WHERE user_id = ? AND property_id = ?");
$favCheckStmt->bind_param("ii", $user['user_id'], $propertyId);
$favCheckStmt->execute();
$favCheckResult = $favCheckStmt->get_result();

if ($favCheckResult->num_rows > 0) {
    $favCheckStmt->close();
    closeDbConnection($conn);
    jsonResponse(false, 'Property already in favorites', null, 409);
}
$favCheckStmt->close();

// Add to favorites
$stmt = $conn->prepare("INSERT INTO favorites (user_id, property_id) VALUES (?, ?)");
$stmt->bind_param("ii", $user['user_id'], $propertyId);

if ($stmt->execute()) {
    $favoriteId = $conn->insert_id;
    $stmt->close();
    closeDbConnection($conn);
    jsonResponse(true, 'Property added to favorites', ['favorite_id' => $favoriteId], 201);
} else {
    $stmt->close();
    closeDbConnection($conn);
    jsonResponse(false, 'Failed to add to favorites', null, 500);
}
?>

