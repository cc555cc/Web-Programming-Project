<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="Login.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form method="POST" action="login.php">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Login</button>
        </form>
        <!-- Error message display -->
        <p id="error-message" style="color: red;">
            <?php
            if (isset($_GET['error'])) {//when the user fail to login, this page receive back error value through get method//
                if ($_GET['error'] === 'missing_fields') {//user did not put one or all of the fields//
                    echo "Please fill in all fields.";
                } elseif ($_GET['error'] === 'invalid_credentials') {//user enter value of invalid format//
                    echo "Invalid email or password.";
                } 
            }else{
            }
            ?>
        </p>

        <p>Don't have an account? <a href="Register.html">Register here</a>.</p>
    </div>
    <script>
        // Toggle password visibility
        function togglePasswordVisibility() {
            const passwordField = document.getElementById("password");
            passwordField.type = passwordField.type === "password" ? "text" : "password";
        }
    </script>

    </div>
    <script src="Login.js"></script>
</body>
</html>
