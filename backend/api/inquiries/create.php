<?php
/**
 * Create Inquiry API
 * FlatFinders - Property Rental Platform
 */

require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../includes/functions.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Method not allowed', null, 405);
}

// Get input data
$input = json_decode(file_get_contents('php://input'), true);

// Validate required fields
$required = ['property_id', 'name', 'email', 'message'];
foreach ($required as $field) {
    if (!isset($input[$field]) || empty(trim($input[$field]))) {
        jsonResponse(false, "Field '$field' is required", null, 400);
    }
}

// Sanitize inputs
$propertyId = intval($input['property_id']);
$name = sanitizeInput($input['name']);
$email = sanitizeInput($input['email']);
$phone = isset($input['phone']) ? sanitizeInput($input['phone']) : null;
$message = sanitizeInput($input['message']);

// Validate email
if (!validateEmail($email)) {
    jsonResponse(false, 'Invalid email address', null, 400);
}

// Validate message length
if (strlen($message) < 10) {
    jsonResponse(false, 'Message must be at least 10 characters', null, 400);
}

// Get customer ID if logged in
session_start();
$customerId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Get database connection
$conn = getDbConnection();

// Check if property exists
$checkStmt = $conn->prepare("SELECT id, owner_id, title FROM properties WHERE id = ? AND status = 'approved'");
$checkStmt->bind_param("i", $propertyId);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows === 0) {
    $checkStmt->close();
    closeDbConnection($conn);
    jsonResponse(false, 'Property not found or not available', null, 404);
}

$property = $checkResult->fetch_assoc();
$checkStmt->close();

// Insert inquiry
$stmt = $conn->prepare("
    INSERT INTO inquiries (property_id, customer_id, name, email, phone, message, status) 
    VALUES (?, ?, ?, ?, ?, ?, 'new')
");
$stmt->bind_param("iissss", $propertyId, $customerId, $name, $email, $phone, $message);

if ($stmt->execute()) {
    $inquiryId = $conn->insert_id;
    $stmt->close();
    
    // Create notification for property owner
    $notifStmt = $conn->prepare("
        INSERT INTO notifications (user_id, title, message, type, link) 
        VALUES (?, ?, ?, 'info', ?)
    ");
    $notifTitle = "New Inquiry";
    $notifMessage = "$name sent an inquiry about your property: {$property['title']}";
    $notifLink = "/owner-inquiries.html";
    $notifStmt->bind_param("isss", $property['owner_id'], $notifTitle, $notifMessage, $notifLink);
    $notifStmt->execute();
    $notifStmt->close();
    
    closeDbConnection($conn);
    
    jsonResponse(true, 'Inquiry sent successfully', ['inquiry_id' => $inquiryId], 201);
} else {
    $stmt->close();
    closeDbConnection($conn);
    jsonResponse(false, 'Failed to send inquiry', null, 500);
}
?>

