<?php

header('Content-Type: application/json');

include_once "dbh-include.php";
include_once "functions-include.php";

echo $_POST["method"]($conn);

function leaveEventHelp($conn) {
	if (isset($_POST["EID"])) {
		$eventID = json_decode($_POST["EID"]);
	}
	
	session_start();
	
	$users_ID = $_SESSION["users_ID"];

	leaveEvent($conn, $eventID, $users_ID);
	echo json_encode(array('status' => 'ok'));
}