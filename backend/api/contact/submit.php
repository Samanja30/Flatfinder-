<?php
/**
 * Contact Form Submission API
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
$required = ['name', 'email', 'message'];
foreach ($required as $field) {
    if (!isset($input[$field]) || empty(trim($input[$field]))) {
        jsonResponse(false, "Field '$field' is required", null, 400);
    }
}

// Sanitize inputs
$name = sanitizeInput($input['name']);
$email = sanitizeInput($input['email']);
$phone = isset($input['phone']) ? sanitizeInput($input['phone']) : null;
$subject = isset($input['subject']) ? sanitizeInput($input['subject']) : 'General Inquiry';
$message = sanitizeInput($input['message']);

// Validate email
if (!validateEmail($email)) {
    jsonResponse(false, 'Invalid email address', null, 400);
}

// Validate message length
if (strlen($message) < 10) {
    jsonResponse(false, 'Message must be at least 10 characters', null, 400);
}

// Get database connection
$conn = getDbConnection();

// Insert contact submission
$stmt = $conn->prepare("
    INSERT INTO contacts (name, email, phone, subject, message, status) 
    VALUES (?, ?, ?, ?, ?, 'new')
");
$stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);

if ($stmt->execute()) {
    $contactId = $conn->insert_id;
    $stmt->close();
    closeDbConnection($conn);
    
    // Send confirmation email (optional)
    // sendEmail($email, "We received your message", "Thank you for contacting FlatFinders...");
    
    jsonResponse(true, 'Your message has been sent successfully. We will get back to you soon!', [
        'contact_id' => $contactId
    ], 201);
} else {
    $stmt->close();
    closeDbConnection($conn);
    jsonResponse(false, 'Failed to send message. Please try again', null, 500);
}
?>
