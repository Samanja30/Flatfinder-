<?php
/**
 * General Configuration File
 * FlatFinders - Property Rental Platform
 */

// Application settings
define('APP_NAME', 'FlatFinders');
define('APP_URL', 'http://localhost/Flatfinder');
define('APP_VERSION', '1.0.0');

// Security settings
define('JWT_SECRET_KEY', 'your-secret-key-here-change-this-in-production');
define('PASSWORD_MIN_LENGTH', 6);
define('SESSION_TIMEOUT', 3600); // 1 hour in seconds

// File upload settings
define('MAX_FILE_SIZE', 5242880); // 5MB in bytes
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/jpg']);
define('UPLOAD_PATH', __DIR__ . '/../uploads/');
define('MAX_IMAGES_PER_PROPERTY', 10);

// Pagination settings
define('PROPERTIES_PER_PAGE', 12);
define('INQUIRIES_PER_PAGE', 20);
define('USERS_PER_PAGE', 20);

// Email settings (configure these for production)
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'your-email@gmail.com');
define('SMTP_PASS', 'your-password');
define('SMTP_FROM_EMAIL', 'noreply@flatfinders.com');
define('SMTP_FROM_NAME', 'FlatFinders');

// Timezone
date_default_timezone_set('Asia/Dhaka');

// Error reporting (set to 0 in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// CORS Headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=UTF-8');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}
?>

