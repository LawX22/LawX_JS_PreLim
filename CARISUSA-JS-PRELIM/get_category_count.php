<?php
include('dbconnection.php');

$response = array();

try {
    $stmt = $pdo->query("SELECT COUNT(*) AS category_count FROM category");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $response['status'] = 'success';
        $response['count'] = $result['category_count'];
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Failed to fetch category count';
    }
} catch (PDOException $e) {
    $response['status'] = 'error';
    $response['message'] = 'Database error: ' . $e->getMessage();
}

header('Content-Type: application/json');

echo json_encode($response);
?>
