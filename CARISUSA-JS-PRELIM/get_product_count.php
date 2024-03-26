<?php
include('dbconnection.php');

$response = array();

try {
    $stmt = $pdo->query("SELECT COUNT(*) AS product_count FROM product");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $response['status'] = 'success';
        $response['count'] = $result['product_count'];
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Failed to fetch product count';
    }
} catch (PDOException $e) {
    $response['status'] = 'error';
    $response['message'] = 'Database error: ' . $e->getMessage();
}

header('Content-Type: application/json');

echo json_encode($response);
