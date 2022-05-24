<?php
session_start();	//Starts the session
include_once 'dbconnect.php';

if(isset($_SESSION['user'])!="")
{
	header("Location: home.php");
}
	
	$email=$_POST['email'];
	$pwd=$_POST['password'];
	
	$res=mysqli_query($conn,"SELECT * FROM users WHERE Email='$email'");	//Sorting out the username from the staff database
	$row=mysqli_fetch_array($res);
	
	//For login
	if($row['Password']==$pwd)
	{
		if ($row['Role']=='Student') {
			$_SESSION['user']=$row['Name'];
			header("Location: home.php");
		}
		
		if ($row['Role']=='Admin') {
			$_SESSION['user']=$row['Name'];
			header("Location: adminModule.html");
		}
	}
	else
	{
	
	//echo wrong username or wrong password

	echo '
	<!DOCTYPE html>
	<html lang ="en">
	<head>
	<title>Student Login | Document Submission System</title>
	<meta name="language" content="english" />
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
	<style>
		.login-form {
			width: 385px;
			margin: 30px auto;
		}
		.login-form form {        
			margin-bottom: 15px;
			background: #f7f7f7;
			box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
			padding: 30px;
		}
		.login-form h2 {
			margin: 0 0 15px;
		}
		.form-control, .login-btn {
			min-height: 38px;
			border-radius: 2px;
		}
		
		body {
			background-image: url("swinburne-login.jpg");
			background-repeat: no-repeat;
			background-size: cover;	
		}

	</style>
</head>
<body>
	<div class="jumbotron text-center">
		<h1>Document Submission System</h1>
		<a href="adminLogin.html" class="btn btn-danger float-end col-sm-1" role="button">Administrator Sign in</a>
	</div>
	<div class="jumbotron text-center">
		<img src="swinburne.png" style="width: 300px; height: 150px; margin-left: 130px;">
	</div>
	<div class="login-form">
    <form action="login.php" method="post">
        <h2 class="text-center">Sign in</h2>   
        <div class="form-group">
        	<div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control" name="email" placeholder="StudentID@student.swin.edu.au" required="required">				
            </div>
        </div>
		<br>
		<div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password" class="form-control" name="password" placeholder="SIMS Password" required="required">				
            </div>
        </div>    
		<p class="text-danger">Error! Invalid email address or password</p>
        <div class="form-group">
            <button type="submit" class="btn btn-primary login-btn btn-block">Sign in</button>
        </div>
</body>
</html>';
		
	}
mysqli_close($conn);
?>