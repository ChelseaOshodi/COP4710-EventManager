<?php
	include_once "header.php"
?>

<?php
	if (!isset($_SESSION["users_ID"]) OR isAdmin($conn, $users_ID) === FALSE) {
		header("location: index.php");
	}
?>

<div class="box">
	<?php
		$message = null;
		if(isset($_GET["error"])) {
			if ($_GET["error"] == "empty_input") {
				$message = "<p style='color:#500'>All fields must be filled in.<br><br></p>";
			}
			if ($_GET["error"] == "bad_stmt") {
				$message = "<p style='color:#500'>Database error. Please try again.<br><br></p>";
			}
			if ($_GET["error"] == "time_place_conflict") {
				if(isset($_GET["datetime"]) AND isset($_GET["ddress"])) {
					$message = "<p style='color:#500'>Event already exists on ".$_GET["datetime"].
							"<br>at address= " .$_GET["address"].".<br><br></p>";
				}
				else {
					$message = "<p style='color:#500'>Event already exists (could not grab details).<br><br></p>";
				}
			}
			if ($_GET["error"] == "invalid_access") {
				$message = "<p style='color:#500'>You do not have permission to create an event for this RSO.<br><br></p>";
			}
			if ($_GET["error"] == "none") {
				$message = "<p style='color:#500'>Event submitted.<br><br></p>";
			}
		}
	?>

	<form class="form5" action="include/createEvent-include.php" method="post">
		<div>
			<p class="heading2">Create RSO Event</p>
			<div class="error5">
				<?php
					if (!is_null($message)) {
					echo $message;
					}
				?>
			</div>
			
			<span><div style="padding-bottom:20px !important;">
				<center><h2><b style="color:#09c;">Event General Information</b></h2></center>
			</div></span>

			<label>
				<span class="label5">Select your RSO</span>
				<div class="rs-select2">
					<select class="input5" name="rsoID" style="width: 375px; height:25px;" required>
						<?php
							$userID = $_SESSION["users_ID"];
							$activeRSOdata = activeRSOs($conn, $userID);
							$x = 0;
							while ($row = mysqli_fetch_assoc($activeRSOdata)) {
								$x = $x + 1;
								$rsoID = $row["rso_ID"];
								$rsoName = $row["rsoName"];
								echo "<option value=$rsoID>$rsoName</option>";
							}
							if ($x === 0) {
								echo "<option disabled='disabled' selected='selected'>NO ACTIVE RSOs</option>";
							}
							else {
								echo "<option disabled='disabled' selected='selected'>SELECT RSO...</option>";
							}
						?>
					</select>
				<div class="select-dropdown"></div>
			</div>
            </label>

            <label>
            	<span class="label5">Event Name</span>
				<input class="input5" type="text" name="eventName" required>
            </label>

			<label>
            	<span class="label5">Event Description</span>
				<input class="input5" type="text" name="eventDesc" required>
            </label>

			<label>
            	<span class="label5">Event Contact Number</span>
				<input class="input5" type="tel" id="eventPhone" name="eventPhone" placeholder="123-456-7890"
				pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required>
            </label>

			<label>
				<span class="label5">Event Date</span>
				<input class="input5" type="date" name="eventDate" placeholder="EVENT DATE" required>
				<i class="zmdi zmdi-calendar-note input-icon js-btn-calendar"></i>
			</label>

			<label>
				<span class="label5">Event Time</span>
				<div class="col-container">
					<div class="column1">
						<div class="rs-select2">
							<select class="input7" name="eventTime" required style="width: 100%; height:25px;">
								<?php
									$select = 0;
									for ($i = 0; $i < 12; $i++) {
										$select = (($i + 11) % 12) + 1;
										echo "<option value=$select>$select</option>";
									}
								?>
							</select>
							<div class="select-dropdown"></div>
						</div>
					</div>
					<div class="column2">
						<div class="rs-select2">
							<select name="eventTime2" required style="width: 100%; height:25px; border-radius: 5px; border: 1px solid #999;
								-webkit-box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.3);-moz-box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.3);
    							box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.3);">
								<option value="am">AM</option>
								<option value="pm">PM</option>
							</select>
							<div class="select-dropdown"></div>
						</div>
					</div>
				</div>
			</label>

			<label>
				<span class="label5">Event Address</span>
				<input class="input5" type="text" name="eventStreet"  placeholder="Street Address" required>
				<div class="col-container">
					<div class="column1_3">
							<input class="input6_3" type="text" name="eventCity" placeholder="City" required>
					</div>
					<div class="column2_3">
							<input class="input6_3" type="text" name="eventState" placeholder="State" required>
					</div>
					<div class="column3_3">
							<input class="input6_3" type="text" name="eventZip" placeholder="Zip Code" required>
					</div>
				</div>
			</label>

			<label>
				<span class="label5">Event Type</span>	
				<div class="rs-select2">
					<select class="input5" name="eventType" required style="width: 375px; height:25px;">
						<option disabled="disabled" selected="selected">Select Event Type...</option>
						<option value="public">Public</option>
						<option value="private">Private</option>
						<option value="rso">RSO</option>
					</select>
					<div class="select-dropdown"></div>
				</div>
			</label>

            <button class="button5" type="submit" name="submitRequestEvent">Submit</button>
		</div>
	</form>

</div>

<?php
	include_once "footer.php";
?>