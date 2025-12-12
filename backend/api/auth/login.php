<?php
/**
 * User Login API
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
if (!isset($input['email']) || empty(trim($input['email']))) {
    jsonResponse(false, 'Email is required', null, 400);
}

if (!isset($input['password']) || empty($input['password'])) {
    jsonResponse(false, 'Password is required', null, 400);
}

// Sanitize inputs
$email = sanitizeInput($input['email']);
$password = $input['password'];

// Validate email
if (!validateEmail($email)) {
    jsonResponse(false, 'Invalid email address', null, 400);
}

// Get database connection
$conn = getDbConnection();

// Get user by email
$stmt = $conn->prepare("
    SELECT id, name, email, phone, password_hash, role, status, profile_image 
    FROM users 
    WHERE email = ?
");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    closeDbConnection($conn);
    jsonResponse(false, 'Invalid email or password', null, 401);
}

$user = $result->fetch_assoc();
$stmt->close();

// Check if account is active
if ($user['status'] !== 'active') {
    closeDbConnection($conn);
    jsonResponse(false, 'Account is suspended or inactive. Please contact support', null, 403);
}

// Verify password
if (!verifyPassword($password, $user['password_hash'])) {
    closeDbConnection($conn);
    jsonResponse(false, 'Invalid email or password', null, 401);
}

// Update last login time
$updateStmt = $conn->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
$updateStmt->bind_param("i", $user['id']);
$updateStmt->execute();
$updateStmt->close();

closeDbConnection($conn);

// Start session
session_start();
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_email'] = $user['email'];
$_SESSION['user_role'] = $user['role'];
$_SESSION['user_name'] = $user['name'];

// Prepare response
$userData = [
    'id' => $user['id'],
    'name' => $user['name'],
    'email' => $user['email'],
    'phone' => $user['phone'],
    'role' => $user['role'],
    'profile_image' => $user['profile_image']
];

jsonResponse(true, 'Login successful', ['user' => $userData]);
?>

