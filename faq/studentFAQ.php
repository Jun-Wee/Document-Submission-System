<?php
include "classes/user.php";
include "classes/database.php";
include "system_functions.php";
include "src/library/PDFParser/vendor2/autoload.php";

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
	$titleEntered = false;
	$fileUploadErrorMsg = "";
	if (isset($_POST['submit'])) {
		if (isset($_POST['unitOptions'])) {
			if (isset($_POST['title'])) {
				if (validateAlphaCharacter($_POST['title'])) {
					if (checkNotEmpty($_POST['unitOptions'])) {
						$unitSelected = true;
						$titleEntered = true;
						$submission_unit = $_POST['unitOptions'];
						$code = explode(" ", $submission_unit);
						//gets all the info from the uploaded file
						//print_r($file); //testing for file superglobal
						[$fileUploadErrorMsg, $path] = checkUploadedFile($_FILES['file'], $_FILES['file']['name'], $_FILES['file']['tmp_name'], $_FILES['file']['error'], $_FILES['file']['size'], $student, $code[0]);
						if ($fileUploadErrorMsg == "") {
							[$status, $subId] = $student->submitDocument($db, $code[0], $path);

							$config = new \Smalot\PdfParser\Config();
							$config->setHorizontalOffset('');

							$parser = new \Smalot\PdfParser\Parser([], $config);
							$file = "/var/www/html" . $path;
							$pdf = $parser->parseFile($file);
							$text = $pdf->getText();
							$pdfText = nl2br($text);

							//Save and send the text and subject ID to analysis.php
							$_SESSION['student'] = serialize($student);
							$_SESSION['pdfText'] = $pdfText;
							$_SESSION['subId'] = $subId;
							$_SESSION['title'] = $_POST['title'];

							header('Location: analysis.php');						//Redirect to analysis page				
						}
					} else {
						$unitSelected = false;
					}
				} else {
					$titleEntered = false;
					$unitSelected = true;
				}
			} else {
				$titleEntered = false;
				$unitSelected = true;
			}
		} else {
			$unitSelected = false;
			$titleEntered = false;
		}
	} else {
		$fileUploadErrorMsg = "";
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Frequency Ask Questions| Document Submission System</title>
	<meta name="language" content="english" />
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<link href="style/submissionManagementStyle.css" rel="stylesheet">
	<link href="style/faq.css" rel="stylesheet">
	<link rel="stylesheet" href="style/studentIndexStyle.css">
	<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
	<script src="script/script.js"></script>
</head>

<body onload="startTIME();">

	<!--Title-->
	<div class="jumbotron text-center" style="color:white;">
		<h1>Document Submission System</h1>
	</div>
	
		<!--nav bar-->
		<nav class="navbar navbar-expand-sm navbar-dark bg-dark" id="navbar">
			<div class="container-fluid">
				<div class="collapse navbar-collapse" id="mynavbar">
					<li class="navbar-brand" href="#"><span class="glyphicon glyphicon-user"></span>
						Hello, <?php echo $student->getName(); ?>
					</li>
				</div>
				<span class="navbar-text">
					<h5 style="color: white;" id="time">
						</h6>
			</div>
		</nav>
		
	<!--content body-->
	<div class="container-fluid">
		<div class="row">
			<!--side bars-->
			<div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
				<div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
					<ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="sidebar">
						<li class="nav-item">
							<a href="submission.php" class="nav-link align-middle px-0" id="active">
								<i class="fs-2 bi bi-file-earmark-pdf" id="navicon-active"></i>
								<span class="ms-1 d-none d-sm-inline" id="navtext-active">Submission</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="studentFAQ.php" class="nav-link align-middle px-0">
								<i class="fs-2 bi bi-question-circle" id="navicon"></i>
								<span class="ms-1 d-none d-sm-inline" id="navtext">FAQ</span>
							</a>
						</li>
					</ul>

					<div class="dropdown">
						<a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="fs-2 bi bi-person"></i>
							<span class="d-none d-sm-inline mx-2"><?php echo $student->getName() ?></span>
						</a>
						<ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
							<li><a class="dropdown-item" href="#">Profile</a></li>
							<li>
								<hr class="dropdown-divider">
							</li>
							<li><a class="dropdown-item" href="studentLogout.php">Sign out</a></li>
						</ul>
					</div>
				</div>
			</div>
			
				<div class="col py-3">
						<div class="header">
							<h2>FAQ</h2>
							</div>
						<div class="faq-item" id="question1">
							<b>1.	I forgot my password, what do I do?</b>
						<div class="answer">
                        Contact the admin to reset your password.
						</div>
				</div>		
			
						<div class="faq-item" id="question2">
                       <b>2.	Is the Document Submission System another Turnitin?</b> 
						<div class="answer">
                        No, the Document Submission System analyses submissions to validate the student's work.
						</div>
				</div>

						<div class="faq-item" id="question3">
                        <b>3.	I submitted a document, but why is it not working?</b>
						<div class="answer">
							Yes, the Document Submission System will require a PC device.
						</div>
				</div>	

						<div class="faq-item" id="question4">
                        <b>4.	I cannot see my Unit, what do I do?</b>
						<div class="answer">
                        Contact Admin ASAP and inform them.
						</div>
				</div>

						<div class="faq-item" id="question5">
						<b>5.	How do I see the student’s analysis report?</b>
						<div class="answer">
                        Contact Admin ASAP and inform them.
						</div>
				</div>

                        <div class="faq-item" id="question6">
                        <b>6.	How do I contact admin?</b>							
						<div class="answer">
                        Contact admin via Email.
						</div>
				</div>

                        <div class="faq-item" id="question7">
                        <b>7.	Do I require internet connectivity?</b>


						<div class="answer">
                        Yes, the Document Submission System will require internet connectivity.
						</div>
				</div>

                        <div class="faq-item" id="question8">
                        <b>8.	Do I have to use a PC device to use the Document Submission System?</b>


						<div class="answer">
                        Yes, the Document Submission System will require a PC device.
						</div>
				</div>

				<div class="faq-item" id="question10">
                        <b>9.	How do I use the Document Submission System?</b>
						<div class="answer">
                        Refer to the User Manual. The manual will provide a guide on the steps on how to use the Document Submission System.
						</div>
					</div>
                        <div class="faq-item" id="question11">
                        <b>10.	Do I need to put my personal information to use the Document Submission System?</b>


						<div class="answer">
						The Document Submission System will only require the students’ email and name.
						</div>
					</div>

                        <div class="faq-item" id="question12">
                        <b>11.	Can I use the Document Submission System for other purposes not related to university work?</b>

						<div class="answer">
                        No, the Document Submission System is strictly for university work only.
						</div>
					</div>
                        
                        <div class="faq-item" id="question9">
                        <b>12.	What are the minimum requirements to run the Document Submission System?</b>
						<div class="answer">
                        <b>Minimum Hardware Requirements</b>
                            <br>Processor: Intel Core i3(6th Generation or Later) or equivalent
							<br>Random Access Memory (RAM) 8GB
							<br>Storage Capactiy: 512 GB Internal Solid-State Drive (SSD) or 1 TB Internal HDD<br>
                        <br><b>Minimum Software Requirements</b>
						<br>Operating System: Windows 10
					</div>


				</div>
			</div>
		</div>
	</div>
</div>
		
</body>
</html>