<?php
/**
 * List Notifications API
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
$unreadOnly = isset($_GET['unread_only']) && $_GET['unread_only'] === 'true';
$limit = isset($_GET['limit']) ? min(50, max(1, intval($_GET['limit']))) : 20;

// Get database connection
$conn = getDbConnection();

// Build query
$sql = "
    SELECT id, title, message, type, link, is_read, created_at, read_at
    FROM notifications
    WHERE user_id = ?
";

$params = [$user['user_id']];
$types = 'i';

if ($unreadOnly) {
    $sql .= " AND is_read = 0";
}

$sql .= " ORDER BY created_at DESC LIMIT ?";
$params[] = $limit;
$types .= 'i';

// Execute query
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$notifications = [];
while ($row = $result->fetch_assoc()) {
    $notifications[] = [
        'id' => $row['id'],
        'title' => $row['title'],
        'message' => $row['message'],
        'type' => $row['type'],
        'link' => $row['link'],
        'is_read' => (bool)$row['is_read'],
        'created_at' => $row['created_at'],
        'read_at' => $row['read_at'],
        'time_ago' => timeAgo($row['created_at'])
    ];
}

$stmt->close();

// Get unread count
$countStmt = $conn->prepare("SELECT COUNT(*) as count FROM notifications WHERE user_id = ? AND is_read = 0");
$countStmt->bind_param("i", $user['user_id']);
$countStmt->execute();
$countResult = $countStmt->get_result();
$unreadCount = $countResult->fetch_assoc()['count'];
$countStmt->close();

closeDbConnection($conn);

jsonResponse(true, 'Notifications retrieved successfully', [
    'notifications' => $notifications,
    'unread_count' => intval($unreadCount),
    'total' => count($notifications)
]);
?>
