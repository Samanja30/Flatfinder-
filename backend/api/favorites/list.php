<?php
/**
 * List Favorites API
 * FlatFinders - Property Rental Platform
 */

require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../includes/functions.php';

// Only allow GET requests
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    jsonResponse(false, 'Method not allowed', null, 405);
}

// Verify user is logged in
$user = verifySession();

// Get database connection
$conn = getDbConnection();

// Get user's favorite properties
$stmt = $conn->prepare("
    SELECT 
        f.id as favorite_id, f.created_at as favorited_at,
        p.id, p.title, p.description, p.property_type, p.price, p.bedrooms, 
        p.bathrooms, p.area_sqft, p.location, p.city, p.is_bachelor_only,
        p.contact_name, p.contact_phone, p.contact_email,
        (SELECT image_path FROM property_images WHERE property_id = p.id AND is_primary = 1 LIMIT 1) as primary_image
    FROM favorites f
    JOIN properties p ON f.property_id = p.id
    WHERE f.user_id = ? AND p.status = 'approved'
    ORDER BY f.created_at DESC
");
$stmt->bind_param("i", $user['user_id']);
$stmt->execute();
$result = $stmt->get_result();

$favorites = [];
while ($row = $result->fetch_assoc()) {
    $favorites[] = [
        'favorite_id' => $row['favorite_id'],
        'favorited_at' => $row['favorited_at'],
        'property' => [
            'id' => $row['id'],
            'title' => $row['title'],
            'description' => substr($row['description'], 0, 150) . '...',
            'type' => $row['property_type'],
            'price' => floatval($row['price']),
            'bedrooms' => $row['bedrooms'],
            'bathrooms' => $row['bathrooms'],
            'area_sqft' => $row['area_sqft'],
            'location' => $row['location'],
            'city' => $row['city'],
            'is_bachelor_only' => (bool)$row['is_bachelor_only'],
            'contact_name' => $row['contact_name'],
            'contact_phone' => $row['contact_phone'],
            'contact_email' => $row['contact_email'],
            'primary_image' => $row['primary_image']
        ]
    ];
}

$stmt->close();
closeDbConnection($conn);

jsonResponse(true, 'Favorites retrieved successfully', [
    'favorites' => $favorites,
    'total' => count($favorites)
]);
?>

