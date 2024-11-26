<?php
session_start();
if (isset($_GET['loadTopEvents']) && $_GET['loadTopEvents'] == 'true') {//when the divison below request the top events from the database//
require_once('config.inc.php');

$mysqli = new mysqli(HOST, USER, PASSWORD, DB, PORT);

if ($mysqli->connect_error) {
    die('Connect Error: ' . $mysqli->connect_error);
}else{


    $SQL = "SELECT * FROM Events ORDER BY popularity DESC LIMIT 3";//retrieve 3 events bease on their popularity//
    $topEvents = array();
    if ($result = $mysqli->query($SQL)) {
        while ($row = $result->fetch_assoc()) {
            $topEvents[] = $row;//push event into the array//
        }
    }
    echo json_encode($topEvents);//turn to JSON object//
    $mysqli->close();
    exit();
}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventSphere - Homepage</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <!-- Navbar -->
    <header>
        <div class="navbar">
            <div class="logo">
                <img id="site-logo" src="sitelogo.png" alt="EventSphere Logo" style="max-width: 150px;">
            </div>
            <nav>
                <ul>
                    <li><a href="homePage.php">Home</a></li>
                    <li><a href="explorePage.php">Explore Events</a></li>
                    <li><?php
                if(!isset($_SESSION['Logined_In_User'])){
                    echo '<a class="navButton" id="nav-account-button" href="loginPage.php">login</a>';
                }else{
                    echo '<a class="navButton" id="nav-account-button" href="account.php">Account</a>';
                }
            ?></li>
                    
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-text">
            <h1>Discover the Best Events For You</h1>
            <p>From concerts to sports, find your next adventure with EventSphere!</p>
            <a href="explorePage.php" class="cta-button">Explore Events</a>
        </div>
    </section>

    <!-- Top 3 Events Section -->
    <section class="top-events">
        <div class="container">
            <h2>Top 3 Popular Events</h2>
            <div id="top-event-list" class="event-list">
                <p>Loading top events...</p>
            </div>
        </div>
    </section>


    <!-- Footer -->
    <footer>
        <p></p>
    </footer>

    <script>
        $(document).ready(function () {
            // Load top 3 popular events
            $.ajax({//use .ajax() to interact with php object//
                url: 'homePage.php',
                method: 'GET',
                data: { loadTopEvents: 'true' },//retrieve the loadTopEvents from the php code//
                success: function (data) {
                    console.log('Raw response:', data);
                    try{

                    const topEvents = JSON.parse(data);//trasnsform back to javascript object//
                    const topEventList = $('#top-event-list');
                    topEventList.empty();

                    if (topEvents.length > 0) {//If there are events in the list//
                        topEvents.forEach((event, index) => {//then create abstract event object//
                            const topEventItem = `
                                <div class="event-item">
                                    <span class="ranking">${index + 1}</span> <!-- Display ranking -->
                                    <img src="uploads\\ ${event.Image}" alt="${event.title}">
                                    <div class="event-info">
                                        <h3>${event.EventName}</h3>
                                        <p>Date: ${event.Day}-${event.Month}-${event.Year}</p>
                                        <p class="price">$${event.Price}</p>
                                        <a href="eventDetail.php?eventID=${event.eventID}" class="btn">View Details</a>
                                    </div>
                                </div>`;
                            topEventList.append(topEventItem);//append to the division//
                         });
                    } else {
                        topEventList.append('<p>No popular events available.</p>');//default case//
                    } 
                }catch(error){

                }
                },
                error: function () {
                    $('#top-event-list').html('<p>Error loading top events. Please try again later.</p>');//error case//
                }
            });
        });
    </script>
    
</body>
</html>
