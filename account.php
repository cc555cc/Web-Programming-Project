<?php
session_start();
require_once('connectDatabase.php');


// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: Login.html");
    exit();
}

if($mysqli->connect_error){
        die('Connect Error');
    }else{
        $SQL="SELECT COUNT(*) AS totalRows FROM Events";//get number of events//
        if($result = $mysqli -> query($SQL)){
            $row = $result->fetch_assoc();
            $numEvent =  $row['totalRows'];
        }

        $SQL="SELECT * FROM Events";//get all events and store in temporary array//
        if($result = $mysqli -> query($SQL)){
            $eventArray = array();
            while($row = $result->fetch_assoc()){
                $eventArray[] = $row;
            }
        }
        $mysqli -> close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account - My Events</title>
    <link rel="stylesheet" href="accountAppearance.css?v=<?php echo time(); ?>">
    <script src="accountScript.js?v=<?= time(); ?>" type="text/javascript"></script>
</head>
<body>
    <script type="text/javascript">
        numEvent = "<?php echo $numEvent; ?>";
        eventItemArray = <?php echo json_encode($eventArray); ?>;
        currentUserID = <?php echo $_SESSION['user_id']; ?>;
    </script>
    <!-- Navbar -->
    <nav class="nav-bar">
        <div id="left-buttons">
            <a class="navButton" id="navbar-brand" href="homePage.php"><img src="sitelogo.png" id="site-logo" alt="Site Logo"/></a>
        </div>
        <div id="right-buttons">
            <a class="navButton" id="nav-home-button" href="homePage.php">Home</a>
            <a class="navButton" id="nav-explore-button" href="explorePage.php">Explore</a>
            <a class="navButton" id="nav-account-button" href="account.php">Account</a>
            <a class="navButton" id="nav-logout-button" href="logout.php">Log Out</a>
        </div>
    </nav>

    <!-- Account Events Section -->
    <div class="container">
        <h1> Your Events </h1>

    <!-- Event List -->
    <div class="event-list">
        You haven't created any event...
    </div>
</br>
    <h1> Joined Event </h1>
    <div class="joined-event-list">
        Your haven't join any event...
    </div>

    <!--create event button-->
    <button id="create"><a href="event_form.php">Create Event <strong>+</strong></button>
</body>
</html>
