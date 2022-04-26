<?php
include_once "header.php";
?>

<!doctype html>
<html style="margin: 0; height: 100%;">
	<div class="box">
		<?php if(!isset($_SESSION['users_ID'])): ?>	

			<div class="box3" style="background-color: #7b97ba;">
				<body style="background-color: #7b97ba;">	
					<br>
					<center>
						<span class="heading2-2">
							<span class="heading2-2">
								<a href="index.php" style=" color: rgb(39, 39, 39); text-decoration: none;">College Event Manager</a>
							</span>
						</span>
					</center>
					<br>
					<img class="image1" src="indexPicture.webp" alt="indexPicture">
					<hr style="border: 4px solid #09C;">
					<center>
						<p class="body">
							<br>
							<span class="heading-i">Have an account?</span>
							<form action='login.php' method='post'>
								<button type='submit' name='login' class="button-index">Login</button>
							</form>
						</p>
					</center>	
					<center><p class="body">
						<span class="heading-i">Don't have an account?</span>
						<form action='signup.php' method='post'>
							<button type='submit' name='signUp' class="button-index">Register</button>
						</form>
					</p></center>
				</body>
			</div>

		<?php else: ?>

			<div class="box-index">
			<body style="background-color: #7b97ba;">	
				<br>
				<div class="logo heading2-index">
					<?php
						echo "Welcome, " .$_SESSION["fullName"]. "!";
					?>
					</br>
					<br>
					<div style="font-size: 20px; color: #09C; text-shadow:none; line-height: 20px;">
						To get started with your College Event Manager use the links above.
					</div>
				</div>
				<br>
				<img class="image1-2" src="calender.png" alt="indexPicture">
			</body>
			</div>
		<?php endif; ?>
		</br></br></br>
	</div>
</html>