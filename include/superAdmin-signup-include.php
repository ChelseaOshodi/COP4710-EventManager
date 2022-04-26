<?php
if (isset($_POST["submitSA"])) {
	
	session_start();
	extract($_SESSION['post'], EXTR_PREFIX_ALL, "c"); 
	
	$desc = $_POST["desc"];
	$street = $_POST["schoolStreet"];
	$city = $_POST["schoolCity"];
	$state = $_POST["schoolState"];
	$zip = $_POST["schoolZip"];
	
	require_once "dbh-include.php";
	require_once "functions-include.php";
	
	if (emptySignupSA($street, $city, $state, $zip, $desc) !== false) {
		header("location: ../signup.php?error=empty_input");
		exit();
	}

	createSuperAdmin($conn, $c_fullName, $c_email, $c_uPassword, $c_schoolName, $street, $city, $state, $zip, $desc);
}
else {
	header("location: ../signup.php");
	exit();
}
?>