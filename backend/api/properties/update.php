<?php
/**
 * Update Property API
 * FlatFinders - Property Rental Platform
 */

require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../includes/functions.php';

// Only allow PUT requests
if ($_SERVER['REQUEST_METHOD'] !== 'PUT' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Method not allowed', null, 405);
}

// Verify user is logged in
$user = verifySession();

// Get property ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    jsonResponse(false, 'Property ID is required', null, 400);
}

$propertyId = intval($_GET['id']);

// Get input data
$input = json_decode(file_get_contents('php://input'), true);

// Get database connection
$conn = getDbConnection();

// Check if property exists and user has permission
$checkStmt = $conn->prepare("SELECT owner_id, status FROM properties WHERE id = ?");
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

// Check permissions (owner can edit own properties, admin can edit all)
if ($property['owner_id'] !== $user['user_id'] && $user['role'] !== 'admin') {
    closeDbConnection($conn);
    jsonResponse(false, 'You do not have permission to edit this property', null, 403);
}

// Build update query
$updateFields = [];
$params = [];
$types = '';

$allowedFields = [
    'title' => 's', 'description' => 's', 'price' => 'd', 'bedrooms' => 'i',
    'bathrooms' => 'i', 'area_sqft' => 'i', 'floor' => 's', 'location' => 's',
    'address' => 's', 'nearby_places' => 's', 'contact_name' => 's',
    'contact_phone' => 's', 'contact_email' => 's', 'is_bachelor_only' => 'i',
    'is_furnished' => 'i', 'available_from' => 's'
];

foreach ($allowedFields as $field => $type) {
    if (isset($input[$field])) {
        $updateFields[] = "$field = ?";
        $params[] = $type === 's' ? sanitizeInput($input[$field]) : $input[$field];
        $types .= $type;
    }
}

if (empty($updateFields)) {
    closeDbConnection($conn);
    jsonResponse(false, 'No fields to update', null, 400);
}

// Update property
$sql = "UPDATE properties SET " . implode(", ", $updateFields) . " WHERE id = ?";
$params[] = $propertyId;
$types .= 'i';

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
    $stmt->close();
    closeDbConnection($conn);
    jsonResponse(true, 'Property updated successfully');
} else {
    $stmt->close();
    closeDbConnection($conn);
    jsonResponse(false, 'Failed to update property', null, 500);
}
?>

