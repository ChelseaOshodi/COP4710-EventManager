<?php
	include_once "header.php";
?>

<link rel="stylesheet" href="styles.css">
<script src="javascript/jquery.min.js"></script>
<script src="javascript/PendingEvents.js"></script>

<div class="box">
	<p class="heading4">All Pending Events for Your School</p>
	<section class="events">
		<ul class="tilesWrapEvents">
			<?php
				if (isset($_SESSION["users_ID"]) AND isSuperAdmin($conn, $_SESSION["users_ID"]) !== FALSE) {
					$users_ID = $_SESSION["users_ID"];
					$rsoData = getEventRequests($conn, $users_ID);
					while($row = mysqli_fetch_assoc($rsoData)) {
						echo "<li>";
						$eventID = $row["eApproval_EID"];
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

						if ($eventinfo["event_RID"] !== NULL) {
							$eventRID = $eventinfo["event_RID"];
							$eventRSOname = getRSOName($conn, $eventRID);
							echo "<h2>" . $eventRSOname . "<br>" . $schoolName . "</h2>";
						}
						else {
							echo "<h2>" . $schoolName . "</h2>";
						}
						echo "<h4><b>" . $eventName . "<br>" . date('m-d-Y', $eventDateTime) . 
								"<br>" . date('ha', $eventDateTime) ."</b></h4>";
						
						echo "<p><b style='color: #00759c; font-weight:bold;'>Description:</b><br>".$eventDesc."<br><br>
							<b style='color: #00759c; font-weight:bold;'>Address:</b><br>".$eventStreet."<br>".$eventCity.", ".$eventState." "
							.$eventZip."<br><br><b style='color: #00759c; font-weight:bold;'>Phone Number:<br></b>".$eventPhone."<br><br>
							<b style='color: #00759c; font-weight:bold;'>Event Type:<br></b>".strtoupper($eventType)."</p>";

						echo "<button type='button' onclick='acceptEvent(" . $eventID . ")'>ACCEPT</button>";
						echo "<br><br>";
						echo "<button type='button' onclick='denyEvent(" . $eventID . ")'>DENY</button>";
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