<?php

if (isset($_POST["submitEventRequest"])) {
	
	$eventName = $_POST["eventName"];
	$eventDesc = $_POST["eventDesc"];
	$eventPhone = $_POST["eventPhone"];
	$eventDate = $_POST["eventDate"];
	$eventTime = $_POST["eventTime"];
	$eventTime2 = $_POST["eventTime2"];
	$eventStreet = $_POST["eventStreet"];
	$eventCity = $_POST["eventCity"];
	$eventState = $_POST["eventState"];
	$eventZip = $_POST["eventZip"];
	$eventType = $_POST["eventType"];
	 
	require_once "dbh-include.php";
	require_once "functions-include.php";
	
	if (emptyRequestEvent($eventName, $eventDesc, $eventPhone, $eventDate, $eventTime, $eventTime2,
		$eventStreet, $eventCity, $eventState, $eventZip, $eventType) !== false) {
		header("location: ../eventRequest.php?error=empty_input");
		exit();
	}
	
	$eventTime3 = (int) $eventTime + ($eventTime2 === "pm" ? 12 : 0);
	if ((int)$eventTime === 12) {
		$eventTime3 = $eventTime3 - 12;
	}

	$eventDateTime = $eventDate. " " .$eventTime3. ":00:00";
	$eventAddress =  $eventStreet. ", " .$eventCity. ", ".$eventState." ".$eventZip;

	if (eventExists($conn, $eventDateTime, $eventStreet, $eventCity, $eventState, $eventZip) !== FALSE) {
		header("location: ../eventRequest.php?error=time_place_conflict&datetime=".$eventDateTime.
				"&address=".$eventAddress);
		exit();
	}
	
	session_start();
	
	$users_ID = $_SESSION["users_ID"];
	
	
	requestEvent($conn, $eventName, $eventDesc, $eventPhone, $eventDateTime, 
		$eventStreet, $eventCity, $eventState, $eventZip, $eventType, $users_ID);
	
	header("location: ../eventRequest.php?error=none");
}
else {
	header("location: ../eventRequest.php");
	exit();
}