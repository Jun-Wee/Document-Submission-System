<?php
session_start();	//Starts the session
include_once 'dbconnect.php';
?>

<!DOCTYPE html>
<html lang ="en">
<head>
	<title>Home | Document Submission System</title>
	<meta name="language" content="english" />
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	
	<style>
		#signin {
		background-color: grey;
		width: 800px;
		color: #fff;
		height: 450px;
		}
		#signin a {
			color: green;
		}
		
		#btn-docSubmit {
			width: 300px;
			height: 400px;
		}
		
		.drag-area {
			border: 2px dashed;
			height: 200px;
			width: 700px;
			border-radius: 5px;
			display: flex;
			align-items: center;
			flex-direction: column;
		}
		
		.drag-area.active {
			border: 2px solid #fff;
		}
		
		.drag-area header {
			font-size: 30px;
			font-weight: 500;
			color: #fff;
		}
		
		body {
			background-image: url("submit-wallpaper.jpg");
			background-size: cover;
		}
		
		.container {
			background-color: #9932CC;
			border-radius: 5px;
		}
		
		.upload {
			
		}

	</style>
</head>
<body>
	<div class="jumbotron text-center">
		<h1>Document Submission System</h1>
	</div>
	<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
		<div class="container-fluid">
			<li class="navbar-brand" href="#"><span class="glyphicon glyphicon-user"></span>
				Hello, <?php echo $_SESSION["user"]; ?>
			</li>
			<ul class="nav navbar-nav navbar-right">
				<li><p class="navbar-text"><?php echo date("d M Y")?></p></li>
				<li>...</li>
				<li><a href="logout.php" class="btn btn-danger navbar-btn" role="button">Log out</a></li>
			</ul>
		</div>
	</nav>
	<div class="container-fluid mb-3 w-25 float-end" id="upload">
		<label for="formFile" class="form-label">Upload Document</label>
		<input class="form-control" type="file" id="submit">
	</div>
	
	<div class="container w-50 p-3">
		<form action="submit.php" method="post">
			<div class="mb-3">
				<div class="drag-area">
					<div class="icon"></div>
					<header>Drag Document Here to Upload</header>
					<p>Accepted file extensions: .pdf, .docx, .doc</p>
					<script src="script.js"></script>
				</div>
				<br>
				<label for="dataList" class="form-label">Select unit</label>
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
						<a href="home.php" class="btn btn-danger" role="button">Cancel</a>
					</div>
				</div>
			</div>
		</form>
	</div>
	
</body>
</html>