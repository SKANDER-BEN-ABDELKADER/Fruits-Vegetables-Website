// Select all quantity input groups
const quantityInputs = document.querySelectorAll('.quantity');

quantityInputs.forEach(quantityInput => {
  const productId = quantityInput.parentElement.dataset.productId; // Get product ID from attribute
  const minusBtn = quantityInput.querySelector('.btn-minus');
  const plusBtn = quantityInput.querySelector('.btn-plus');
  const quantityInputEl = quantityInput.querySelector('input');

  minusBtn.addEventListener('click', () => {
    let currentQuantity = parseInt(quantityInputEl.value);
    if (currentQuantity > 1) {
      currentQuantity--;
      quantityInputEl.value = currentQuantity;
      updateQuantity(productId, currentQuantity); // Call AJAX function
    }
  });

  plusBtn.addEventListener('click', () => {
    let currentQuantity = parseInt(quantityInputEl.value);
    currentQuantity++;
    quantityInputEl.value = currentQuantity;
    updateQuantity(productId, currentQuantity); // Call AJAX function
  });
});

// Function to send AJAX request for quantity update
function updateQuantity(productId, quantity) {
  const xhr = new XMLHttpRequest();
  xhr.open('POST', 'update_cart.php', true); // Replace with actual update script path
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onload = function() {
    if (xhr.status === 200) {
      // Handle successful update (e.g., display confirmation message)
      console.log('Quantity updated successfully!');
    } else {
      console.error('Error updating quantity:', xhr.statusText);
      // Handle update error (e.g., display error message)
    }
  };
  xhr.onerror = function(error) {
    console.error('Error sending AJAX request:', error);
    // Handle AJAX request error
  };
  xhr.send(`product_id=${productId}&quantity=${quantity}`);
}
