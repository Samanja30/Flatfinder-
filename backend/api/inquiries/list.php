<?php
/**
 * List Inquiries API
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

// Get filter parameters
$status = isset($_GET['status']) ? sanitizeInput($_GET['status']) : '';
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$perPage = isset($_GET['per_page']) ? min(50, max(1, intval($_GET['per_page']))) : INQUIRIES_PER_PAGE;

// Get database connection
$conn = getDbConnection();

// Build query based on user role
if ($user['role'] === 'owner') {
    // Owner sees inquiries for their properties
    $sql = "
        SELECT 
            i.id, i.name, i.email, i.phone, i.message, i.status, i.created_at,
            p.id as property_id, p.title as property_title, p.price
        FROM inquiries i
        JOIN properties p ON i.property_id = p.id
        WHERE p.owner_id = ?
    ";
    $countSql = "
        SELECT COUNT(*) as total 
        FROM inquiries i
        JOIN properties p ON i.property_id = p.id
        WHERE p.owner_id = ?
    ";
    $params = [$user['user_id']];
    $types = 'i';
    
} elseif ($user['role'] === 'customer') {
    // Customer sees their own inquiries
    $sql = "
        SELECT 
            i.id, i.name, i.email, i.phone, i.message, i.status, i.created_at,
            p.id as property_id, p.title as property_title, p.price, p.location
        FROM inquiries i
        JOIN properties p ON i.property_id = p.id
        WHERE i.customer_id = ?
    ";
    $countSql = "
        SELECT COUNT(*) as total 
        FROM inquiries i
        WHERE i.customer_id = ?
    ";
    $params = [$user['user_id']];
    $types = 'i';
    
} elseif ($user['role'] === 'admin') {
    // Admin sees all inquiries
    $sql = "
        SELECT 
            i.id, i.name, i.email, i.phone, i.message, i.status, i.created_at,
            p.id as property_id, p.title as property_title, p.price,
            u.name as owner_name
        FROM inquiries i
        JOIN properties p ON i.property_id = p.id
        LEFT JOIN users u ON p.owner_id = u.id
        WHERE 1=1
    ";
    $countSql = "SELECT COUNT(*) as total FROM inquiries WHERE 1=1";
    $params = [];
    $types = '';
}

// Add status filter
if (!empty($status)) {
    $sql .= " AND i.status = ?";
    $countSql .= " AND status = ?";
    $params[] = $status;
    $types .= 's';
}

// Order by newest first
$sql .= " ORDER BY i.created_at DESC";

// Get total count
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

$inquiries = [];
while ($row = $result->fetch_assoc()) {
    $inquiry = [
        'id' => $row['id'],
        'name' => $row['name'],
        'email' => $row['email'],
        'phone' => $row['phone'],
        'message' => $row['message'],
        'status' => $row['status'],
        'created_at' => $row['created_at'],
        'property' => [
            'id' => $row['property_id'],
            'title' => $row['property_title'],
            'price' => floatval($row['price'])
        ]
    ];
    
    if (isset($row['location'])) {
        $inquiry['property']['location'] = $row['location'];
    }
    
    if (isset($row['owner_name'])) {
        $inquiry['property']['owner_name'] = $row['owner_name'];
    }
    
    $inquiries[] = $inquiry;
}

$stmt->close();
closeDbConnection($conn);

jsonResponse(true, 'Inquiries retrieved successfully', [
    'inquiries' => $inquiries,
    'pagination' => [
        'current_page' => $page,
        'per_page' => $perPage,
        'total' => intval($total),
        'total_pages' => $totalPages
    ]
]);
?>

