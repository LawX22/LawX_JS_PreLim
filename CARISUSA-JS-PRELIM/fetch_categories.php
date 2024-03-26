<?php
include('dbconnection.php');

try {
    $stmt = $pdo->query("SELECT category_id, category_name FROM category");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle database error
    echo "Error: " . $e->getMessage();
    exit(); // Exit the script if an error occurs
}

// Return categories as JSON
echo json_encode($categories);
?>
