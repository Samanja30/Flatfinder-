<?php
/**
 * Remove from Favorites API
 * FlatFinders - Property Rental Platform
 */

require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../includes/functions.php';

// Only allow DELETE/POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Method not allowed', null, 405);
}

// Verify user is logged in
$user = verifySession();

// Get property ID
if (!isset($_GET['property_id']) || empty($_GET['property_id'])) {
    jsonResponse(false, 'Property ID is required', null, 400);
}

$propertyId = intval($_GET['property_id']);

// Get database connection
$conn = getDbConnection();

// Remove from favorites
$stmt = $conn->prepare("DELETE FROM favorites WHERE user_id = ? AND property_id = ?");
$stmt->bind_param("ii", $user['user_id'], $propertyId);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        $stmt->close();
        closeDbConnection($conn);
        jsonResponse(true, 'Property removed from favorites');
    } else {
        $stmt->close();
        closeDbConnection($conn);
        jsonResponse(false, 'Property not in favorites', null, 404);
    }
} else {
    $stmt->close();
    closeDbConnection($conn);
    jsonResponse(false, 'Failed to remove from favorites', null, 500);
}
?>

