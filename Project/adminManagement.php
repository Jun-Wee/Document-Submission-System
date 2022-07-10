<!-- Description: Admin Login Page in PHP -->
<!-- Author: Adrian Sim Huan Tze -->
<!-- Contributor: Jun Wee Tan -->
<!-- Date: 26th May 2022 -->
<!-- Validated: =-->

<?php
include "classes/user.php";
include "classes/submission.php";
include "classes/submissionTable.php";
include "classes/database.php";

session_start();
$admin = null;
$convenor = null;
$db = new Database();
$submissionTable = new SubmissionTable($db);

if (!isset($_SESSION['admin'])) {
	if (!isset($_SESSION['convenor'])) {
		header("Location: adminLogin.php");
	} else {
		$convenor = unserialize($_SESSION['convenor']);
		$convenor->fetchTeachingUnits($db);
		$submission_records = $submissionTable->GetAll($convenor->getTeachingUnits());
	}
} else {
	$admin = unserialize($_SESSION['admin']);
	$submission_records = $submissionTable->GetAll();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Administrator Home | Document Submission System</title>
	<meta name="language" content="english" />
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

	<link href="style/adminManagementStyle.css" rel="stylesheet">
	<script src="script/script.js"></script>

</head>

<body>
	<div class="jumbotron text-center text-light bg-dark">
		<h2 class="mb-0 py-2">Document Submission System (Admin)</h2>
	</div>

	<!--Content body-->
	<div class="container-fluid">
		<div class="row">
			<!--side bars-->
			<div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
				<div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
					<ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="sidebar">
						<li class="nav-item">
							<a href="adminManagement.php" class="nav-link align-middle px-0" id="active">
								<i class="fs-2 bi bi-file-earmark-pdf" id="navicon-active"></i>
								<span class="ms-1 d-none d-sm-inline" id="navtext-active">Submission</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link align-middle px-0">
								<i class="fs-2 bi bi-people-fill" id="navicon"></i>
								<span class="ms-1 d-none d-sm-inline" id="navtext">Student</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link align-middle px-0">
								<i class="fs-2 bi bi-clipboard-check" id="navicon"></i>
								<span class="ms-1 d-none d-sm-inline" id="navtext">Question</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link align-middle px-0">
								<i class="fs-2 bi bi-bar-chart-line" id="navicon"></i>
								<span class="ms-1 d-none d-sm-inline" id="navtext">Report Analysis</span>
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
							<span class="d-none d-sm-inline mx-2"><?php
																	if ($admin != null) {
																		echo $admin->getName();
																	} else {
																		echo $convenor->getName();
																	} ?></span>
						</a>
						<ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
							<li><a class="dropdown-item" href="#">Profile</a></li>
							<li>
								<hr class="dropdown-divider">
							</li>
							<li><a class="dropdown-item" href="adminLogout.php">Sign out</a></li>
						</ul>
					</div>
				</div>
			</div>

			<!--show student document-->
			<div class="col py-3">
				<!--search/ filter bar-->
				<div class="row">
					<div class="col">
						<h5>Total no of submission:</h5>
						<h2 class="text-left" name="#">0</h2>
					</div>
					<div class="col">
						<h5>Total no of student:</h5>
						<h2 class="text-left" name="#">0</h2>
					</div>
					<div class="col input-group mb-5 ">
						<div class="row">
							<!--Search Button date-->
							<div class="col-12 d-flex pb-2">
								<input type="date" class="form-control" placeholder="Search by Date (e.g. 01/09/22)" name="#">
							</div>
							<!--Search student Id-->
							<div class="col-12 d-flex">
								<input type="text" class="form-control" placeholder="Search by Student Id" name="#">
								<span class="input-group-append">
									<button class="btn btn-primary" type="button">Search</button>
								</span>
							</div>
						</div>
					</div>
				</div>

				<!--submision retrieve table-->
				<div class="row">
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>Id</th>
								<th>Student Id</th>
								<th>Submission Datetime</th>
								<th>MCQ Score</th>
								<th>Unit Code</th>
								<th>Document</th>
							<tr>
						</thead>
						<tbody>
							<?php
							for ($i = 0; $i < count($submission_records); $i++) {
								echo "<tr>";
								echo "<td> " . $submission_records[$i]->getId() . "</td>";
								echo "<td> " . $submission_records[$i]->getstuId() . "</td>";
								echo "<td> " . $submission_records[$i]->getdatetime() . "</td>";
								echo "<td> " . $submission_records[$i]->getMCQscore() . "</td>";
								echo "<td> " . $submission_records[$i]->getUnitCode() . "</td>";
								$filepath_array = explode("/", $submission_records[$i]->getfilepath());
								$filename = end($filepath_array);
								echo "<td> <a href='" . $submission_records[$i]->getfilepath() . "' target='_blank'>"
									. $filename .
									"</a> </td>";
								echo "</tr>";
							}
							?>
						</tbody>
					</table>
				</div>
			</div>

		</div>
	</div>
</body>

</html>