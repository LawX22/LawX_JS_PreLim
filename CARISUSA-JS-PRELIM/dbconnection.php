<?php
$servername = 'localhost';
$dbname = 'carisusa-db';
$username = 'root';
$password = '';

$dsn = "mysql:host=$servername;dbname=$dbname";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // If connection fails, send JSON response with error message
    header('Content-Type: application/json'); // Set content type header
    echo json_encode(array("status" => "error", "message" => "Connection failed: " . $e->getMessage()));
    exit(); // Ensure no further content is sent
}

// If connection is successful, proceed with other PHP code
?>
