//mengirim ke checkout
function checkout() {
    // tombol nonaktifkan untuk mencegah pengiriman ganda
    const checkoutBtn = document.querySelector('.checkout-btn');
    checkoutBtn.disabled = true;
    checkoutBtn.textContent = 'Processing...';

    fetch('process_checkout.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        }
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
        // nyalakan tombol lagi
        checkoutBtn.disabled = false;
        checkoutBtn.textContent = 'Proceed to Checkout';
    });
}