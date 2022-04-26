<?php
	include_once "header.php";
?>
 
<?php
	if (isset($_POST["submit"])) {
		
		$fullName = $_POST["fullName"];
		$email = $_POST["email"];
		$uPassword = $_POST["uPassword"];
		$passwordConfirm = $_POST["passwordConfirm"];
		$schoolName = $_POST["schoolName"];
		
		require_once "include/dbh-include.php";
		require_once "include/functions-include.php";
		
		if (emptyInputSignup($fullName, $email, $uPassword, $passwordConfirm, $schoolName) !== false) {
			header("location: signup.php?error=empty_input");
			exit();
		}

		if (invalidEmail($email)  !== false) {
			header('location: signup.php?error=invalid_email');
			exit();
		}
		
		if (passwordMismatch($uPassword, $passwordConfirm) !== false) {
			header("location: signup.php?error=password_mismatch");
			exit();
		}
		
		if (emailExists($conn, $email) !== false) {
			header("location: signup.php?error=email_exists");
			exit();
		}

		if (schoolExists($conn, $schoolName) !== false) {
			createUser($conn, $fullName, $email, $uPassword, $schoolName, TRUE);
			exit();
		}
	}
	else {
		header("location: signup.php");
		exit();
	}

	foreach ($_POST as $key => $value) {
		$_SESSION['post'][$key] = $value;
	}
?>

<div class="box">
	<form action="include/superAdmin-signup-include.php" class="form5" method="post">
        <div>
            <p class="heading2 ">New School Information</p>
			<p class="heading5"> Complete new school registration to become super-admin for the school. </p>
				<span class="label5">School Address</span>
				<input class="input5" type="text" name="schoolStreet"  placeholder="Street Address" required>
				<div class="col-container">
					<div class="column1_3">
							<input class="input6_3" type="text" name="schoolCity" placeholder="City" required>
					</div>
					<div class="column2_3">
							<input class="input6_3" type="text" name="schoolState" placeholder="State" required>
					</div>
					<div class="column3_3">
							<input class="input6_3" type="text" name="schoolZip" placeholder="Zip Code" required>
					</div>
				</div>
			</label>

            <label>
            	<span class="label5">School Description</span>
				<input class="input5" type="text" name="desc">
            </label>

            <button class="button5" type="submit" name="submitSA">Sign Up</button>
        </div>
    </form>
</div>

<?php
	include_once "footer.php";
?>