<?php

include_once "dbh-include.php";
include_once "functions-include.php";

echo submitCommentHelp($conn);

function submitdCommentHelp($conn) {
	echo json_encode("Tddest");
}

function submitCommentHelp($conn) {

	if (isset($_POST["event_ID"])) {
		$event_ID = $_POST["event_ID"];
	}
	if (isset($_POST["comment_field"])) {
		$desc = $_POST["comment_field"];
	}
	
	session_start();
	
	$users_ID = $_SESSION["users_ID"];
	$data = '';

	$status = createComment($conn, $event_ID, $users_ID, $desc);

	if ($status == FALSE) {
		$data = "Unable to add comment.";
	}
	elseif ($status == "0"){
		$data = "Unable to add comment2.";
	}
	else {
		$data = "Comment added";
	}
	
	echo json_encode($data);
}