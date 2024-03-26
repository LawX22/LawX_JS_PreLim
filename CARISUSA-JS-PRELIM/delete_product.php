<?php
// Handle the AJAX request to delete the product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["productId"])) {
    // Include database connection code
    require_once 'dbconnection.php';

    // Get the product ID to delete
    $productId = $_POST["productId"];

    try {
        // Prepare the SQL statement to delete the product
        $stmt = $pdo->prepare("DELETE FROM product WHERE product_id = :productId");
        $stmt->bindParam(':productId', $productId);
        $stmt->execute();

        // Return success response
        echo json_encode(array("status" => "success"));
    } catch (PDOException $e) {
        // Return error response
        echo json_encode(array("status" => "error", "message" => $e->getMessage()));
    }
} else {
    // Return error response if the request is not valid
    echo json_encode(array("status" => "error", "message" => "Invalid request"));
}
?>
