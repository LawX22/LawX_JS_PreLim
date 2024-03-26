<?php
require_once 'dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update-productName"]) && !empty($_POST["update-productName"]) && isset($_POST["update-categorySelect"]) && !empty($_POST["update-categorySelect"]) && isset($_POST["update-productQuantity"]) && !empty($_POST["update-productQuantity"]) && isset($_POST["product_id"]) && !empty($_POST["product_id"])) {
    $product_id = $_POST["product_id"];
    $product_name = $_POST["update-productName"];
    $category_id = $_POST["update-categorySelect"];
    $product_quantity = $_POST["update-productQuantity"];

    // Check if the "update-productImage" key exists in $_FILES and if a new image was uploaded
    if (isset($_FILES["update-productImage"]) && $_FILES["update-productImage"]["error"] == 0 && $_FILES["update-productImage"]["size"] > 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["update-productImage"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check file type and size
        $allowed_extensions = array("jpg", "jpeg", "png", "gif");
        if (!in_array($imageFileType, $allowed_extensions)) {
            $response = array("status" => "error", "message" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
            echo json_encode($response);
            exit();
        }

        if ($_FILES["update-productImage"]["size"] > 500000) {
            $response = array("status" => "error", "message" => "Sorry, your file is too large.");
            echo json_encode($response);
            exit();
        }

        // Move the uploaded file to the target directory
        if (!move_uploaded_file($_FILES["update-productImage"]["tmp_name"], $target_file)) {
            $response = array("status" => "error", "message" => "Sorry, there was an error uploading your file.");
            echo json_encode($response);
            exit();
        }

        // Update product with new image
        try {
            $stmt = $pdo->prepare("UPDATE product SET product_name = :product_name, product_category = :category_id, product_quantity = :product_quantity, product_image = :product_image WHERE product_id = :product_id");
            $stmt->bindParam(':product_name', $product_name);
            $stmt->bindParam(':category_id', $category_id);
            $stmt->bindParam(':product_quantity', $product_quantity);
            $stmt->bindParam(':product_image', $target_file);
            $stmt->bindParam(':product_id', $product_id);
            $stmt->execute();

            $response = array("status" => "success", "message" => "Product updated successfully!");
            echo json_encode($response);
        } catch (PDOException $e) {
            $response = array("status" => "error", "message" => "Error updating product: " . $e->getMessage());
            echo json_encode($response);
        }
    } else {
        // No new image uploaded, update product without changing the image
        try {
            $stmt = $pdo->prepare("UPDATE product SET product_name = :product_name, product_category = :category_id, product_quantity = :product_quantity WHERE product_id = :product_id");
            $stmt->bindParam(':product_name', $product_name);
            $stmt->bindParam(':category_id', $category_id);
            $stmt->bindParam(':product_quantity', $product_quantity);
            $stmt->bindParam(':product_id', $product_id);
            $stmt->execute();

            $response = array("status" => "success", "message" => "Product updated successfully!");
            echo json_encode($response);
        } catch (PDOException $e) {
            $response = array("status" => "error", "message" => "Error updating product: " . $e->getMessage());
            echo json_encode($response);
        }
    }
} else {
    $response = array("status" => "error", "message" => "Product name, category, quantity, and product ID are required!");
    echo json_encode($response);
}
?>
