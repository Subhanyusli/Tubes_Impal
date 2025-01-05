 //membuat toggle password visibility
 document.addEventListener("DOMContentLoaded", () => {
    const loginForm = document.getElementById("loginForm");
    const errorMessage = document.getElementById("error-message");
    const togglePassword = document.querySelector(".toggle-password");
    const passwordInput = document.getElementById("password");

    togglePassword.addEventListener("click", () => {
        const type = passwordInput.type === "password" ? "text" : "password";
        passwordInput.type = type;
        togglePassword.textContent = type === "password" ? "👁️" : "🙈";
    });
    //untuk login
    loginForm.addEventListener("submit", async (e) => {
        e.preventDefault();
        const formData = new FormData(loginForm);
    
        try {
            const response = await fetch(loginForm.action, {
                method: "POST",
                body: formData,
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            });
    
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
    
            const result = await response.json();
            
            if (result.success) {
                alert(result.message);
                window.location.href = result.redirect; // Gunakan URL dari respons
            } else {
                errorMessage.textContent = result.message;
                errorMessage.style.display = "block";
            }
        } catch (error) {
            console.error("Error:", error);
            errorMessage.textContent = "Terjadi kesalahan pada server. Silakan coba lagi.";
            errorMessage.style.display = "block";
        }
    });
    
});