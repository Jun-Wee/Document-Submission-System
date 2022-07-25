<!-- Description: Submission Page in PHP -->
<!-- Author: Adrian Sim Huan Tze -->
<!-- Contributor: Jun Wee Tan -->
<!-- Date: 25th May 2022 -->
<!-- Validated: =-->

<?php
include "classes/user.php";
include "classes/database.php";
include "system_functions.php";

session_start();
if (!isset($_SESSION['student'])) {
	header("Location: studentLogin.php");
} else {
	$db = new Database();
	$student = unserialize($_SESSION['student']);
	$student->fetchEnrolledUnits($db);
	// foreach ($student->enrolledUnits as $unit) {
	// 	echo $unit['code'] . " " . $unit['description'] . " " . $unit['cp'] . " " . $unit['type'] . " " . $unit['convenorID'] . " " . $unit['convenorName'] . "\n";
	// }

	$unitSelected = false;
	$fileUploadErrorMsg = "";
	if (isset($_POST['submit'])) {
		if (isset($_POST['unitOptions'])) {
			if (checkNotEmpty($_POST['unitOptions'])) {
				$unitSelected = true;
				$submission_unit = $_POST['unitOptions'];
				$code = explode(" ", $submission_unit);
				//gets all the info from the uploaded file
				//print_r($file); //testing for file superglobal
				[$fileUploadErrorMsg, $path] = checkUploadedFile($_FILES['file'], $_FILES['file']['name'], $_FILES['file']['tmp_name'], $_FILES['file']['error'], $_FILES['file']['size'], $student, $code[0]);
				if ($fileUploadErrorMsg == "") {
					$student->submitDocument($db, $code[0], $path);
					// $_SESSION['student'] = serialize($student);
					// header('Location: question.php');
				}
			} else {
				$unitSelected = false;
			}
		} else {
			$unitSelected = false;
		}
	} else {
		$fileUploadErrorMsg = "";
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Submission</title>
	<meta name="language" content="english" />
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<link rel="icon" href="src/images/logo.png">
	<link rel="stylesheet" href="style/studentIndexStyle.css">
	<script src="script/script.js"></script>
</head>

<body onload="startTIME();">

	<!--Title-->
	<div class="jumbotron text-center" style="color:white;">
		<h1>Document Submission System</h1>
	</div>

	<!--nav bar-->
	<nav class="navbar navbar-expand-sm navbar-dark bg-dark" id="navbar">
		<div class="container-fluid">
			<div class="collapse navbar-collapse" id="mynavbar">
				<li class="navbar-brand" href="#"><span class="glyphicon glyphicon-user"></span>
					Hello, <?php echo $student->getName(); ?>
				</li>
			</div>
			<span class="navbar-text">
				<h5 style="color: white;" id="time">
					</h6>
		</div>
	</nav>

	<!--content body-->
	<div class="container-fluid">
		<div class="row">
			<!--side bars-->
			<div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
				<div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
					<ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="sidebar">
						<li class="nav-item">
							<a href="submission.php" class="nav-link align-middle px-0" id="active">
								<i class="fs-2 bi bi-file-earmark-pdf" id="navicon-active"></i>
								<span class="ms-1 d-none d-sm-inline" id="navtext-active">Submission</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link align-middle px-0">
								<i class="fs-2 bi bi-question-circle" id="navicon"></i>
								<span class="ms-1 d-none d-sm-inline" id="navtext">FAQ</span>
							</a>
						</li>
					</ul>

					<div class="dropdown">
						<a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="fs-2 bi bi-person"></i>
							<span class="d-none d-sm-inline mx-2"><?php echo $student->getName() ?></span>
						</a>
						<ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
							<li><a class="dropdown-item" href="#">Profile</a></li>
							<li>
								<hr class="dropdown-divider">
							</li>
							<li><a class="dropdown-item" href="studentLogout.php">Sign out</a></li>
						</ul>
					</div>
				</div>
			</div>

			<!--upload document-->
			<div class="col py-3">
				<div class="row">
					<div class="col-8 mx-auto">
						<form action="submission.php" method="POST" enctype="multipart/form-data">
							<div class="mb-3">
								<label for="formFile" class="form-label"><strong>Upload Document</strong></label>
								<input class="form-control" type="file" name="file">
								<br>

								<?php
								if ($fileUploadErrorMsg != "") {
									echo "<div><p>" . $fileUploadErrorMsg . "</p></div>";
								}
								?>

								<!--Select List-->
								<label for="unitOptions" class="form-label"><strong>Select unit </strong></label>
								<select id="unitOptions" name="unitOptions" class="form-select form-select-md">
									<option disabled selected value>Select a unit</option>
									<?php
									foreach ($student->enrolledUnits as $unit) {
										echo "<option value='" . $unit['code'] . " " . $unit['description'] . "'>" . $unit['code'] . " " . $unit['description'] . " - " . $unit['convenorName'] . "</option>";
									}
									?>
								</select>

								<?php
								if (!$unitSelected && isset($_POST['submit'])) {
									echo "<div><p>Please indicate the unit of this submission!</p></div>";
								}
								?>
								<br>

								<!--Buttons-->
								<div class="d-flex justify-content-end">
									<button type="submit" class="btn btn-success me-3" name="submit">Submit </button>
									<button type="reset" class="btn btn-danger" name="reset"> Cancel </button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>

		</div>
	</div>


</body>

</html>