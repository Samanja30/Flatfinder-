<?php
/**
 * Delete Property API
 * FlatFinders - Property Rental Platform
 */

require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../includes/functions.php';

// Only allow DELETE requests
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Method not allowed', null, 405);
}

// Verify user is logged in
$user = verifySession();

// Get property ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    jsonResponse(false, 'Property ID is required', null, 400);
}

$propertyId = intval($_GET['id']);

// Get database connection
$conn = getDbConnection();

// Check if property exists and user has permission
$checkStmt = $conn->prepare("SELECT owner_id FROM properties WHERE id = ?");
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

// Check permissions (owner can delete own properties, admin can delete all)
if ($property['owner_id'] !== $user['user_id'] && $user['role'] !== 'admin') {
    closeDbConnection($conn);
    jsonResponse(false, 'You do not have permission to delete this property', null, 403);
}

// Get property images to delete files
$imageStmt = $conn->prepare("SELECT image_path FROM property_images WHERE property_id = ?");
$imageStmt->bind_param("i", $propertyId);
$imageStmt->execute();
$imageResult = $imageStmt->get_result();

$imagePaths = [];
while ($img = $imageResult->fetch_assoc()) {
    $imagePaths[] = $img['image_path'];
}
$imageStmt->close();

// Delete property (cascades to images and amenities)
$deleteStmt = $conn->prepare("DELETE FROM properties WHERE id = ?");
$deleteStmt->bind_param("i", $propertyId);

if ($deleteStmt->execute()) {
    $deleteStmt->close();
    closeDbConnection($conn);
    
    // Delete image files from disk
    foreach ($imagePaths as $path) {
        deleteImage($path);
    }
    
    jsonResponse(true, 'Property deleted successfully');
} else {
    $deleteStmt->close();
    closeDbConnection($conn);
    jsonResponse(false, 'Failed to delete property', null, 500);
}
?>

