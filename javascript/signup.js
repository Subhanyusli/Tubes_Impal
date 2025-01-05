//memastikan jika password sama dengan confirm password
document.getElementById('signupForm').addEventListener('submit', function (e) {
    const password = document.querySelector('input[name="password"]').value;
    const confirmPassword = document.querySelector('input[name="confirm_password"]').value;

    if (password !== confirmPassword) {
        e.preventDefault(); // Mencegah pengiriman form jika password tidak cocok
        alert('Password dan Confirm Password harus sama!');
    }
});
