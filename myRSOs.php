<?php
	include_once "header.php";
?>

<link rel="stylesheet" href="styles.css">
<script src="javascript/jquery.min.js"></script>
<script src="javascript/MyRSOs.js"></script>

<div class="box">
	<p class="heading4">Your RSOs</p>
	<section class="events">
		<ul class="tilesWrap">
			<?php
				if (isset($_SESSION["users_ID"])) {
					$rsoData = getUserRSOs($conn, $_SESSION["users_ID"]);
					while($row = mysqli_fetch_assoc($rsoData)) {
						echo "<li>";
						$rsoID = $row["rsoUser_RID"];
						$rsoInfo = getRSOInfo($conn, $rsoID);
						$rsoName = $rsoInfo["rsoName"];
						$rsoDesc = $rsoInfo["rsoDesc"];
						$rsoSID = getRSOSchool($conn, $rsoID);
						$schoolName = getSchoolName($conn, $rsoSID);
						echo "<h2>" . $schoolName . "</h2>";
						echo "<h4><b>" . $rsoName . "</b></h4>";
						echo "<p><b style='color: #00759c; font-weight:bold;'>Description:<br></b>" . $rsoDesc . "</p>";
						echo "<button type='button' onclick='leaveRSO(" . $rsoID . ")'>Leave RSO</button>";
						echo "</li>";
					}
				}
				else {
					header("location: index.php");
				}
			?>
		</ul>
</section>

<?php
	include_once "footer.php";
?>