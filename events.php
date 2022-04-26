<?php
	include_once "header.php"
?>

<link rel="stylesheet" href="styles.css">

<script src="javascript/jquery.min.js"></script>
<script src="javascript/Events.js"></script>

<div class="box">
	<div class="heading4">All Available Events</div>

	<section class="events">
		<?php
			if (isset($_SESSION["users_ID"])) {
				$userSchool = getUsersSchool($conn, $_SESSION["users_ID"]);
				$schoolName = getSchoolName($conn, $userSchool);
			}
			else {
					header("location: index.php");
			}
		?>
		<ul class="tilesWrapEvents">
			<?php
				if (isset($_SESSION["users_ID"])) {
					$userID = $_SESSION["users_ID"];
					$eventData = displayAvailableEvents($conn, $userID);
					while($row = mysqli_fetch_assoc($eventData)) {
						echo "<li>";
						$eventID = $row["event_ID"];
						$eventInfo = getEventInfo($conn, $eventID);
						$eventName = $eventInfo["eventName"];
						$eventDesc = $eventInfo["eventDesc"];
						$eventPhone = $eventInfo["eventPhone"];
						$eventDateTime = $eventInfo["eventDateTime"];
						$eventUID = $eventInfo["event_UID"];
						$eventLID= $eventInfo["event_LID"];
						$eventAddyInfo = getAddressInfo($conn, $eventLID);
						$eventStreet = $eventAddyInfo["addyStreet"];
						$eventCity = $eventAddyInfo["addyCity"];
						$eventState = $eventAddyInfo["addyState"];
						$eventZip = $eventAddyInfo["addyZip"];
						$schoolName = getSchoolName($conn, $eventUID);
						$eventDateTime = strtoTime($eventDateTime);
						$eventType = getEventType($conn, $eventID);
					
						if ($eventInfo["event_RID"] !== NULL) {
							$eventRID = $eventInfo["event_RID"];
							$eventRSOname = getRSOName($conn, $eventRID);
							echo "<h2>".$eventRSOname."<br>".$schoolName."</h2>";
						}
						else {
							echo "<h2>" . $schoolName . "</h2>";
						}
						echo "<h4><b>".$eventName."<br>".date('m-d-Y', $eventDateTime). 
								"<br>".date('ha', $eventDateTime) ."</b></h4>";
					
							echo "<p><b style='color: #00759c; font-weight:bold;'>Description:</b><br>".$eventDesc."<br><br>
							<b style='color: #00759c; font-weight:bold;'>Address:</b><br>".$eventStreet."<br>".$eventCity.", ".$eventState." "
							.$eventZip."<br><br><b style='color: #00759c; font-weight:bold;'>Phone Number:<br></b>".$eventPhone."<br><br>
							<b style='color: #00759c; font-weight:bold;'>Event Type:<br></b>".strtoupper($eventType)."</p>";
						
						if (userInEvent($conn, $eventID, $userID) === TRUE) {
							echo "<button type='button'>Event Already Joined</button>";
						}
						else {
							echo "<button type='button' onclick='joinEvent(" . $eventID . ")'>Join Event</button>";
						}
						echo "</li>";
					}
				}
				else {
					header("location: index.php");
				}
			?>
		</ul>
	</section>

</div>

<?php
	include_once "footer.php";
?>