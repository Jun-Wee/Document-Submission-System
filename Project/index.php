<!-- Description: Student Login Page in PHP -->
<!-- Author: Xin Zhe Chong -->
<!-- Date: 25th May 2022 -->
<!-- Validated: =-->

<?php
    include "system_functions.php";
	include "classes/database.php";
	include "classes/user.php";

    $btnclicked = false;
	$db = new Database();
    if (!empty($_POST["login"])) {
        $btnclicked = true;
        [$login_msg, $loginOk, $email_previous, $errorfield, $profile] =
            ChkEmailPasswordForLogin($_POST["email"], $_POST["password"], $db);

        if ($loginOk) {
            session_start();
            // Set session variables
			$student = new Student($profile[0], $profile[1], $profile[2], $profile[3], $profile[4]);
            $_SESSION['student'] = serialize($student);
            header('Location: submission.php');
        }
    } else {
        $btnclicked = false;
    }
?>

<!DOCTYPE html>

<html lang="en">
<head>
	<title>Student Login</title>
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
		<form action="studentLogin.php" method="post">

			<h2 class="text-center">Sign in</h2>

			<div class="form-group">
				<div class="input-group">
					<span style="padding-top: 6px" class="input-group-addon"><i class="fa fa-user"></i></span>
					<input type="text" style="margin-left: 10px;" class="form-control" name="email" placeholder="StudentID@student.swin.edu.au"
						required="required" 
						<?php
						if ($btnclicked) {
							if (!$loginOk) {
								echo "value = '" . $email_previous . "'";
							}
						}
						?>/>
				</div>
			</div>

			<br>

			<div class="form-group">
				<div class="input-group">
					<span style="padding-top: 6px" class="input-group-addon"><i class="fa fa-lock"></i></span>
					<input type="password" style="margin-left: 10px;" class="form-control" name="password" placeholder="SIMS Password"
						required="required"/>
				</div>
			</div>

			<?php
            if ($btnclicked) {
                if ($errorfield == "email") {
                    echo "<div><p>" . $login_msg . "</p></div>";
                }
            }
            ?>

			<!--button-->
			<br>
			<div class="form-group">
				<input type="submit" name="login" class="btn btn-primary login-btn btn-block" value="Sign In"/>
				<input type="reset" name="resetall" class="btn btn-danger" value="Reset">
			</div>
</body>

</html>