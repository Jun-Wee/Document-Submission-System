<!DOCTYPE html>

<html lang="en">
<!-- Description: Student Login Page in PHP -->
<!-- Author: Xin Zhe Chong -->
<!-- Date: 25th May 2022 -->
<!-- Validated: =-->

<head>
	<title>Student Login | Document Submission System</title>
	<meta name="language" content="english" />
	<meta charset="utf-8">
	<meta name="author" content="Xin Zhe Chong">
	<meta name="description" content="Document Submission System">
	<meta name="keywords" content="assignment, submission, document">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" href="src/images/logo.png">

	
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
	<link href="style/studentLoginStyle.css" rel="stylesheet">
</head>

<body>
	<div class="jumbotron text-center">
		<a href="adminLogin.php" class="btn btn-danger float-end col-sm-1" role="button">Administrator</a>
	</div>
	<div class="jumbotron text-center">
		<img src="src/images/logo.png" style="width: 200px; height: 150px; margin-left: 130px;">
	</div>
	<div class="login-form">
		<form action="login.php" method="post">
			<h2 class="text-center">Sign in</h2>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-user"></i></span>
					<input type="text" class="form-control" name="email" placeholder="StudentID@student.swin.edu.au"
						required="required">
				</div>
			</div>
			<br>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-lock"></i></span>
					<input type="password" class="form-control" name="password" placeholder="SIMS Password"
						required="required">
				</div>
			</div>
			<br>
			<div class="form-group">
				<button type="submit" class="btn btn-primary login-btn btn-block">Sign in</button>
			</div>
</body>

</html>