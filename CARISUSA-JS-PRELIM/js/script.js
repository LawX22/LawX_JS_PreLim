function updateDateTime() {
    var currentDate = new Date();

    // Get the date, time, and day
    var dayOfMonth = currentDate.getDate();
    var month = currentDate.toLocaleDateString('en-US', { month: 'short' }).toUpperCase();
    var hours = currentDate.getHours();
    var minutes = currentDate.getMinutes();
    var ampm = hours >= 12 ? 'PM' : 'AM';

    // Adjust hours to 12-hour format
    hours = hours % 12 || 12;

    // Update the content
    var sectionTitleDateTime = document.querySelector('.Date-Time');
    sectionTitleDateTime.innerHTML = '<h1 class="dateNow"><span class="dateNow">' + dayOfMonth + '</span> ' + month + '</h1>' +
                                     '<p class="timeNow">' + hours + ':' + (minutes < 10 ? '0' : '') + minutes + ' ' + ampm + '</p>';
}

setInterval(updateDateTime, 1000);
updateDateTime();


// ----------------- PRODUCT POPUP ----------------- //
function toggleModal() {
  var modal = document.getElementById('product');
  modal.classList.toggle('active');
}
window.addEventListener('click', function(event) {
  var modal = document.getElementById('product');
  if (event.target == modal) {
    modal.classList.remove('active');
  }
});
document.getElementById('productClose').addEventListener('click', function() {
  var modal = document.getElementById('product');
  modal.classList.remove('active');
});


// ----------------- UPDATE PRODUCT ----------------- //
function toggleUpdateProduct(productId) {
  var modal = document.getElementById('update-product');
  modal.classList.toggle('active');

  // Populate the product_id input field with the selected product's ID
  document.getElementById('product_id').value = productId;
}

window.addEventListener('click', function(event) {
  var modal = document.getElementById('update-product');
  if (event.target == modal) {
      modal.classList.remove('active');
  }
});

document.getElementById('update-productClose').addEventListener('click', function() {
  var modal = document.getElementById('update-product');
  modal.classList.remove('active');
});




// ----------------- CATEGORY POPUP ----------------- //
function toggleCategory() {
  var catModal = document.getElementById("categoryPopup");
  catModal.style.display = catModal.style.display === "none" ? "block" : "none";
}

document.getElementById("categoryClose").addEventListener("click", function() {
  var catModal = document.getElementById("categoryPopup");
  catModal.style.display = "none";
});

document.body.addEventListener("click", function(event) {
  if (!event.target.closest("#categoryPopup") && !event.target.closest("[onclick='toggleCategory()']")) {
      var catModal = document.getElementById("categoryPopup");
      catModal.style.display = "none";
  }
});



// ----------------- CATEGORY COUNT ----------------- //
document.addEventListener("DOMContentLoaded", function() {
  function updateCategoryCount() {
      fetch("get_category_count.php") 
          .then(response => {
              if (!response.ok) {
                  throw new Error("Network response was not ok");
              }
              return response.json();
          })
          .then(data => {
              if (data.status === "success") {
                  document.querySelector(".cat-count").textContent = data.count;
              } else {
                  console.error("Error fetching category count: " + data.message);
              }
          })
          .catch(error => {
              console.error("Fetch error:", error);
          });
  }

  updateCategoryCount();
  setInterval(updateCategoryCount, 5000); 
});



// ----------------- PRODUCT COUNT ----------------- //
document.addEventListener("DOMContentLoaded", function() {
  function updateProductCount() {
      fetch("get_product_count.php") 
          .then(response => {
              if (!response.ok) {
                  throw new Error("Network response was not ok");
              }
              return response.json();
          })
          .then(data => {
              if (data.status === "success") {
                  document.querySelector(".prod-count").textContent = data.count;
              } else {
                  console.error("Error fetching product count: " + data.message);
              }
          })
          .catch(error => {
              console.error("Fetch error:", error);
          });
  }

  updateProductCount();
  setInterval(updateProductCount, 5000); 
});


// ----------------- PRODUCT IMAGE PREVIEW ----------------- //
document.addEventListener("DOMContentLoaded", function() {
  var fileInput = document.getElementById('productImage');

  fileInput.addEventListener('change', function(event) {
      var file = event.target.files[0];

      if (file) {
          var reader = new FileReader();

          reader.onload = function(e) {
              var imagePreview = document.getElementById('productImagePreview');

              imagePreview.src = e.target.result;

              imagePreview.style.display = 'block';
          };

          reader.readAsDataURL(file);
      }
  });
});



// ----------------- PRODUCT IMAGE PREVIEW ----------------- //
document.addEventListener("DOMContentLoaded", function() {
  var fileInput = document.getElementById('update-productImage');

  fileInput.addEventListener('change', function(event) {
      var file = event.target.files[0];

      if (file) {
          var reader = new FileReader();

          reader.onload = function(e) {
              var imagePreview = document.getElementById('update-productImagePreview');

              imagePreview.src = e.target.result;

              imagePreview.style.display = 'block';
          };

          reader.readAsDataURL(file);
      }
  });
});





// ----------------- POPULATE IMAGE IN THE CARDS ----------------- //
document.getElementById('update-productImagePreview').src = product.product_image; // Populate the image preview