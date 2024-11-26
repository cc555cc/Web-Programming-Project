<?php
session_set_cookie_params([ //set the login created from this page to exist only for 30 mins//
    'lifetime' => 1800, 
    'path' => '/', 
    'domain' => '', 
    'secure' => false, 
    'httponly' => true, 
    'samesite' => 'Lax' 
]);
    session_start();
    require_once('connectDatabase.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "Form submitted.<br>";  // Debugging message to confirm POST request
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        header("Location: loginPage.php?error=missing_fields");
        exit();
    }

    $stmt = $mysqli->prepare("SELECT userID, userName,Email, Password FROM Users WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo "User found, checking password.<br>";
        if (password_verify($password, $row['Password'])) {
            echo "Password is correct.<br>";
            $_SESSION['Logined_In_User'] = $row;//create session//
            $_SESSION['user_id'] = $row['userID'];
            $_SESSION['user_name'] = $row['userName'];
            header("Location: account.php");//direct to account page if login is successful//
            exit();
        } else {
            header("Location: loginPage.php?error=invalid_credentials");//direct to login page again with error's value//
            echo ("your email or password doesn't match");
            exit();
        }
    } else {
        header("Location: loginPage.php?error=invalid_credentials");//direct to login page wwith error value//
        exit();
    }

    $stmt->close();
    $mysqli->close();
}
?>