<?php
/**
 * Database Setup Handler
 * FlatFinders - Property Rental Platform
 */

header('Content-Type: application/json; charset=UTF-8');

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'flatfinders_db';

$response = [
    'success' => false,
    'message' => '',
    'details' => []
];

try {
    // Connect to MySQL server (without selecting database)
    $conn = new mysqli($host, $username, $password);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8mb4");
    $response['details'][] = "Connected to MySQL server";
    
    // Read and execute schema.sql
    $schemaFile = __DIR__ . '/backend/database/schema.sql';
    if (!file_exists($schemaFile)) {
        throw new Exception("Schema file not found: backend/database/schema.sql");
    }
    
    $schemaSql = file_get_contents($schemaFile);
    
    // Execute schema SQL (split by semicolon for multiple queries)
    $queries = explode(';', $schemaSql);
    $executedQueries = 0;
    
    foreach ($queries as $query) {
        $query = trim($query);
        if (!empty($query)) {
            if ($conn->multi_query($query . ';')) {
                do {
                    if ($result = $conn->store_result()) {
                        $result->free();
                    }
                } while ($conn->more_results() && $conn->next_result());
                $executedQueries++;
            }
        }
    }
    
    $response['details'][] = "Database schema created successfully";
    
    // Now connect to the database
    $conn->select_db($database);
    
    // Read and execute sample-data.sql
    $sampleDataFile = __DIR__ . '/backend/database/sample-data.sql';
    if (file_exists($sampleDataFile)) {
        $sampleDataSql = file_get_contents($sampleDataFile);
        
        // Execute sample data SQL
        $queries = explode(';', $sampleDataSql);
        $dataQueries = 0;
        
        foreach ($queries as $query) {
            $query = trim($query);
            if (!empty($query) && stripos($query, 'INSERT') !== false) {
                if ($conn->multi_query($query . ';')) {
                    do {
                        if ($result = $conn->store_result()) {
                            $result->free();
                        }
                    } while ($conn->more_results() && $conn->next_result());
                    $dataQueries++;
                }
            }
        }
        
        $response['details'][] = "Sample data inserted successfully";
    }
    
    // Verify setup
    $verifyQueries = [
        'Users' => "SELECT COUNT(*) as count FROM users",
        'Properties' => "SELECT COUNT(*) as count FROM properties",
        'Inquiries' => "SELECT COUNT(*) as count FROM inquiries",
        'Amenities' => "SELECT COUNT(*) as count FROM amenities"
    ];
    
    foreach ($verifyQueries as $table => $query) {
        $result = $conn->query($query);
        if ($result) {
            $row = $result->fetch_assoc();
            $response['details'][] = "$table: {$row['count']} records";
        }
    }
    
    $conn->close();
    
    $response['success'] = true;
    $response['message'] = "Database setup completed successfully! You can now login with the provided credentials.";
    
} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>
