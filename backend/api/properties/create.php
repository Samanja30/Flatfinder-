<?php
/**
 * Create Property API
 * FlatFinders - Property Rental Platform
 */

require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../includes/functions.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Method not allowed', null, 405);
}

// Verify user is logged in and is an owner
$user = requireRole(['owner', 'admin']);

// Get POST data (multipart/form-data for file uploads)
$title = sanitizeInput($_POST['title'] ?? '');
$description = sanitizeInput($_POST['description'] ?? '');
$propertyType = sanitizeInput($_POST['type'] ?? '');
$price = floatval($_POST['price'] ?? 0);
$bedrooms = intval($_POST['bedrooms'] ?? 0);
$bathrooms = intval($_POST['bathrooms'] ?? 0);
$areaSqft = intval($_POST['area'] ?? 0);
$floor = sanitizeInput($_POST['floor'] ?? '');
$location = sanitizeInput($_POST['location'] ?? '');
$city = sanitizeInput($_POST['city'] ?? 'Dhaka');
$address = sanitizeInput($_POST['address'] ?? '');
$nearbyPlaces = sanitizeInput($_POST['nearbyPlaces'] ?? '');
$isBachelorOnly = isset($_POST['bachelorOnly']) && $_POST['bachelorOnly'] === 'true' ? 1 : 0;
$contactName = sanitizeInput($_POST['contactName'] ?? '');
$contactPhone = sanitizeInput($_POST['contactPhone'] ?? '');
$contactEmail = sanitizeInput($_POST['contactEmail'] ?? '');

// Get amenities (sent as array)
$amenities = isset($_POST['amenities']) ? $_POST['amenities'] : [];
if (!is_array($amenities)) {
    $amenities = explode(',', $amenities);
}

// Validate required fields
$errors = [];
if (empty($title)) $errors[] = 'Title is required';
if (empty($description) || strlen($description) < 50) $errors[] = 'Description must be at least 50 characters';
if (!in_array($propertyType, ['bachelor', 'apartment', 'house', 'studio', 'sublet'])) $errors[] = 'Invalid property type';
if ($price <= 0) $errors[] = 'Price must be greater than 0';
if ($bedrooms <= 0) $errors[] = 'Number of bedrooms is required';
if ($bathrooms <= 0) $errors[] = 'Number of bathrooms is required';
if ($areaSqft <= 0) $errors[] = 'Area is required';
if (empty($location)) $errors[] = 'Location is required';
if (empty($address)) $errors[] = 'Address is required';
if (empty($contactName)) $errors[] = 'Contact name is required';
if (empty($contactPhone)) $errors[] = 'Contact phone is required';
if (empty($contactEmail) || !validateEmail($contactEmail)) $errors[] = 'Valid contact email is required';

if (!empty($errors)) {
    jsonResponse(false, implode(', ', $errors), null, 400);
}

// Get database connection
$conn = getDbConnection();

try {
    // Begin transaction
    $conn->begin_transaction();
    
    // Insert property
    $stmt = $conn->prepare("
        INSERT INTO properties (
            owner_id, title, description, property_type, price, bedrooms, bathrooms, 
            area_sqft, floor, location, city, address, nearby_places, is_bachelor_only,
            contact_name, contact_phone, contact_email, status
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')
    ");
    
    $stmt->bind_param(
        "isssdiissssssssss",
        $user['user_id'], $title, $description, $propertyType, $price, $bedrooms, $bathrooms,
        $areaSqft, $floor, $location, $city, $address, $nearbyPlaces, $isBachelorOnly,
        $contactName, $contactPhone, $contactEmail
    );
    
    if (!$stmt->execute()) {
        throw new Exception("Failed to create property");
    }
    
    $propertyId = $conn->insert_id;
    $stmt->close();
    
    // Handle image uploads
    if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
        $imageCount = count($_FILES['images']['name']);
        
        if ($imageCount > MAX_IMAGES_PER_PROPERTY) {
            throw new Exception("Maximum " . MAX_IMAGES_PER_PROPERTY . " images allowed");
        }
        
        $imageStmt = $conn->prepare("
            INSERT INTO property_images (property_id, image_path, is_primary, display_order) 
            VALUES (?, ?, ?, ?)
        ");
        
        for ($i = 0; $i < $imageCount; $i++) {
            if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                // Create file array for single image
                $file = [
                    'name' => $_FILES['images']['name'][$i],
                    'type' => $_FILES['images']['type'][$i],
                    'tmp_name' => $_FILES['images']['tmp_name'][$i],
                    'error' => $_FILES['images']['error'][$i],
                    'size' => $_FILES['images']['size'][$i]
                ];
                
                $uploadResult = uploadImage($file, 'properties');
                
                if ($uploadResult['success']) {
                    $isPrimary = ($i === 0) ? 1 : 0; // First image is primary
                    $imageStmt->bind_param("isii", $propertyId, $uploadResult['filepath'], $isPrimary, $i);
                    $imageStmt->execute();
                }
            }
        }
        
        $imageStmt->close();
    }
    
    // Insert amenities
    if (!empty($amenities)) {
        // Get amenity IDs
        $placeholders = str_repeat('?,', count($amenities) - 1) . '?';
        $amenityStmt = $conn->prepare("SELECT id, name FROM amenities WHERE name IN ($placeholders)");
        $amenityStmt->bind_param(str_repeat('s', count($amenities)), ...$amenities);
        $amenityStmt->execute();
        $amenityResult = $amenityStmt->get_result();
        
        if ($amenityResult->num_rows > 0) {
            $propAmenityStmt = $conn->prepare("INSERT INTO property_amenities (property_id, amenity_id) VALUES (?, ?)");
            
            while ($amenity = $amenityResult->fetch_assoc()) {
                $propAmenityStmt->bind_param("ii", $propertyId, $amenity['id']);
                $propAmenityStmt->execute();
            }
            
            $propAmenityStmt->close();
        }
        
        $amenityStmt->close();
    }
    
    // Commit transaction
    $conn->commit();
    closeDbConnection($conn);
    
    jsonResponse(true, 'Property submitted for review successfully', [
        'property_id' => $propertyId,
        'status' => 'pending'
    ], 201);
    
} catch (Exception $e) {
    // Rollback on error
    $conn->rollback();
    closeDbConnection($conn);
    jsonResponse(false, 'Failed to create property: ' . $e->getMessage(), null, 500);
}
?>

