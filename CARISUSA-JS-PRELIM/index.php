<?php
include('dbconnection.php');

try {
    $stmt = $pdo->query("SELECT category_id, category_name FROM category");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo json_encode(array("status" => "error", "message" => "Database error: " . $e->getMessage()));
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LawX</title>
    <link rel="icon" type="png" href="./assets/inventory.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="./css/main.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <section>
            <div class="right">
                <div class="right-header">
                <div class="rh-left">
                        <div class="filter">
                            DASHBOARD
                        </div>
                        <div class="Date-Time">
                            <!-- DATE AND TIME -->
                        </div>  
                    </div>
                    <div class="rh-right">
                        <button onclick="toggleModal()" type="button" class="button">
                            <span class="button__text">Product</span>
                            <span class="button__icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" stroke-width="2" stroke-linejoin="round" stroke-linecap="round" stroke="currentColor" height="24" fill="none" class="svg"><line y2="19" y1="5" x2="12" x1="12"></line><line y2="12" y1="12" x2="19" x1="5"></line></svg></span>
                        </button>
                        <button onclick="toggleCategory()" type="button" class="button">
                            <span class="button__text">Category</span>
                            <span class="button__icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" stroke-width="2" stroke-linejoin="round" stroke-linecap="round" stroke="currentColor" height="24" fill="none" class="svg"><line y2="19" y1="5" x2="12" x1="12"></line><line y2="12" y1="12" x2="19" x1="5"></line></svg></span>
                        </button>
                        <!-- <button onclick="toggleModal()">ADD PRODUCT</button>
                        <button onclick="toggleCategory()">ADD CATEGORY</button> -->
                    </div>
                </div>
                <div class="right-body">
                    <div class="card-container">
                        <!-- ADDED PRODUCTS WILL BE DISPLAYED HERE -->
                    </div>

                    <div class="category" id="categoryPopup">
                        <div class="category-content">
                            <i class="fa-solid fa-xmark category-close" id="categoryClose"></i>
                            <h1>CATEGORY</h1>
                            <div class="form-container">
                                <form class="addCategoryForm" id="addCategoryForm">
                                    <label for="categoryName">Category Name:</label>
                                    <input type="text" id="categoryName" name="categoryName" autocomplete="off" required>
                                    <div class="button-container">
                                        <button type="submit">Add Category</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <div class="product" id="product">
        <div class="product-content">
            <i class="fa-solid fa-xmark product-close" id="productClose"></i>
            <h2>PRODUCT</h2>
            <form id="addProductForm" enctype="multipart/form-data">
                <div class="product-image" id="product-image">
                    <img id="productImagePreview" src="#" alt="Product Image Preview" id="productImage" />
                </div>
                <div class="product-name-cat-quantity">
                    <input type="file" name="productImage" id="productImage" required>
                    <div>
                        <label for="productName">Product Name:</label>
                        <input type="text" name="productName" id="productName" autocomplete="off" required>
                    </div>
                    <div>
                        <label for="categorySelect">Category:</label>
                        <select name="categorySelect" id="categorySelect" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?php echo $category['category_name']; ?>"><?php echo $category['category_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="productQuantity">Quantity:</label>
                        <input type="number" name="productQuantity" id="productQuantity" value="1" autocomplete="off" required>
                    </div>
                    <button type="submit" id="submitProdBtn">ADD PRODUCT</button>
                </div>
            </form>
        </div>
    </div>


    <div class="update-product" id="update-product">
        <div class="update-product-content">
            <i class="fa-solid fa-xmark product-close" id="update-productClose"></i>
            <h2>UPDATE PRODUCT</h2>
            <form id="update-addProductForm" enctype="multipart/form-data">
                <input type="hidden" name="product_id" id="product_id">
                <div class="update-product-image" id="update-product-image">
                    <img id="update-productImagePreview" src="" alt="Product Image Preview" id="update-productImage" />
                </div>
                <div class="update-product-name-cat-quantity">
                    <input type="file" name="update-productImage" id="update-productImage">
                    <div>
                        <label for="update-productName">New Product Name:</label>
                        <input type="text" name="update-productName" id="update-productName" autocomplete="off">
                    </div>
                    <div>
                        <label for="update-categorySelect">Category:</label>
                        <select name="update-categorySelect" id="update-categorySelect">
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?php echo $category['category_name']; ?>"><?php echo $category['category_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="update-productQuantity">Quantity:</label>
                        <input type="number" name="update-productQuantity" id="update-productQuantity" value="1" autocomplete="off">
                    </div>
                    <button type="submit" id="update-submitProdBtn">UPDATE PRODUCT</button>
                </div>
            </form>
        </div>
    </div>


    <script src="./js/main.js"></script>
    <script src="./js/script.js"></script>
</body>

</html>