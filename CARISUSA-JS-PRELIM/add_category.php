<?php
require_once 'dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["categoryName"]) && !empty($_POST["categoryName"])) {
    $category_name = strtoupper($_POST["categoryName"]);

    try {
        $stmt = $pdo->prepare("INSERT INTO category (category_name) VALUES (:category_name)");

        $stmt->bindParam(':category_name', $category_name);
        $stmt->execute();

        // Get the last inserted ID
        $last_id = $pdo->lastInsertId();

        header('Content-Type: application/json');
        $response = array("status" => "success", "message" => "Category added successfully!", "category_name" => $category_name);
        echo json_encode($response);
    } catch (PDOException $e) {
        header('Content-Type: application/json');
        $response = array("status" => "error", "message" => "Error: " . $e->getMessage());
        echo json_encode($response);
    }
} else {
    header('Content-Type: application/json');
    $response = array("status" => "error", "message" => "Category name is required!");
    echo json_encode($response);
}

error_log(json_encode($response));
?>
