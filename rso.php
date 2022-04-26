<?php
	include_once "header.php"
?>

<link rel="stylesheet" href="styles.css">
<script src="javascript/jquery.min.js"></script>
<script src="javascript/RSOs.js"></script>

<div class="box">
	<div class='heading4'>
		<center>
			<?php
			if (isset($_SESSION["users_ID"])) {
				$userSchool = getUsersSchool($conn, $_SESSION["users_ID"]);
				$schoolName = getSchoolName($conn, $userSchool);
				echo "<p>All RSOs for " .$schoolName. "</p>";
			}
			else {
					header("location: index.php");
			}
			?>
		</center>
	</div>
	<section class="events">
		<ul class="tilesWrap">
			<?php
				if (isset($_SESSION["users_ID"])) {
					$userID = $_SESSION["users_ID"];
					$userSchool = getUsersSchool($conn, $userID);
					$rsoData = getSchoolRSOs($conn, $userSchool);
					while($row = mysqli_fetch_assoc($rsoData)) {
						echo "<li>";
						$rsoID = $row["rsoSchool_RID"];
						$rsoInfo = getRSOInfo($conn, $rsoID);
						$rsoName = $rsoInfo["rsoName"];
						$rsoDesc = $rsoInfo["rsoDesc"];
						$rsoSID = getRSOSchool($conn, $rsoID);
						$schoolName = getSchoolName($conn, $rsoSID);
						echo "<h2>" . $schoolName . "</h2>";
						echo "<h4><b>" . $rsoName . "</b></h4>";
						echo "<p><b style='color: #00759c; font-weight:bold;'>Description:<br></b>" . $rsoDesc . "</p>";
						
						if (userInRSO($conn, $rsoID, $userID) === TRUE) {
							echo "<button type='button'>RSO Already Joined</button>";
						}
						else {
							echo "<button type='button' onclick='joinRSO(" . $rsoID . ")'>Join RSO</button>";
						}
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

<?php
	include_once "footer.php";
?> 