<?php
/**
 * Statistics API (Admin Only)
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

// Get database connection
$conn = getDbConnection();

// Get overall statistics
$stats = [];

// Total properties
$result = $conn->query("SELECT COUNT(*) as total FROM properties");
$stats['total_properties'] = $result->fetch_assoc()['total'];

// Pending properties
$result = $conn->query("SELECT COUNT(*) as total FROM properties WHERE status = 'pending'");
$stats['pending_properties'] = $result->fetch_assoc()['total'];

// Approved properties
$result = $conn->query("SELECT COUNT(*) as total FROM properties WHERE status = 'approved'");
$stats['approved_properties'] = $result->fetch_assoc()['total'];

// Total users
$result = $conn->query("SELECT COUNT(*) as total FROM users");
$stats['total_users'] = $result->fetch_assoc()['total'];

// Active users
$result = $conn->query("SELECT COUNT(*) as total FROM users WHERE status = 'active'");
$stats['active_users'] = $result->fetch_assoc()['total'];

// Users by role
$result = $conn->query("SELECT role, COUNT(*) as count FROM users GROUP BY role");
$usersByRole = [];
while ($row = $result->fetch_assoc()) {
    $usersByRole[$row['role']] = intval($row['count']);
}
$stats['users_by_role'] = $usersByRole;

// Total inquiries
$result = $conn->query("SELECT COUNT(*) as total FROM inquiries");
$stats['total_inquiries'] = $result->fetch_assoc()['total'];

// New inquiries
$result = $conn->query("SELECT COUNT(*) as total FROM inquiries WHERE status = 'new'");
$stats['new_inquiries'] = $result->fetch_assoc()['total'];

// Properties by type
$result = $conn->query("SELECT property_type, COUNT(*) as count FROM properties WHERE status = 'approved' GROUP BY property_type");
$propertiesByType = [];
while ($row = $result->fetch_assoc()) {
    $propertiesByType[$row['property_type']] = intval($row['count']);
}
$stats['properties_by_type'] = $propertiesByType;

// Monthly statistics (last 12 months)
$monthlyStmt = $conn->prepare("
    SELECT 
        DATE_FORMAT(created_at, '%Y-%m') as month,
        COUNT(*) as count
    FROM properties
    WHERE created_at >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
    GROUP BY DATE_FORMAT(created_at, '%Y-%m')
    ORDER BY month ASC
");
$monthlyStmt->execute();
$monthlyResult = $monthlyStmt->get_result();
$monthlyProperties = [];
while ($row = $monthlyResult->fetch_assoc()) {
    $monthlyProperties[] = [
        'month' => $row['month'],
        'count' => intval($row['count'])
    ];
}
$stats['monthly_properties'] = $monthlyProperties;
$monthlyStmt->close();

// Recent activity
$recentStmt = $conn->prepare("
    SELECT 
        'property' as type,
        id,
        title as description,
        created_at
    FROM properties
    WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
    
    UNION ALL
    
    SELECT 
        'user' as type,
        id,
        CONCAT(name, ' registered') as description,
        created_at
    FROM users
    WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
    
    ORDER BY created_at DESC
    LIMIT 10
");
$recentStmt->execute();
$recentResult = $recentStmt->get_result();
$recentActivity = [];
while ($row = $recentResult->fetch_assoc()) {
    $recentActivity[] = [
        'type' => $row['type'],
        'id' => $row['id'],
        'description' => $row['description'],
        'created_at' => $row['created_at']
    ];
}
$stats['recent_activity'] = $recentActivity;
$recentStmt->close();

closeDbConnection($conn);

jsonResponse(true, 'Statistics retrieved successfully', ['statistics' => $stats]);
?>

