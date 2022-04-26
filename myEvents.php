<?php
	include_once "header.php";
?>

<link rel="stylesheet" href="styles.css">
<script src="javascript/jquery.min.js"></script>
<script src="javascript/MyEvents.js"></script>

<style>
	.modal {
		display: none;
        position: fixed;
        z-index: 8;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.8);
	}
	.modal-content {
		margin: 100px auto;
		background-color: #eee;
        width: 60%;
		border: 1px solid #999;
   		border: inset 1px solid #333;
		padding: 10px;
		border-radius: 10px;
		background-color: -webkit-linear-gradient(bottom, #CCCCCC, #EEEEEE 175px);
    	background-color: -moz-linear-gradient(bottom, #CCCCCC, #EEEEEE 175px);
    	background-color: linear-gradient(bottom, #CCCCCC, #EEEEEE 175px);
		-webkit-box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.3);
    	-moz-box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.3);
    	box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.3);
	}

	input,
    textarea {
        width: 80%;
        padding: 10px;
        margin-bottom: 10px;
        outline: none;

		border-radius: 10px;
		border: 1px solid #999;
   		border: inset 1px solid #333;
		background-color: -webkit-linear-gradient(bottom, #CCCCCC, #EEEEEE 175px);
    	background-color: -moz-linear-gradient(bottom, #CCCCCC, #EEEEEE 175px);
    	background-color: linear-gradient(bottom, #CCCCCC, #EEEEEE 175px);
		-webkit-box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.3);
    	-moz-box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.3);
    	box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.3);
    }
	.modal-content h2 {
		color: #09C;
		text-align: center;
		font-weight: bold;
		font-family: "Roboto";
		font-size: 30px;
		text-shadow: 2px 2px #535353;
	}
	.display_comments button {
        width: 25%;
        padding: 5px;
        border: none;
        background: #888;
        font-size: 14px;
        font-weight: 400;
        color: #fff;
    }
</style>

<div class="box">
	<p class="heading4">Your Events</p>
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
					$eventData = availableUserEvents($conn, $userID);
					while($row = mysqli_fetch_assoc($eventData)) {
						echo "<li>";
						$event_ID = $row["event_ID"];
						$eventInfo = getEventInfo($conn, $event_ID);
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
						$eventType = getEventType($conn, $event_ID);

						if ($eventInfo["event_RID"] !== NULL) {
							$eventRID = $eventInfo["event_RID"];
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
							.$eventZip."<br><br><b style='color: #00759c; font-weight:bold;'>Phone Number:</b><br>".$eventPhone."<br><br>
							<b style='color: #00759c; font-weight:bold;'>Event Type:</b><br>".strtoupper($eventType)."</p>";
						
						echo "<button type='button' onclick='gotoComments(" . $event_ID . ")'>Comments</button></br></br>";
						echo "<button type='button' onclick='leaveEvent(" . $event_ID . ")'>Leave Event</button>";
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


<!-- Comments -->
<div id="modal" class="modal">
	<div class="modal-content">
		<div class="new-comment">
			<a class="close">&times;</a>
			<form method="POST" id="new_comment_form">
				<h2 style="font-size: 30px;">Submit A Comment</h2></br>
				<div>
					<center><textarea id="comment_field" name="comment_field" rows="4" placeholder="Comment goes here."></textarea></center>
					<input type="hidden" id="event_ID" name="event_ID" value="-1">
				</div>
				<span><button type="submit" class='button5-comments' onclick="">Submit</button></span>
			</form>
			<span id="comment_status"></span>
			<br />
			<div class="display_comments" id="display_comments"></div>
		</div>
		
		<div class="comments">
		</div>
	</div>
</div>


<script>

	function alertThenReload(msg) {
		alert(msg);
		window.location.reload(false);
	}

	function gotoComments (event_ID) {
		document.getElementById("modal").style.display = "block";
		document.getElementById("event_ID").value = event_ID;
		listComments();
	}
		
	function listComments() {
		var event_ID = document.getElementById("event_ID").value;
		
		$.ajax({
			url: "include/commentsList-include.php",
			method: "POST",
			dataType: "text",
			data: {method: "commentsListHelp", event_ID: event_ID},
			success: function(data) {
				$("#display_comments").html(data);
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) { 
				alert("Status: " + textStatus);
				alertThenReload("Error: " + errorThrown); 
			}  
		});
	}

	$("#new_comment_form").on("submit", function(event){
		event.preventDefault();
		var form_data = $(this).serializeArray();

		form_data.push({name: "method", value: "submitCommentHelp"});
		$.ajax({
			url: "include/submitComments-include.php",
			dataType: "JSON",
			method: "POST",
			data: $.param(form_data),
			success: function(response) {
				console.log(response);
				if (response != null) {
					document.getElementById("comment_field").value = "";
					$("#comment_status").html(response);
					listComments(event_ID);
				}
				else {
					alertThenReload("Error - Could not create comment.");
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) { 
				alert("Status: " + textStatus);
				alertThenReload("Error: " + errorThrown); 
			}  
		})
	});

	window.onclick = function(event) {
		if (event.target.className === "modal") {
			event.target.style.display = "none";
			$("#comment_status").html("");
		}
	}
</script>

<?php

	include_once "footer.php";

?>