// Popup show and hide functionality
const loginLink = document.getElementById("login-link");
const loginPopup = document.getElementById("login-popup");
const closeBtn = document.getElementById("close-btn");

loginLink.addEventListener("click", () => {
    loginPopup.style.display = "flex";
});

closeBtn.addEventListener("click", () => {
    loginPopup.style.display = "none";
});

window.addEventListener("click", (e) => {
    if (e.target === loginPopup) {
        loginPopup.style.display = "none";
    }
});

// Toggle show/hide password
const togglePassword = document.getElementById("toggle-password");
const passwordField = document.getElementById("password");

togglePassword.addEventListener("click", () => {
    if (passwordField.type === "password") {
        passwordField.type = "text";
        togglePassword.classList.remove("fa-eye");
        togglePassword.classList.add("fa-eye-slash");
    } else {
        passwordField.type = "password";
        togglePassword.classList.remove("fa-eye-slash");
        togglePassword.classList.add("fa-eye");
    }
});

// Form validation and loading spinner
const loginForm = document.getElementById("login-form");
const loadingSpinner = document.getElementById("loading-spinner");
const emailField = document.getElementById("email");
const passwordField = document.getElementById("password");
const emailError = document.getElementById("email-error");
const passwordError = document.getElementById("password-error");

// Simulated valid credentials
const VALID_CREDENTIALS = {
    email: "admin",
    password: "1234"
};

loginForm.addEventListener("submit", (e) => {
    e.preventDefault();

    // Reset errors
    emailError.textContent = "";
    passwordError.textContent = "";

    const email = emailField.value.trim();
    const password = passwordField.value.trim();

    // Show loading spinner
    loadingSpinner.style.display = "flex";

    // Simulate server response time
    setTimeout(() => {
        loadingSpinner.style.display = "none";

        let hasError = false;

        // Check email
        if (email !== VALID_CREDENTIALS.email) {
            emailError.textContent = "Invalid email";
            hasError = true;
        }

        // Check password
        if (password !== VALID_CREDENTIALS.password) {
            passwordError.textContent = "Incorrect password";
            hasError = true;
        }

        // Redirect if no error
        if (!hasError) {
            window.location.href = "dashboard.html";
        }
    }, 2000); // Simulated 2-second delay
});


/*
    // Check password
        if (password !== VALID_CREDENTIALS.password) {
            passwordError.textContent = "Incorrect password";
            hasError = true;
        }
*/

 const email = emailField.value.trim();
    const password = passwordField.value.trim();