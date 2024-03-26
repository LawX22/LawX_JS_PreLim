// ----------------------------------- ADD CATEGORY ----------------------------------- //
$(document).ready(function() {
    $("#addCategoryForm").on("submit", function(event) {
        event.preventDefault(); 

        $("#addCategoryForm button[type='submit']").html('Please Wait ...');

        $.ajax({
            type: "POST",
            url: "add_category.php",
            dataType: "json",
            data: $(this).serialize(), 
            success: function(response) {
                if (response.status === "success") {
                    alert("Category added successfully: " + response.category_name); // Display category name
                    $("#addCategoryForm")[0].reset();
                    location.reload();
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText); 
                alert("Error: " + error); 
            },
            complete: function() {
                $("#addCategoryForm button[type='submit']").html("Add Category");
            }
        });
    });
});



// ----------------------------------- ADD PRODUCT ----------------------------------- //
$(document).ready(function() {
    $("#addProductForm").on("submit", function(event) {
        event.preventDefault(); 

        var formData = new FormData(this); 

        $("#submitProdBtn").html('Please Wait ...');

        $.ajax({
            type: "POST",
            url: "add_product.php",
            dataType: "json",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.status === "success") {
                    alert(response.message);
                    location.reload();
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                alert("Error: " + error);
            },
            complete: function() {
                $("#submitProdBtn").html("ADD PRODUCT");
            }
        });
    });
});


// -------------------------------------------------------------------------------------- //
$(document).ready(function() {
    
// ----------------------------------- DELETE PRODUCT ----------------------------------- //
    $(".card-container").on("click", ".CB-delete", function() {
        var productId = $(this).closest(".card").data("product-id");

        if (confirm("Are you sure you want to delete this product?")) {
            $.ajax({
                type: "POST",
                url: "delete_product.php",
                data: { productId: productId },
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        $(this).closest(".card").remove();
                        alert("Product deleted successfully!");
                        location.reload();
                    } else {
                        alert("Failed to delete product: " + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    alert("Error deleting product: " + error);
                }
            });
        }
    });

// ----------------------------------- FETCH ADDED PRODUCT ----------------------------------- //
function fetchAndDisplayProducts() {
    $.ajax({
        type: "GET",
        url: "fetch_products.php",
        dataType: "json",
        success: function(products) {
            products.forEach(function(product) {
                var cardHtml = `
                    <div class="card" data-product-id="${product.product_id}">
                        <div class="card-picture">
                            <img class="card-img" src="${product.product_image}" alt="">
                        </div>
                        <div class="card-content">
                            <div class="cc-content">
                                <div class="title1">Name:</div>
                                <div class="title2">${product.product_name}</div>
                            </div>
                            <div class="cc-content">
                                <div class="title1">Category:</div>
                                <div class="title2">${product.product_category}</div>
                            </div>
                            <div class="cc-content">
                                <div class="title1">Quantity:</div>
                                <div class="title2">${product.product_quantity}</div>
                            </div>
                        </div>
                        <div class="card-buttons">
                            <div class="CB-edit" onclick="toggleUpdateProduct(${product.product_id})">EDIT</div>
                            <div class="CB-delete" id="CB-delete">DELETE</div>
                        </div>
                    </div>
                `;
                $(".card-container").append(cardHtml);
            });
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
            alert("Error fetching added products: " + error);
        }
    });
}

fetchAndDisplayProducts();
});



// ----------------------------------- POPULATE UPDATE PRODUCT ----------------------------------- //
$(document).ready(function() {
    // Event listener for CB-edit button click
    $(document).on("click", ".CB-edit", function() {
        // Get the product ID associated with the CB-edit button
        var product_id = $(this).closest(".card").data("product-id");
        // Perform AJAX request to fetch product details
        $.ajax({
            type: "GET",
            url: "fetch_product_details.php",
            dataType: "json",
            data: { product_id: product_id },
            success: function(product) {
                // Populate the fields in the popup div with the received product details
                $("#update-productName").val(product.product_name);
                $("#update-categorySelect").val(product.product_category);
                $("#update-productQuantity").val(product.product_quantity);
                $("#update-productImagePreview").attr("src", product.product_image); // Set image preview

                // Extract the file name from the image URL
                var imageName = product.product_image.split('/').pop();
                // Display the image name
                $("#update-productImageName").text(imageName);
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                alert("Error fetching product details: " + error);
            }
        });
    });
});



// ----------------------------------- UPDATE PRODUCT ----------------------------------- //
$(document).ready(function() {
    $("#update-addProductForm").submit(function(e) {
        e.preventDefault();

        // Retrieve form field values
        var productName = $("#update-productName").val();
        var categorySelect = $("#update-categorySelect").val();
        var productQuantity = $("#update-productQuantity").val();
        var productId = $("#product_id").val();

        // Check if all required fields are filled
        if (!productName || !categorySelect || !productQuantity || !productId) {
            alert("Product name, category, quantity, and product ID are required!");
            return;
        }

        // Prepare form data including file
        var formData = new FormData();
        var fileInput = $('#update-productImage')[0];
        formData.append('update-productImage', fileInput.files[0]);
        formData.append('product_id', productId);
        formData.append('update-productName', productName);
        formData.append('update-categorySelect', categorySelect);
        formData.append('update-productQuantity', productQuantity);

        // Send AJAX request
        $.ajax({
            type: "POST",
            url: "update_product.php",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(response) {
                if (response.status === "success") {
                    // Product updated successfully
                    alert(response.message);
                    // Reload the page or update the product list
                    location.reload();
                } else {
                    // Error occurred during product update
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert("Error updating product: " + error);
            }
        });
    });
});
