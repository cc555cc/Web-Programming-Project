//Function to handle registration
function registerUser() {
        event.preventDefault();

    const email = document.getElementById("reg-email").value;
    const password = document.getElementById("reg-password").value;
    const confirmPassword = document.getElementById("confirm-password").value;
    const registerMessage = document.getElementById("register-message");

    //Basic email format validation
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if (!emailPattern.test(email)) {
        registerMessage.textContent = "Please enter a valid email address";
        registerMessage.style.color = "red";
        return false;
    }

    //Check if passwords match
    if (password !== confirmPassword) {
        registerMessage.textContent = "Passwords do not match";
        registerMessage.style.color = "red";
        return false;
    }

    try {
        const response = await fetch("register.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
        });

        const result = await response.json();
        if (result.status === "success") {
            alert(result.message);
            window.location.href = "loginPage.php";
        } else {
            registerMessage.textContent = result.message;
            registerMessage.style.color = "red";
        }
    } catch (error) {
        registerMessage.textContent = "An error occurred during registration.";
        registerMessage.style.color = "red";
    }
}


//Function to validate login
function validateLogin(event) {
    event.preventDefault();

    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
    const errorMessage = document.getElementById("error-message");

    try {
        const response = await fetch("login.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
        });

        const result = await response.text();
        if (result.includes("Password is correct")) {
            alert("Login successful!");
            window.location.href = "account.php";
        } else {
            errorMessage.textContent = "Invalid email or password.";
            errorMessage.style.color = "red";
        }
    } catch (error) {
        errorMessage.textContent = "An error occurred during login.";
        errorMessage.style.color = "red";
    }
}

//Function to toggle password visibility
function togglePasswordVisibility() {
    const passwordField = document.getElementById("password");
    passwordField.type = passwordField.type === "password" ? "text" : "password";
}

