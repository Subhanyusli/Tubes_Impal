//update jumlah barang dalam cart
function updateQuantity(id_keranjang, action, value = null) {
    const formData = new FormData();
    formData.append('id_keranjang', id_keranjang);
    formData.append('action', action);
    if (value !== null) {
        formData.append('value', value);
    }

    fetch('../php/update_cart.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to update cart');
    });
}
//menghapus item dalam cart
function removeItem(id_keranjang) {
    if (confirm('Are you sure you want to remove this item?')) {
        updateQuantity(id_keranjang, 'remove');
    }
}
//menghitung total item 
function calculateCartTotal() {
    const quantityInputs = document.querySelectorAll('.quantity-input');
    let totalItems = 0;
    
    quantityInputs.forEach(input => {
        totalItems += parseInt(input.value) || 0;
    });
    
    return totalItems;
}
//untuk mengirimkan semua item di cart ke checkout
function checkout() {
    const checkoutBtn = document.querySelector('.checkout-btn');
    checkoutBtn.disabled = true;
    checkoutBtn.textContent = 'Processing...';

    const totalItems = calculateCartTotal();

  
    fetch('../php/process_checkout.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            total_items: totalItems
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Checkout successful! Thank you for your order.');
            window.location.href = '../php/riwayat.php';
        } else {
            alert('Error during checkout: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred during checkout. Please try again.');
    })
    .finally(() => {
        checkoutBtn.disabled = false;
        checkoutBtn.textContent = 'Proceed to Checkout';
    });
}