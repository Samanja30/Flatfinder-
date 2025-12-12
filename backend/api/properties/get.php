<?php
/**
 * Get Single Property API
 * FlatFinders - Property Rental Platform
 */

require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../includes/functions.php';

// Only allow GET requests
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    jsonResponse(false, 'Method not allowed', null, 405);
}

// Get property ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    jsonResponse(false, 'Property ID is required', null, 400);
}

$propertyId = intval($_GET['id']);

// Get database connection
$conn = getDbConnection();

// Get property details
$stmt = $conn->prepare("
    SELECT 
        p.*,
        u.name as owner_name,
        u.email as owner_email,
        u.phone as owner_phone
    FROM properties p
    LEFT JOIN users u ON p.owner_id = u.id
    WHERE p.id = ? AND p.status = 'approved'
");
$stmt->bind_param("i", $propertyId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    closeDbConnection($conn);
    jsonResponse(false, 'Property not found', null, 404);
}

$property = $result->fetch_assoc();
$stmt->close();

// Get property images
$imageStmt = $conn->prepare("
    SELECT image_path, is_primary, display_order 
    FROM property_images 
    WHERE property_id = ? 
    ORDER BY is_primary DESC, display_order ASC
");
$imageStmt->bind_param("i", $propertyId);
$imageStmt->execute();
$imageResult = $imageStmt->get_result();

$images = [];
while ($img = $imageResult->fetch_assoc()) {
    $images[] = [
        'path' => $img['image_path'],
        'is_primary' => (bool)$img['is_primary']
    ];
}
$imageStmt->close();

// Get property amenities
$amenityStmt = $conn->prepare("
    SELECT a.name, a.icon 
    FROM property_amenities pa
    JOIN amenities a ON pa.amenity_id = a.id
    WHERE pa.property_id = ?
    ORDER BY a.display_order
");
$amenityStmt->bind_param("i", $propertyId);
$amenityStmt->execute();
$amenityResult = $amenityStmt->get_result();

$amenities = [];
while ($amenity = $amenityResult->fetch_assoc()) {
    $amenities[] = [
        'name' => $amenity['name'],
        'icon' => $amenity['icon']
    ];
}
$amenityStmt->close();

// Increment view count
$viewStmt = $conn->prepare("UPDATE properties SET views = views + 1 WHERE id = ?");
$viewStmt->bind_param("i", $propertyId);
$viewStmt->execute();
$viewStmt->close();

// Track recently viewed (if user is logged in)
session_start();
if (isset($_SESSION['user_id'])) {
    $viewedStmt = $conn->prepare("
        INSERT INTO recently_viewed (user_id, property_id, viewed_at) 
        VALUES (?, ?, NOW())
    ");
    $viewedStmt->bind_param("ii", $_SESSION['user_id'], $propertyId);
    $viewedStmt->execute();
    $viewedStmt->close();
}

closeDbConnection($conn);

// Prepare response
$response = [
    'id' => $property['id'],
    'title' => $property['title'],
    'description' => $property['description'],
    'type' => $property['property_type'],
    'price' => floatval($property['price']),
    'bedrooms' => $property['bedrooms'],
    'bathrooms' => $property['bathrooms'],
    'area_sqft' => $property['area_sqft'],
    'floor' => $property['floor'],
    'location' => $property['location'],
    'city' => $property['city'],
    'address' => $property['address'],
    'nearby_places' => $property['nearby_places'],
    'is_bachelor_only' => (bool)$property['is_bachelor_only'],
    'is_furnished' => (bool)$property['is_furnished'],
    'contact_name' => $property['contact_name'],
    'contact_phone' => $property['contact_phone'],
    'contact_email' => $property['contact_email'],
    'views' => $property['views'] + 1,
    'featured' => (bool)$property['featured'],
    'available_from' => $property['available_from'],
    'created_at' => $property['created_at'],
    'images' => $images,
    'amenities' => $amenities,
    'owner' => [
        'name' => $property['owner_name'],
        'email' => $property['owner_email'],
        'phone' => $property['owner_phone']
    ]
];

jsonResponse(true, 'Property retrieved successfully', ['property' => $response]);
?>

