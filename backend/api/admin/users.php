<?php
/**
 * User Management API (Admin Only)
 * FlatFinders - Property Rental Platform
 */

require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../includes/functions.php';

// Only allow GET requests
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    jsonResponse(false, 'Method not allowed', null, 405);
}

// Verify user is admin
$user = requireRole(['admin']);

// Get filter parameters
$role = isset($_GET['role']) ? sanitizeInput($_GET['role']) : '';
$status = isset($_GET['status']) ? sanitizeInput($_GET['status']) : '';
$search = isset($_GET['search']) ? sanitizeInput($_GET['search']) : '';
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$perPage = isset($_GET['per_page']) ? min(50, max(1, intval($_GET['per_page']))) : USERS_PER_PAGE;

// Get database connection
$conn = getDbConnection();

// Build query
$sql = "SELECT id, name, email, phone, role, status, email_verified, last_login, created_at FROM users WHERE 1=1";
$countSql = "SELECT COUNT(*) as total FROM users WHERE 1=1";
$params = [];
$types = '';

// Add filters
if (!empty($role)) {
    $sql .= " AND role = ?";
    $countSql .= " AND role = ?";
    $params[] = $role;
    $types .= 's';
}

if (!empty($status)) {
    $sql .= " AND status = ?";
    $countSql .= " AND status = ?";
    $params[] = $status;
    $types .= 's';
}

if (!empty($search)) {
    $sql .= " AND (name LIKE ? OR email LIKE ? OR phone LIKE ?)";
    $countSql .= " AND (name LIKE ? OR email LIKE ? OR phone LIKE ?)";
    $searchTerm = "%$search%";
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $types .= 'sss';
}

// Order by newest first
$sql .= " ORDER BY created_at DESC";

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

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = [
        'id' => $row['id'],
        'name' => $row['name'],
        'email' => $row['email'],
        'phone' => $row['phone'],
        'role' => $row['role'],
        'status' => $row['status'],
        'email_verified' => (bool)$row['email_verified'],
        'last_login' => $row['last_login'],
        'created_at' => $row['created_at']
    ];
}

$stmt->close();
closeDbConnection($conn);

jsonResponse(true, 'Users retrieved successfully', [
    'users' => $users,
    'pagination' => [
        'current_page' => $page,
        'per_page' => $perPage,
        'total' => intval($total),
        'total_pages' => $totalPages
    ]
]);
?>

