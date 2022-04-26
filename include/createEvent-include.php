<?php

if (isset($_POST["submitrequestevent"])) {
	 
	$rso_ID = $_POST["rso_ID"];
	$eventName = $_POST["eventName"];
	$eventDesc = $_POST["eventDesc"];
	$eventPhone = $_POST["eventphone"];
	$eventDate = $_POST["eventPhone"];
	$eventTime = $_POST["eventTime"];
	$eventTime2 = $_POST["eventTime2"];
	$eventStreet = $_POST["eventStreet"];
	$eventCity = $_POST["eventCity"];
	$eventState = $_POST["eventState"];
	$eventZip = $_POST["eventZip"];
	$eventType = $_POST["eventType"];
	
	require_once "dhb-include.php";
	require_once "functions-include.php";
	
	if (emptyCreateEvent($rso_ID, $eventName, $eventDesc, $eventPhone, $eventDate, $eventTime, $eventTime2,
		$street, $city, $state, $zip, $eventType) !== false) {
		header("location: ../createEvent.php?error=empty_input");
		exit();
	}
	
	$eventTime3 = (int) $eventTime + ($eventTime2 === "pm" ? 12 : 0);
	if ((int)$eventTime === 12) {
		$eventTime3 = $eventTime3 - 12;
	}
	
	$eventDateTime = $eventDate . " " . $eventTime3 . ":00:00";
	$eventAddress =  $eventStreet. ", " .$eventCity. ", ".$eventState." ".$eventZip;
	
	if (eventExists($conn, $eventDateTime, $street, $city, $state, $zip) !== FALSE) {
		header("location: ../createEvent.php?error=time_place_conflict&datetime=".$eventDateTime.
				"&address=".$eventAddres);
		exit();
	}
	
	session_start();
	
	$users_ID = $_SESSION["users_ID"];

	if (valCreateEvent($conn, $rso_ID, $users_ID) === FALSE) {
		header("location: ../createEvent.php?error=invalid_access");
		exit();
	}
	
	$school_ID = getUsersSchool($conn,$users_ID);
	createRSOEvent($conn, $eventName, $eventDesc, $eventPhone, $eventDateTime, 
		$eventStreet, $eventCity, $eventState, $eventZip, $eventType, $users_ID, $rso_ID, $school_ID);
	
	header("location: ../createEvent.php?error=none");
}
else {
	header("location: ../createEvent.php");
	exit();
}