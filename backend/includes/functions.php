<?php
/**
 * Common Functions
 * FlatFinders - Property Rental Platform
 */

/**
 * Sanitize input data
 */
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Validate email address
 */
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Hash password securely
 */
function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

/**
 * Verify password
 */
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

/**
 * Generate random token
 */
function generateToken($length = 32) {
    return bin2hex(random_bytes($length));
}

/**
 * Validate file upload
 */
function validateImageUpload($file) {
    // Check if file was uploaded
    if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
        return ['success' => false, 'message' => 'No file uploaded'];
    }
    
    // Check file size
    if ($file['size'] > MAX_FILE_SIZE) {
        return ['success' => false, 'message' => 'File size exceeds 5MB limit'];
    }
    
    // Check file type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    
    if (!in_array($mimeType, ALLOWED_IMAGE_TYPES)) {
        return ['success' => false, 'message' => 'Invalid file type. Only JPG, JPEG, and PNG allowed'];
    }
    
    return ['success' => true];
}

/**
 * Upload image file
 */
function uploadImage($file, $folder = 'properties') {
    $validation = validateImageUpload($file);
    if (!$validation['success']) {
        return $validation;
    }
    
    // Create upload directory if it doesn't exist
    $uploadDir = UPLOAD_PATH . $folder . '/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    // Generate unique filename
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '_' . time() . '.' . $extension;
    $filepath = $uploadDir . $filename;
    
    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        return [
            'success' => true,
            'filename' => $filename,
            'filepath' => $folder . '/' . $filename
        ];
    }
    
    return ['success' => false, 'message' => 'Failed to upload file'];
}

/**
 * Delete image file
 */
function deleteImage($filepath) {
    $fullPath = UPLOAD_PATH . $filepath;
    if (file_exists($fullPath)) {
        return unlink($fullPath);
    }
    return false;
}

/**
 * Generate JSON response
 */
function jsonResponse($success, $message, $data = null, $code = 200) {
    http_response_code($code);
    $response = [
        'success' => $success,
        'message' => $message
    ];
    
    if ($data !== null) {
        $response['data'] = $data;
    }
    
    echo json_encode($response);
    exit();
}

/**
 * Verify user session
 */
function verifySession() {
    session_start();
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role'])) {
        jsonResponse(false, 'Unauthorized access', null, 401);
    }
    return [
        'user_id' => $_SESSION['user_id'],
        'role' => $_SESSION['user_role'],
        'email' => $_SESSION['user_email'] ?? ''
    ];
}

/**
 * Check if user has required role
 */
function requireRole($allowedRoles) {
    $user = verifySession();
    if (!in_array($user['role'], $allowedRoles)) {
        jsonResponse(false, 'Insufficient permissions', null, 403);
    }
    return $user;
}

/**
 * Paginate results
 */
function paginate($sql, $conn, $page = 1, $perPage = PROPERTIES_PER_PAGE) {
    // Get total count
    $countSql = "SELECT COUNT(*) as total FROM ($sql) as count_table";
    $countResult = $conn->query($countSql);
    $total = $countResult->fetch_assoc()['total'];
    
    // Calculate pagination
    $totalPages = ceil($total / $perPage);
    $offset = ($page - 1) * $perPage;
    
    // Get paginated results
    $paginatedSql = "$sql LIMIT $perPage OFFSET $offset";
    $result = $conn->query($paginatedSql);
    
    $data = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    
    return [
        'data' => $data,
        'pagination' => [
            'current_page' => (int)$page,
            'per_page' => (int)$perPage,
            'total' => (int)$total,
            'total_pages' => (int)$totalPages
        ]
    ];
}

/**
 * Send email notification (basic implementation)
 */
function sendEmail($to, $subject, $message, $htmlMessage = null) {
    // Basic email headers
    $headers = "From: " . SMTP_FROM_NAME . " <" . SMTP_FROM_EMAIL . ">\r\n";
    $headers .= "Reply-To: " . SMTP_FROM_EMAIL . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
    
    if ($htmlMessage) {
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $message = $htmlMessage;
    } else {
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    }
    
    // Send email
    return mail($to, $subject, $message, $headers);
}

/**
 * Format currency (BDT)
 */
function formatCurrency($amount) {
    return '৳' . number_format($amount, 0);
}

/**
 * Calculate time ago
 */
function timeAgo($datetime) {
    $timestamp = strtotime($datetime);
    $diff = time() - $timestamp;
    
    if ($diff < 60) {
        return 'Just now';
    } elseif ($diff < 3600) {
        $mins = floor($diff / 60);
        return $mins . ' minute' . ($mins > 1 ? 's' : '') . ' ago';
    } elseif ($diff < 86400) {
        $hours = floor($diff / 3600);
        return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
    } elseif ($diff < 604800) {
        $days = floor($diff / 86400);
        return $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
    } else {
        return date('M d, Y', $timestamp);
    }
}
?>

