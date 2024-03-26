<?php
require_once 'dbconnection.php';

try {
    // Prepare the SQL statement to fetch products with category names
    $stmt = $pdo->query("SELECT p.*, c.category_name 
                         FROM product p 
                         INNER JOIN category c ON p.product_category = c.category_name");
    
    // Fetch all products with category names
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the products as JSON response
    header('Content-Type: application/json');
    echo json_encode($products);
} catch (PDOException $e) {
    // Return JSON response in case of error
    header('Content-Type: application/json');
    echo json_encode(array("error" => "Error fetching products: " . $e->getMessage()));
}
?>
