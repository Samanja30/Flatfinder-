<?php
/**
 * List Properties API
 * FlatFinders - Property Rental Platform
 */

require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../includes/functions.php';

// Only allow GET requests
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    jsonResponse(false, 'Method not allowed', null, 405);
}

// Get filter parameters
$location = isset($_GET['location']) ? sanitizeInput($_GET['location']) : '';
$propertyType = isset($_GET['type']) ? sanitizeInput($_GET['type']) : '';
$minPrice = isset($_GET['minPrice']) ? intval($_GET['minPrice']) : 0;
$maxPrice = isset($_GET['maxPrice']) ? intval($_GET['maxPrice']) : 999999999;
$bedrooms = isset($_GET['bedrooms']) ? intval($_GET['bedrooms']) : 0;
$bachelorOnly = isset($_GET['bachelorOnly']) && $_GET['bachelorOnly'] === 'true' ? 1 : 0;
$amenities = isset($_GET['amenities']) ? explode(',', $_GET['amenities']) : [];
$search = isset($_GET['search']) ? sanitizeInput($_GET['search']) : '';
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$perPage = isset($_GET['per_page']) ? min(50, max(1, intval($_GET['per_page']))) : PROPERTIES_PER_PAGE;
$sortBy = isset($_GET['sort']) ? sanitizeInput($_GET['sort']) : 'newest';

// Get database connection
$conn = getDbConnection();

// Build base query
$sql = "
    SELECT 
        p.id, p.title, p.description, p.property_type, p.price, p.bedrooms, 
        p.bathrooms, p.area_sqft, p.floor, p.location, p.city, p.address,
        p.is_bachelor_only, p.contact_name, p.contact_phone, p.contact_email,
        p.views, p.featured, p.created_at,
        (SELECT image_path FROM property_images WHERE property_id = p.id AND is_primary = 1 LIMIT 1) as primary_image,
        (SELECT GROUP_CONCAT(a.name) FROM property_amenities pa 
         JOIN amenities a ON pa.amenity_id = a.id 
         WHERE pa.property_id = p.id) as amenities_list
    FROM properties p
    WHERE p.status = 'approved'
";

// Add filters
$conditions = [];
$params = [];
$types = '';

if (!empty($location)) {
    $conditions[] = "p.location = ?";
    $params[] = $location;
    $types .= 's';
}

if (!empty($propertyType)) {
    $conditions[] = "p.property_type = ?";
    $params[] = $propertyType;
    $types .= 's';
}

if ($minPrice > 0) {
    $conditions[] = "p.price >= ?";
    $params[] = $minPrice;
    $types .= 'd';
}

if ($maxPrice < 999999999) {
    $conditions[] = "p.price <= ?";
    $params[] = $maxPrice;
    $types .= 'd';
}

if ($bedrooms > 0) {
    $conditions[] = "p.bedrooms >= ?";
    $params[] = $bedrooms;
    $types .= 'i';
}

if ($bachelorOnly) {
    $conditions[] = "p.is_bachelor_only = 1";
}

if (!empty($search)) {
    $conditions[] = "(p.title LIKE ? OR p.description LIKE ? OR p.location LIKE ?)";
    $searchTerm = "%$search%";
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $types .= 'sss';
}

// Add amenity filter
if (!empty($amenities)) {
    $amenityPlaceholders = str_repeat('?,', count($amenities) - 1) . '?';
    $conditions[] = "p.id IN (
        SELECT pa.property_id 
        FROM property_amenities pa 
        JOIN amenities a ON pa.amenity_id = a.id 
        WHERE a.name IN ($amenityPlaceholders)
        GROUP BY pa.property_id 
        HAVING COUNT(DISTINCT a.id) = " . count($amenities) . "
    )";
    foreach ($amenities as $amenity) {
        $params[] = trim($amenity);
        $types .= 's';
    }
}

// Add conditions to query
if (!empty($conditions)) {
    $sql .= " AND " . implode(" AND ", $conditions);
}

// Add sorting
switch ($sortBy) {
    case 'price-low':
        $sql .= " ORDER BY p.price ASC";
        break;
    case 'price-high':
        $sql .= " ORDER BY p.price DESC";
        break;
    case 'newest':
        $sql .= " ORDER BY p.created_at DESC";
        break;
    case 'popular':
        $sql .= " ORDER BY p.views DESC";
        break;
    default:
        $sql .= " ORDER BY p.featured DESC, p.created_at DESC";
}

// Prepare and execute query with pagination
$countSql = "SELECT COUNT(*) as total FROM (" . $sql . ") as count_table";
if (!empty($types)) {
    $countStmt = $conn->prepare($countSql);
    $countStmt->bind_param($types, ...$params);
    $countStmt->execute();
    $countResult = $countStmt->get_result();
    $total = $countResult->fetch_assoc()['total'];
    $countStmt->close();
} else {
    $countResult = $conn->query($countSql);
    $total = $countResult->fetch_assoc()['total'];
}

// Calculate pagination
$totalPages = ceil($total / $perPage);
$offset = ($page - 1) * $perPage;
$sql .= " LIMIT ? OFFSET ?";
$params[] = $perPage;
$params[] = $offset;
$types .= 'ii';

// Execute main query
$stmt = $conn->prepare($sql);
if (!empty($types)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

$properties = [];
while ($row = $result->fetch_assoc()) {
    $properties[] = [
        'id' => $row['id'],
        'title' => $row['title'],
        'description' => substr($row['description'], 0, 200) . '...',
        'type' => $row['property_type'],
        'price' => floatval($row['price']),
        'bedrooms' => $row['bedrooms'],
        'bathrooms' => $row['bathrooms'],
        'area_sqft' => $row['area_sqft'],
        'floor' => $row['floor'],
        'location' => $row['location'],
        'city' => $row['city'],
        'address' => $row['address'],
        'is_bachelor_only' => (bool)$row['is_bachelor_only'],
        'contact_name' => $row['contact_name'],
        'contact_phone' => $row['contact_phone'],
        'contact_email' => $row['contact_email'],
        'views' => $row['views'],
        'featured' => (bool)$row['featured'],
        'primary_image' => $row['primary_image'],
        'amenities' => $row['amenities_list'] ? explode(',', $row['amenities_list']) : [],
        'created_at' => $row['created_at']
    ];
}

$stmt->close();
closeDbConnection($conn);

jsonResponse(true, 'Properties retrieved successfully', [
    'properties' => $properties,
    'pagination' => [
        'current_page' => $page,
        'per_page' => $perPage,
        'total' => intval($total),
        'total_pages' => $totalPages
    ]
]);
?>

