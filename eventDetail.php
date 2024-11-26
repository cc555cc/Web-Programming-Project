<?php
session_start(); 
	
	if (isset($_GET['eventID'])) {//receive eventID from the link in abstract event display in home page/explore page/account page//
    	$eventId = $_GET['eventID'];
	} 

	if(isset($_GET['popularity']) && isset($_GET['eventID']) ){//for the like button feature//
		require_once('like.php');
	}

	require_once('config.inc.php');//connection//
	$mysqli = new mysqli(HOST, USER, PASSWORD, DB, PORT);

	if($mysqli->connect_error){
		die('Connect Error');
	}else{
		$SQL="SELECT * FROM Events WHERE eventID = $eventId";//retrieve single event of specific id from the database//
		if($result = $mysqli -> query($SQL)){
			$row = $result->fetch_assoc();
			$userID = $row['userID'];
			$eventName = $row['EventName'];
			$month = $row['Month'];
			$day = $row['Day'];
			$year = $row['Year'];
			$startHour = $row['StartHour'];
			$startMin = $row['StartMin'];
			$endHour = $row['EndHour'];
			$endMin = $row['EndMin'];
			$eventLocation = $row['Location'];
			$Description = $row['description'];
			$price = $row['Price'];
			$imagePath = $row['Image'];
			$popularity = $row['popularity'];
			if($row['guestIDs'] != null){//if the guest list as value//
				$guestIDList = json_decode($row['guestIDs'],true) ?? []; //retrieve JSON object and transform it to javascript object//
			}else{
				$guestIDList = array(); //make a new array//
			}

			//transformer guestIDList to guestNameList//
			$guestNameList = array();
			for($i = 0; $i < count($guestIDList); $i++){
				$SQL="SELECT * FROM Users WHERE userID = " . $guestIDList[$i];//pick users from the database based on the ID read//
				if($result = $mysqli -> query($SQL)){
					$row = $result->fetch_assoc();
					array_push($guestNameList,$row['userName']);//add the userName to the array//
				}
			}

		}

		$SQL="SELECT * FROM Users WHERE userID = $userID";//retrieve the userID of the event creator based on the value stored in the Events table//
		if($result = $mysqli -> query($SQL)){
			$row = $result->fetch_assoc();
			$userName = $row['userName'];
		}

		$mysqli -> close();
	}
?>
<!Doctype html>
<html>
<head>
	<title> Event Detail </title>
	<script src="eventDetailScript.js?v=<?= time(); ?>" type="text/javascript"></script>
	<link rel="stylesheet" href="newStyle.css?v=<?php echo time(); ?>"/>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
	<script type="text/javascript">
		eventId = "<?php echo $eventId; ?>";
		userId = "<?php echo $userID; ?>";
		eventName = "<?php echo $eventName; ?>";
		month = "<?php echo $month; ?>";
		day = "<?php echo $day; ?>";
		year = "<?php echo $year; ?>";
		startHour = "<?php echo $startHour; ?>";
		startMin = "<?php echo $startMin; ?>";
		endHour = "<?php echo $endHour; ?>";
		endMin = "<?php echo $endMin; ?>";
		eventLocation = "<?php echo $eventLocation; ?>";
		description = "<?php echo $Description; ?>";
		price = "<?php echo $price; ?>";
		image = "<?php echo $imagePath; ?>";
		//alert(image);
		userName = "<?php echo $userName; ?>";
		popularity = "<?php echo $popularity; ?>"

		guestList = <?php echo json_encode($guestNameList); ?>;


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

	</nav></br>

	<!--image, details part-->
	<div class="event-detail-display-box">
		<!--user provide image display-->
		<div class="event-main-image">
			<img src="default-image.jpg" alt="default image" id="event-main-image"/>
		</div>
		<br>
		<!--display event information-->
		<div class="event-information">
			<!--display creator's name, like button, price and join button-->
			<div class="right-side-element">
				<!--display creator's name-->
				<div class="user-profile-display-box">
					<div class="avatar-and-username">
						<p>created by:</p>
						<p id="username">username</p>
					</div>
					<span id="about-user"><!--now this is used to store the like button-->
						<form method="GET" action="">
							<fieldset>
								<input type="hidden" id="like-value-1" name="popularity" value=""><!--store the popularity value-->
								<input type="hidden" id="like-value-2" name="eventID" value=""><!--store the eventID-->
								<input type="image" name="popularity"  src="like.png" id="like-button">
							</fieldset>
						</form>
						<p id="popularity-display"></p>
					</span>
				</div>
				<br>
				<p id="price">Price</p>
				<form action="" method="POST">
					<fieldset id="join-section" >
						<input type="submit" id="join-event-button"  value="Join-Event">
						<?php
   
    						if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        						if (!isset($_SESSION['Logined_In_User'])) {
            						echo "<script>alert('you are not logged in');</script>";
            					}else{
            						require_once('addGuest.php');
            					}
            				}
            			?>
					</fieldset>
			
				</form>

			</div>

			<!--left side element-->
			<h1 id="event-info-name">Event Name</h1>

			<!--Date-->
			Date: <span id="event-month"></span>-<span id="event-day"></span>-<span id="event-year"></span>
			<br>

			<!--time-->
			Time: <span id="start-hour">hour</span> :
			<span id="start-min">min</span> - 
			<span id="end-hour">hour</span> :
			<span id="end-min">min</span><br>

			<!--location-->
			Location: <span id="event-location"></span><br>

			<!--description-->
			description:<p id="event-info-description"></p>

			<div id="event-info-description-text-box"></div>

			<!--guest list-->

			Guest List:
			<div id="event-guest-list">
				<p id="event-guest-list-filler">There is no guest for this event right now</p>
			</div>
		</div>
	</div>


</body>
<html>