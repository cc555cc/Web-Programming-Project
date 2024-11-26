<?php
session_start(); 
if(!isset($_SESSION['Logined_In_User'])){
    echo "this user is not logged in";
}else{
// Database connection details
$host = "localhost"; // 
$dbname = "project";
$username = "root"; 
$password = ""; 
try {
    //connect to the database//
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //Get form data//
        $eventName = htmlspecialchars($_POST['event_name']);
        $month = (int)$_POST['month'];
        $day = (int)$_POST['day'];
        $year = (int)$_POST['year'];
        $startHour = (int)$_POST['start_hour'];
        $startMinute = (int)$_POST['start_minute'];
        $endHour = (int)$_POST['end_hour'];
        $endMinute = (int)$_POST['end_minute'];
        $description = htmlspecialchars($_POST['description']);
        $location = htmlspecialchars($_POST['location']);
        $price = (float)$_POST['price'];
        $tag = (string)$_POST['tag'];
        $userID = (int)$_SESSION['user_id'];

        $filePath = null; //default value//

        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {//search through the FILES array for uploaded image//
        
            // Get file info
            $fileTmpPath = $_FILES['image']['tmp_name'];
            $fileName = $_FILES['image']['name'];

            $fileNewName = uniqid('', true) . '.' . pathinfo($fileName, PATHINFO_EXTENSION);//assign a new file name for the image//

            $uploadDir = "uploads\\ ";
            $filePath = $uploadDir . $fileNewName;
            move_uploaded_file($fileTmpPath, $filePath);//upload to the file "uploads"//

        }

        //Insert the data into the database//
        $stmt = $pdo->prepare("
            INSERT INTO events (
                eventName, month, day, year, 
                starthour, startmin, endhour, endmin, 
                description, location, price, Tag, userID, Image
            ) VALUES (
                :event_name, :month, :day, :year, 
                :start_hour, :start_minute, :end_hour, :end_minute, 
                :description, :location, :price, :tag, :userID, :image
            )
        ");

        $stmt->execute([
            ':event_name' => $eventName,
            ':month' => $month,
            ':day' => $day,
            ':year' => $year,
            ':start_hour' => $startHour,
            ':start_minute' => $startMinute,
            ':end_hour' => $endHour,
            ':end_minute' => $endMinute,
            ':description' => $description,
            ':location' => $location,
            ':price' => $price,
            ':tag' => $tag,
            ':userID' => $userID,
            ':image' => $fileNewName,
        ]);

        unset($_FILES['image']);//unset the value of image//

        //for developemnt only//
        echo "<h1>Event Created Successfully!</h1>";
        echo "<p><strong>Event Name:</strong> $eventName</p>";
        echo "<p><strong>Date:</strong> $month/$day/$year</p>";
        echo "<p><strong>Time:</strong> $startHour:$startMinute - $endHour:$endMinute</p>";
        echo "<p><strong>Description:</strong> $description</p>";
        echo "<p><strong>Location:</strong> $location</p>";
        echo "<p><strong>Price:</strong> $$price</p>";
        echo "<p><strong>Tag:</strong> $tag</p>";
        echo "<p><strong>Tag:</strong> $userID</p>";

        echo "<script>alert('Event created successfully');</script>";
        header("Location: account.php");//direct back to account page//
        exit();
    }
} catch (PDOException $e) {
    //Handle connection errors//
    die("Database connection failed: " . $e->getMessage());
}
}
?>
