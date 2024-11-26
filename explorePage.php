<?php
session_start();
    require_once('config.inc.php');
    $mysqli = new mysqli(HOST, USER, PASSWORD, DB, PORT);

    if($mysqli->connect_error){
        die('Connect Error');
    }else{
        $SQL="SELECT COUNT(*) AS totalRows FROM Events";
        if($result = $mysqli -> query($SQL)){
            $row = $result->fetch_assoc();
            $numEvent =  $row['totalRows'];
        }

        $SQL="SELECT * FROM Events";//retrieve all event//
        if($result = $mysqli -> query($SQL)){
            $eventArray = array();
            while($row = $result->fetch_assoc()){
                $eventArray[] = $row;//store in a temperary array//
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
    <title>EventSphere</title>
    <script src="explorePageScript.js?v=<?= time(); ?>" type="text/javascript"></script>
    <link rel="stylesheet" href="EventSphere Appearance.css?v=<?php echo time(); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <script type="text/javascript">
        numEvent = "<?php echo $numEvent; ?>";
        eventItemArray = <?php echo json_encode($eventArray); ?>;//temporary array -> javascript array//
    </script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
	  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
      <!--nav bar-->
	<nav class="nav-bar">
        <div id="left-buttons">
            <a class="navButton" id="navbar-brand" href="homePage.php"><img src="sitelogo.png" id="site-logo"/></a>
        </div>

        <div id="right-buttons">
            <a class="navButton" id="nav-home-button" href="homePage.php">Home</a>
            <a class="navButton" id="nav-explore-button" href="explorePage.php">Explore</a>
            <?php
                if(!isset($_SESSION['Logined_In_User'])){
                    echo '<a class="navButton" id="nav-account-button" href="loginPage.php">login</a>';
                }else{
                    echo '<a class="navButton" id="nav-account-button" href="account.php">Account</a>';
                }
            ?>
        </div>
	</nav>


<div class="container">
    <!-- Search Bar -->
    <div class="search-bar">
        <input type="text" id="search-bar" placeholder="Search events">
        <button id="search-button">Search</button>
    </div>

    <!-- Category Bar -->
    <div class="category-bar">
        <a id="tag" href="#" class="active">All</a>
        <a id="tag" href="#">Festivals and Concerts</a>
        <a id="tag" href="#">Seminars</a>
        <a id="tag" href="#">Sports</a>
        <a id="tag" href="#">Cultural Events and Parades</a>
        <a id="tag" href="#">Performing & Visual Arts events</a>
        <a id="tag" href="#">Nightlife</a>
        <a id="tag" href="#">Food & Drink</a>
        <a id="tag" href="#">Charity & Causes</a>
    </div>

    <!-- Featured Section -->
    <div class="featured-section">
        <img src="featured-image.png" alt="EventSphere">
        <div>
            <h3>Discover the perfect event for you </h3>
            <p>Experience incredible festivals and fairs near you. Join us for a vibrant celebration of culture, Sports, and live music that you won’t want to miss!</p>
        </div>
    </div>

    <!-- Event List -->
    <div class="event-list">
        <script>
            
        </script>
    </div>
</div>

<!-- Footer -->
<div class="footer">
</div>

</body>
</html>

	