<?php
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    require_once 'dbh-include.php';
    require_once 'functions-include.php';

    if (emptyLogin($email, $password) !== false) {
		header("location: ../login.php?error=empty_input");
		exit();
	}

    loginUser($conn, $email, $password);
} else {
    header('location: ../login.php');
    exit();
}

/*
foreach ($_POST as $key => $value) {
	$_SESSION['post'][$key] = $value;
}
*/
?>