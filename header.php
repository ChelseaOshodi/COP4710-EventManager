<?php
session_start();
include_once "include/dbh-include.php";
include_once "include/functions-include.php";
?>

<link rel="stylesheet" href="styles.css">

<head>
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Permanent+Marker" />
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Just+Another+Hand" />


	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@900&display=swap" rel="stylesheet">

	<link href="styles.css" rel="stylesheet" media="all">
	<div class="heading2-header"><a href="index.php"> College Event Manager</a></div>
	<title class="heading2">College Event Manager</title>
	<meta name="description" content="COP4710 Spring 2022" />
</head>

<div class="navigation">
	<ul>
		<?php
			if (isset($_SESSION["users_ID"])) {
				$users_ID = $_SESSION["users_ID"];
				echo "<a href = 'index.php'>Home</a>";
				echo "<a href = 'myEvents.php'>My Events</a>";
				echo "<a href = 'myRsos.php'>My RSOs</a>";
				echo "<a href = 'events.php'>Events</a>";
				echo "<a href = 'rso.php'>RSOs</a>";
				
				if (isAdmin($conn, $users_ID) !== FALSE) {
					echo "<a href = 'createEvent.php'>Create Event</a>";
				}
				if (isSuperAdmin($conn, $users_ID) !== FALSE) {
					echo "<a href = 'pendingEvents.php'>Pending Events</a>";
				}
				if (isAdmin($conn, $users_ID) === FALSE && isSuperAdmin($conn, $users_ID) === FALSE) {
					;
				}

				echo "<a href = 'eventRequest.php'>Request Event</a>";
				echo "<a href = 'createRSO.php'>Create RSO</a>";
				echo "<a href = 'include/logout-include.php'>Log Out</a>";
			}
			else {
				echo "<a href = 'index.php'>Home</a>";
				echo "<a href = 'signup.php'>Sign Up</a>";
				echo "<a href = 'login.php'>Log In</a>";
			}
		?>
	</ul>
</div>