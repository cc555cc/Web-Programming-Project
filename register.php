<?php
require_once('connectDatabase.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    //Validate inputs//
    if (empty($username) || empty($email) || empty($password)) {
        die('All fields are required.');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {//If email does not have a valid format//
        die('Invalid email format.');
    }

    if (strlen($password) < 8) {//If password has fewer than 8 words//
        die('Password must be at least 8 characters long.');
    }

    //Hash the password//
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    //Insert into database//
    $stmt = $mysqli->prepare("INSERT INTO Users (userName, Email, Password) VALUES (?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param('sss', $username, $email, $hashed_password);
        try{
            if ($stmt->execute()) {
                // Redirect to login page after successful registration
                header("Location: Login.html");
                exit();
            } else {
                echo "Error inserting data: " . $stmt->error;
            }
            $stmt->close();
        }catch(mysqli_sql_exception $e){
            echo $stmt->error;
            echo "<script>confirm('email already in use');</script>";
            header("Location: register.html");
        }
    } else {
        echo "Database query error.";
    }
}

$mysqli->close();
?>
