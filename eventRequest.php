<?php
	include_once "header.php"
?>

<div style="font-family: Tahoma, Geneva, sans-serif; color:#9f1f06; font-size:12px; padding-bottom: 2px;">
	<center>
		<?php
			if (!isset($_SESSION["users_ID"])) {
				header("location: index.php");
			}
			if (isSuperAdmin($conn, $users_ID) !== FALSE) {
				echo "<h2>You are a super-admin, so after creating an event you will need to accept it yourself. </h2>";
			}
		?>
	<center>
	</div>

<div class="box">
	<?php
		$message = null;
		if(isset($_GET["error"])) {
			if ($_GET["error"] == "empty_input") {
				$message = "<p style='color:red'>You must fill in all fields.<br><br></p>";
			}
			if ($_GET["error"] == "bad_stmt") {
				$message =  "<p style='color:red'>Database error. Please try again.<br><br></p>";
			}
			if ($_GET["error"] == "bad_stmt2") {
				$message =  "<p style='color:red'>Error.<br><br></p>";
			}
			if ($_GET["error"] == "time_place_conflict") {
				if(isset($_GET["datetime"]) AND isset($_GET["lat"]) AND isset($_GET["long"])) {
					$message = "<p style='color:red'>Event already exists on ".$_GET["datetime"].
							"<br>at LATITUDE= " .$_GET["lat"]. ", LONGITUDE= ".$_GET["long"].".<br><br></p>";
				}
				else {
					$message = "<p style='color:red'>Event already exists (could not grab details).<br><br></p>";
				}
			}
			if ($_GET["error"] == "none") {
				$message = "<p style='color:#500'>Event request submitted. Waiting for super-admin approval.<br><br></p>";
			}
		}
	?>

	<form class="form5" action="include/eventRequest-include.php" method="post">
		<div>
			<p class="heading2">Request An Event</p>
			<div class="error5">
				<?php
				if (!is_null($message)) {
				echo $message;
				}
				?>
			</div>
			<span><div style="padding-bottom:10px !important;">
				<center><h2><b style="color:#09c;">Event General Information</b></h2></center>
			</div></span>
			<label>
				<span class="label5">Event Name</span>
				<input class="input5" type="text" name="eventName">
			</label>

			<label>
				<span class="label5">Event Description</span>
				<input class="input5" type="text" name="eventDesc">
			</label>

			<label>
				<span class="label5">Event Contact Number</span>
				<input class="input5" type="tel" name="eventPhone" placeholder="123-456-7890" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required>
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
				<input class="input5" type="text" name="eventStreet" placeholder="Street Address" required>
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
					</select>
					<div class="select-dropdown"></div>
				</div>
			</label>

			<button class="button5" type="submit" name="submitEventRequest">Submit</button>
		</div>
	</form>

</div>

<?php
	include_once "footer.php";
?>