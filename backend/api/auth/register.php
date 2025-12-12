<?php
/**
 * User Registration API
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
$required = ['name', 'email', 'password', 'role'];
foreach ($required as $field) {
    if (!isset($input[$field]) || empty(trim($input[$field]))) {
        jsonResponse(false, "Field '$field' is required", null, 400);
    }
}

// Sanitize inputs
$name = sanitizeInput($input['name']);
$email = sanitizeInput($input['email']);
$password = $input['password'];
$phone = isset($input['phone']) ? sanitizeInput($input['phone']) : null;
$role = sanitizeInput($input['role']);

// Validate email
if (!validateEmail($email)) {
    jsonResponse(false, 'Invalid email address', null, 400);
}

// Validate password length
if (strlen($password) < PASSWORD_MIN_LENGTH) {
    jsonResponse(false, 'Password must be at least ' . PASSWORD_MIN_LENGTH . ' characters', null, 400);
}

// Validate role
if (!in_array($role, ['customer', 'owner'])) {
    jsonResponse(false, 'Invalid role. Must be either customer or owner', null, 400);
}

// Get database connection
$conn = getDbConnection();

// Check if email already exists
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $stmt->close();
    closeDbConnection($conn);
    jsonResponse(false, 'Email already registered', null, 409);
}
$stmt->close();

// Hash password
$passwordHash = hashPassword($password);

// Generate verification token
$verificationToken = generateToken();

// Insert new user
$stmt = $conn->prepare("
    INSERT INTO users (name, email, phone, password_hash, role, verification_token) 
    VALUES (?, ?, ?, ?, ?, ?)
");
$stmt->bind_param("ssssss", $name, $email, $phone, $passwordHash, $role, $verificationToken);

if ($stmt->execute()) {
    $userId = $conn->insert_id;
    $stmt->close();
    
    // Send verification email (optional - implement based on requirements)
    // sendVerificationEmail($email, $name, $verificationToken);
    
    // Start session and log user in
    session_start();
    $_SESSION['user_id'] = $userId;
    $_SESSION['user_email'] = $email;
    $_SESSION['user_role'] = $role;
    $_SESSION['user_name'] = $name;
    
    closeDbConnection($conn);
    
    jsonResponse(true, 'Registration successful', [
        'user' => [
            'id' => $userId,
            'name' => $name,
            'email' => $email,
            'role' => $role,
            'phone' => $phone
        ]
    ]);
} else {
    $stmt->close();
    closeDbConnection($conn);
    jsonResponse(false, 'Registration failed. Please try again', null, 500);
}
?>

