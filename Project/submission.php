<!-- Description: Submission Page in PHP -->
<!-- Author: Adrian Sim Huan Tze -->
<!-- Contributor: Jun Wee Tan -->
<!-- Date: 25th May 2022 -->
<!-- Validated: =-->

<?php
include "classes/user.php";

session_start();
if (!isset($_SESSION['student'])) {
    header("Location: studentLogin.php");
} else {
    $student = unserialize($_SESSION['student']);
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
	<script src="script/script.js"></script>
</head>

<body onload="startTIME();">
	
	<!--Title-->
	<div class="jumbotron text-center" style="color:white;">
		<h1>Document Submission System</h1>
	</div>

	<!--nav bar-->
	<nav class="navbar navbar-expand-sm navbar-dark" id="navbar" style="background-color: rgb(23 14 41);">
		<div class="container-fluid">
			<div class="collapse navbar-collapse" id="mynavbar">
				<li class="navbar-brand" href="#"><span class="glyphicon glyphicon-user"></span>
					Hello, <?php echo $student->getName(); ?>
				</li>
				<ul class="navbar-nav me-auto">
					<li class="nav-item">
						<a class="nav-link" href="">MCQ question</a>
					</li>
				</ul>
			</div>
			<span class="navbar-text">
				<h5 style="color: white;" id="time"></h6>
		</div>
	</nav>

	
	<!--Upload document by button-->
	<div class="container w-50 p-3">
		<form action="upload.php" method="POST" enctype="multipart/form-data">
			<div class="mb-3">

				<div class="row mx-auto" name="upload">
					<label for="formFile" class="form-label" style="margin-left: -11px;"><strong>Upload Document</strong></label>
					<input class="form-control" type="file" name="file">
				</div>
				<br>
				
				<!--Select List-->
				<label for="dataList" class="form-label"><strong>Select unit: </strong></label>
				<input class="form-control" list="datalistOptions" id="convenor" placeholder="Example: COS10002 / Convenor Name">
				<datalist id="datalistOptions">
					<option value="SWE40001 Data Visualisation">Convenor A</option>
					<option value="COS30045 Software Engineering Project A">Convenor B</option>
				</datalist>
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
		<button class="btn btn-danger" name="reset"> <a href="studentLogout.php">Log Out</a>
		
	</div>
</body>

<!--abondon (drag area)-->
<!-- <div class="drag-area">
	<div class="icon"></div>
	<header>Drag Document Here to Upload</header>
	<p><strong>Accepted file extensions: .pdf</strong></p>
	<script src="script.js"></script>
</div> -->
</html>