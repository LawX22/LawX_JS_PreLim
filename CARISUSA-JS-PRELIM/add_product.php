<?php
require_once 'dbconnection.php';

function generateUniqueFilename($filename) {
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $uniqueFilename = uniqid() . '_' . bin2hex(random_bytes(8)) . '.' . $extension;
    return $uniqueFilename;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["productName"]) && !empty($_POST["productName"]) && isset($_POST["categorySelect"]) && !empty($_POST["categorySelect"]) && isset($_POST["productQuantity"]) && !empty($_POST["productQuantity"]) && isset($_FILES["productImage"]) && $_FILES["productImage"]["error"] == 0) {
    $product_name = $_POST["productName"];
    $catagery_name = $_POST["categorySelect"];
    $product_quantity = $_POST["productQuantity"];

    $target_dir = "uploads/";
    $target_file = $target_dir . generateUniqueFilename($_FILES["productImage"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["productImage"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $response = array("status" => "error", "message" => "File is not an image.");
        echo json_encode($response);
        exit();
    }
    if (file_exists($target_file)) {
        $response = array("status" => "error", "message" => "Sorry, file already exists.");
        echo json_encode($response);
        exit();
    }
    if ($_FILES["productImage"]["size"] > 8000000) {
        $response = array("status" => "error", "message" => "Sorry, your file is too large.");
        echo json_encode($response);
        exit();
    }
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        $response = array("status" => "error", "message" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        echo json_encode($response);
        exit();
    }
    if (move_uploaded_file($_FILES["productImage"]["tmp_name"], $target_file)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO product (product_name, product_category, product_quantity, product_image) VALUES (:product_name, :catagery_name, :product_quantity, :product_image)");

            $stmt->bindParam(':product_name', $product_name);
            $stmt->bindParam(':catagery_name', $catagery_name);
            $stmt->bindParam(':product_quantity', $product_quantity);
            $stmt->bindParam(':product_image', $target_file);
            $stmt->execute();

            $response = array("status" => "success", "message" => "Product added successfully!");
            echo json_encode($response);
        } catch (PDOException $e) {
            $response = array("status" => "error", "message" => "Error: " . $e->getMessage());
            echo json_encode($response);
        }
    } else {
        $response = array("status" => "error", "message" => "Sorry, there was an error uploading your file.");
        echo json_encode($response);
    }
} else {
    $response = array("status" => "error", "message" => "Product name, category, quantity, and image are required!");
    echo json_encode($response);
}

error_log(json_encode($response));
?>
