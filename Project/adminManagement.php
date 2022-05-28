<!-- Description: Admin Login Page in PHP -->
<!-- Author: Adrian Sim Huan Tze -->
<!-- Date: 26th May 2022 -->
<!-- Validated: =-->

<?php
include "classes/user.php";

session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: adminLogin.php");
} else {
    $admin = unserialize($_SESSION['admin']);
}
?>

<!DOCTYPE html>
<html lang ="en">
<head>
	<title>Administrator Home | Document Submission System</title>
	<meta name="language" content="english" />
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style/adminManagementStyle.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
	<div class="jumbotron text-center">
		<h1>Document Submission System (Admin)</h1>
	</div>
	<nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
        <div class="position-sticky">
			<div class="list-group list-group-flush mx-3 mt-4">
				<a href="#" class="list-group-item list-group-item-action py-2 ripple active" aria-current="true">
					<i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Submissions</span>
				</a>
				<a href="#" class="list-group-item list-group-item-action py-2 ripple">
					<i class="fas fa-chart-area fa-fw me-3"></i><span>Students</span>
				</a>
				<a href="#" class="list-group-item list-group-item-action py-2 ripple">
					<i class="fas fa-lock fa-fw me-3"></i><span>Questions</span></a>
				<a href="#" class="list-group-item list-group-item-action py-2 ripple">
					<i class="fas fa-chart-line fa-fw me-3"></i><span>Report Analysis</span></a>
				<a href="adminLogout.php" class="list-group-item list-group-item-action py-2 ripple">
					<i class="fas fa-chart-pie fa-fw me-3"></i><span>Log out</span>
				</a>
			</div>
		</div>
	</nav>
	<div class="row">
		<div class="col"></div>
		<div class="col"><h5>Total number of submissions: </h5><h2>0</h2></div>
		<div class="col"><h5>Total number of students: </h5><h2>0</h2></div>
		<div class="col">
			<input class="form-control" list="datalistOptions" id="date" placeholder="By dates" required="required">
			<input class="form-control" list="datalistOptions" id="name" placeholder="Search by name" required="required">
		</div>
	</div>
	<div class="container">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Assignment</th>
					<th>Written by</th>
					<th>Submission date</th>
					<th>MCQ Score</th>
				<tr>
			</thead>
		</table>
	</div>
</body>
</html>