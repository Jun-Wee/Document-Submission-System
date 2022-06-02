<!-- Description: Submission Page in PHP -->
<!-- Author: Adrian Sim Huan Tze -->
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
				<li><a href="logout.php" class="btn btn-danger navbar-btn" role="button">Log out</a></li>
			</ul>
		</div>
	</nav>
	<div class="container-fluid mb-3 w-25 float-end" id="upload">
		<label for="formFile" class="form-label"><strong>Upload Document</strong></label>
		<input class="form-control" type="file" id="submit">
	</div>
	
	<div class="container w-50 p-3">
		<form action="submit.php" method="post">
			<div class="mb-3">
				<div class="drag-area">
					<div class="icon"></div>
					<header>Drag Document Here to Upload</header>
					<p><strong>Accepted file extensions: .pdf</strong></p>
					<script src="script.js"></script>
				</div>
				<br>
				<label for="dataList" class="form-label"><strong>Select unit: </strong></label>
				<input class="form-control" list="datalistOptions" id="convenor" placeholder="Example: COS10002 / Convenor Name" required="required">
				<datalist id="datalistOptions">
					<option value="SWE40001 Data Visualisation">Convenor A</option>
					<option value="COS30045 Software Engineering Project A">Convenor B</option>
				</datalist>
				<br>
				<div class="row">
					<div class="col-sm-10">
						<button type="submit" class="btn btn-success btn-block float-end" name="btn-docSubmit">Submit Document</button>
					</div>
					<div class="col-sm-2">
						<a href="studentLogin.php" class="btn btn-danger" role="button">Cancel</a>
					</div>
				</div>
			</div>
		</form>
	</div>
	
</body>
</html>