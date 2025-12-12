<?php
/**
 * Backend Index
 * FlatFinders API - Property Rental Platform
 */

header('Content-Type: application/json; charset=UTF-8');

echo json_encode([
    'success' => true,
    'message' => 'FlatFinders API v1.0',
    'endpoints' => [
        'auth' => [
            'POST /api/auth/login.php' => 'User login',
            'POST /api/auth/register.php' => 'User registration',
            'GET /api/auth/session.php' => 'Check session',
            'POST /api/auth/logout.php' => 'User logout'
        ],
        'properties' => [
            'GET /api/properties/list.php' => 'List properties with filters',
            'GET /api/properties/get.php?id={id}' => 'Get property details',
            'POST /api/properties/create.php' => 'Create property (owner)',
            'PUT /api/properties/update.php' => 'Update property (owner)',
            'DELETE /api/properties/delete.php' => 'Delete property (owner)'
        ],
        'inquiries' => [
            'POST /api/inquiries/create.php' => 'Create inquiry',
            'GET /api/inquiries/list.php' => 'List user inquiries'
        ],
        'favorites' => [
            'POST /api/favorites/add.php' => 'Add to favorites',
            'DELETE /api/favorites/remove.php' => 'Remove from favorites',
            'GET /api/favorites/list.php' => 'List user favorites'
        ],
        'admin' => [
            'GET /api/admin/statistics.php' => 'Get statistics (admin)',
            'GET /api/admin/users.php' => 'List users (admin)',
            'POST /api/admin/approve-property.php' => 'Approve property (admin)',
            'POST /api/admin/reject-property.php' => 'Reject property (admin)'
        ],
        'notifications' => [
            'GET /api/notifications/list.php' => 'List user notifications',
            'POST /api/notifications/mark-read.php' => 'Mark notification as read'
        ],
        'contact' => [
            'POST /api/contact/submit.php' => 'Submit contact form'
        ],
        'users' => [
            'GET /api/users/profile.php' => 'Get user profile',
            'PUT /api/users/update-profile.php' => 'Update user profile'
        ]
    ],
    'documentation' => 'See README.md for detailed API documentation',
    'version' => '1.0.0',
    'status' => 'operational'
]);
?>
