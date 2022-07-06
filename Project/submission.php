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
		if(isset($_POST['unit'])){
			if(checkNotEmpty($_POST['unit'])){
				$unitSelected = true;
				$submission_unit = $_POST['unit'];
				$code = explode(" ", $submission_unit);
				//gets all the info from the uploaded file
				//print_r($file); //testing for file superglobal
				[$fileUploadErrorMsg, $path] = checkUploadedFile($_FILES['file'], $_FILES['file']['name'], $_FILES['file']['tmp_name'], $_FILES['file']['error'], $_FILES['file']['size'], $student);
				if($fileUploadErrorMsg == ""){
					$student->submitDocument($db, $code[0], $path);
					$_SESSION['student'] = serialize($student);
            		header('Location: question.php');
				} 
			}else{
				$unitSelected = false;
			}
		}else{
			$unitSelected = false;
		}
	}else{
		$fileUploadErrorMsg = "";
	}
}
?>

<!DOCTYPE html>
<html lang ="en">
<head>
	<title>Submission</title>
	<meta name="language" content="english" />
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<link rel="stylesheet" href="style/studentIndexStyle.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</head>
<body>
	<div class="jumbotron text-center">
		<h1>Document Submission System</h1>
	</div>
	<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
		<div class="container-fluid">
			<li class="navbar-brand" href="#"><span class="glyphicon glyphicon-user"></span>
				Hello, <?php echo $student->getName(); ?>
			</li>
			<ul class="nav navbar-nav navbar-right">
				<li><p class="navbar-text"><?php echo date("d M Y")?></p></li>
				<li>...</li>
				<li><a href="studentLogout.php" class="btn btn-danger navbar-btn" role="button">Log out</a></li>
			</ul>
		</div>
	</nav>

	<!--Upload document by button-->
	<!-- <div class="container-fluid mb-3 w-25 float-end" id="upload">
		<label for="formFile" class="form-label"><strong>Upload Document</strong></label>
		<input class="form-control" type="file" id="submit">
	</div> -->
	
	<!--Upload document by drag-->
	<div class="container w-50 p-3">

		<form action="submission.php" method="POST" enctype="multipart/form-data">
			<div class="mb-3">
				<!-- <div class="drag-area">
					<div class="icon"></div>
					<header>Drag Document Here to Upload</header>
					<p><strong>Accepted file extensions: .pdf</strong></p>
					<script src="script.js"></script>
				</div> -->

				<div class="row mx-auto" name="upload">
					<label for="formFile" class="form-label" style="margin-left: -11px;"><strong style="color: white">Upload Document</strong></label>
					<input class="form-control" type="file" name="file">
				</div>
				<br>

				<?php
					if ($fileUploadErrorMsg != "") {
						echo "<div><p>" . $fileUploadErrorMsg . "</p></div>";
					}
				?>
				
				<!--Select List-->
				<label for="dataList" class="form-label"><strong>Select unit: </strong></label>
				<input list="unitOptions" name="unit" class="form-control" id="convenor" placeholder="COS10009 Intro to Programming / Convenor">
				<datalist id="unitOptions">
					<?php
						foreach ($student->enrolledUnits as $unit) {
							echo "<option value='".$unit['code']." ".$unit['description']."'>". $unit['convenorName'] . "</option>";
						}
					?>
				</datalist>

				<?php
					if (!$unitSelected && isset($_POST['submit'])) {
						echo "<div><p>Please indicate the unit of this submission!</p></div>";
					}
				?>
				<br>

				<!--Buttons-->
				<div class="row">
					<div class="col-sm-10">
						<button type="submit" class="btn btn-success btn-block float-end" name="submit">Submit Document
					</div>
					<div class="col-sm-2">
						<button type="reset" class="btn btn-danger" name="reset"> Cancel
					</div>
				</div>
			</div>
		</form>
	</div>
	
</body>
</html>