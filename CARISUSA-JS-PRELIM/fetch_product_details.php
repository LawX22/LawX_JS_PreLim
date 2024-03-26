<?php
include('dbconnection.php');
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM product WHERE product_id = :product_id");
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();

        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode($product);
    } catch (PDOException $e) {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(array('error' => 'Database error: ' . $e->getMessage()));
    }
} else {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(array('error' => 'Product ID is required'));
}
