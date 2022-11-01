<!-- Description: Submission Management Page in PHP -->
<!-- Author: Adrian Sim Huan Tze -->
<!-- Contributor: Adrian Sim Huan Tze -->
<!-- Date: 17th July 2022 -->
<!-- Validated: =-->

<?php
include "classes/user.php";
include "classes/submission.php";
include "classes/submissionTable.php";
include "classes/studentTable.php";
include "classes/analysisTable.php";
include "classes/entityTable.php";
include "classes/questionTable.php";
include "classes/webSearchTable.php";
include "classes/referenceTable.php";
include "classes/database.php";
include "system_functions.php";

// start the session
session_start();

// declare all the variables to be used in this
$admin = null;
$convenor = null;
$db = new Database();
$studentTable = new StudentTable($db);
$submissionTable = new SubmissionTable($db);

if (!isset($_SESSION['admin'])) {
	if (!isset($_SESSION['convenor'])) {
		header("Location: adminLogin.php");
	} else {
		$convenor = unserialize($_SESSION['convenor']);
		$convenor->fetchTeachingUnits($db);
		$student_records = $studentTable->GetAll($convenor->getTeachingUnits());
		$submission_records = $submissionTable->GetAll($convenor->getTeachingUnits());
	}
} else {
	$admin = unserialize($_SESSION['admin']);
	$student_records = $studentTable->GetAll();
	$submission_records = $submissionTable->GetAll();
}
?>

<!-- create a pagination for submission records -------------------------------------->
<?php
// define how many results you want per page
$results_per_page = 8;

// find out the number of results stored in database
$number_of_results = count($submission_records);

// determine number of total pages available
$number_of_pages = ceil($number_of_results / $results_per_page);

// determine which page number visitor is currently on
if (!isset($_GET['page'])) {
	$current_page = 1;
} else {
	$current_page = $_GET['page'];
}

// determine the starting number for the results on the displaying page
$this_page_first_result = ($current_page - 1) * $results_per_page;

// slice the selected results from database
$submission_records_subset = array_slice($submission_records, $this_page_first_result, $results_per_page);
?>

<!----------------------------------------------------------------------------------------->

<!-- delete a submission record -->
<?php
if (isset($_GET['id']) && isset($_GET['delete']) && isset($_GET['filepath'])) {
	// If the user file in existing directory already exist, delete it
	$server_root_directory = "/var/www/html";
	if (file_exists($server_root_directory . $_GET['filepath'])) {
		if (unlink($server_root_directory . $_GET['filepath'])) {
			$analysisTable = new AnalysisTable($db);
			$entityTable = new EntityTable($db);
			$questionTable = new QuestionTable($db, $_GET['id']);
			$webSearchTable = new WebSearchTable($db);
			$referenceTable = new ReferenceTable($db);

			if ($analysisTable->delete($_GET['id']) && $entityTable->delete($_GET['id']) && $webSearchTable->delete($_GET['id']) && $questionTable->delete($_GET['id']) && $referenceTable->delete($_GET['id'])) {
				if ($submissionTable->Delete($_GET['id']) == 1) {
					header("Location: submissionManagement.php");
				}
			}
		}
	}
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
	<link href="style/submissionManagementStyle.css" rel="stylesheet">
	<script src="script/script.js"></script>
	<link rel="icon" href="src/images/logo.png">
</head>

<body>
	<div class="jumbotron text-center text-light bg-dark">
		<h2 class="mb-0 py-2">Document Submission System</h2>
	</div>

	<!--Content body-->
	<div class="container-fluid">
		<div class="row">
			<!--side bars-->
			<div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
				<div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
					<ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="sidebar">
						<li class="nav-item">
							<a href="submissionManagement.php" class="nav-link align-middle px-0" id="active">
								<i class="fs-2 bi bi-file-earmark-pdf" id="navicon-active"></i>
								<span class="ms-1 d-none d-sm-inline" id="navtext-active">Submission</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="studentManagement.php" class="nav-link align-middle px-0">
								<i class="fs-2 bi bi-people-fill" id="navicon"></i>
								<span class="ms-1 d-none d-sm-inline" id="navtext">Student</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="questionManagement.php" class="nav-link align-middle px-0">
								<i class="fs-2 bi bi-clipboard-check" id="navicon"></i>
								<span class="ms-1 d-none d-sm-inline" id="navtext">Question</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="analysisManagement.php" class="nav-link align-middle px-0">
								<i class="fs-2 bi bi-bar-chart-line" id="navicon"></i>
								<span class="ms-1 d-none d-sm-inline" id="navtext">Report Analysis</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="faq.php" class="nav-link align-middle px-0">
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
						<h5>Total no of submissions:</h5>
						<h2 class="text-left" name="#"><?php echo count($submission_records) ?></h2>
					</div>
					<div class="col">
						<h5>Total no of students:</h5>
						<h2 class="text-left" name="#"><?php echo count($student_records) ?></h2>
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
								<th>Date and Time</th>
								<th>MCQ Score</th>
								<th>Unit Code</th>
								<th>Document</th>
							<tr>
						</thead>
						<tbody>
							<?php
							for ($i = 0; $i < count($submission_records_subset); $i++) {
								echo "<tr>";
								echo "<td> " . $submission_records_subset[$i]->getId() . "</td>";
								echo "<td> " . $submission_records_subset[$i]->getstuId() . "</td>";
								echo "<td> " . $submission_records_subset[$i]->getdatetime() . "</td>";
								echo "<td> " . $submission_records_subset[$i]->getMCQscore() . "</td>";
								echo "<td> " . $submission_records_subset[$i]->getUnitCode() . "</td>";
								$filepath_array = explode("/", $submission_records_subset[$i]->getfilepath());
								$filename = end($filepath_array);
								echo "<td> <a class='text-decoration-none' href='" . $submission_records_subset[$i]->getfilepath() . "' target='_blank'>"
									. substr($filename, 0, -4) .
									" <span class='bi bi-file-pdf red-color'></span></a> </td>";
								echo "<td><a class='btn btn-secondary me-3' href='./submissionEdit.php?subId=" . $submission_records_subset[$i]->getId() . "'>Edit</button></td>
									<td><a class='btn btn-danger' href='./submissionManagement.php?delete=true&id=" . $submission_records_subset[$i]->getId() . "&filepath=" . $submission_records_subset[$i]->getfilepath() . "'>Delete</button></td>";
								echo "</tr>";
							}
							?>
						</tbody>
					</table>
				</div>
				<?php
				// pagination page links --------------------------------------------------------------------------------------------------------------------
				// display the links to the pages
				for ($page = 1; $page <= $number_of_pages; $page++) {
					if ($current_page == $page) {
						echo "<a class='btn btn-dark' id='navtext-active' href='submissionManagement.php?page=" . $page . "'>" . $page . "</a> ";
					} else {
						echo "<a class='btn btn-dark' href='submissionManagement.php?page=" . $page . "'>" . $page . "</a> ";
					}
				}
				// pagination page links --------------------------------------------------------------------------------------------------------------------
				?>
			</div>

		</div>
	</div>
</body>

</html>