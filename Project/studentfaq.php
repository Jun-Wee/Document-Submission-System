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
                                <i class="fs-2 bi bi-file-earmark-pdf" id="navicon"></i>
                                <span class="ms-1 d-none d-sm-inline" id="navtext">Submission</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="studentfaq.php" class="nav-link align-middle px-0">
                                <i class="fs-2 bi bi-question-circle" id="navicon-active"></i>
                                <span class="ms-1 d-none d-sm-inline" id="navtext-active">FAQ</span>
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

            <!--multiple-choice question form-->
            <div class="col py-3">
                <div class="row">
                    <div class="col-10 mx-auto">
                        <div class="container">
                            <div class="p-5 mb-0 bg-light opacity-75 bg-gradient rounded text-dark">
                                <h1 class="navbar-brand"><small class="text-dark"><strong>Frequently-asked questions</strong></small></h1>
                                <form action="#" method="post">
                                    <ol>
                                        <li>
                                            <h6>I forgot my password, what do I do?</h6>
                                            <div class="form-check form-check-inline">
                                                <p> Contact the admin to reset your password.</p>
                                            </div>
                                        </li>
                                        <li>
                                            <h6>Is the Document Submission System another Turnitin?</h6>
                                            <div class="form-check form-check-inline">
                                                <p>No, the Document Submission System analyses submissions to validate the student's work.</p>
                                            </div>
                                        </li>
                                        <li>
                                            <h6>Do I have to use a PC device to use the Document Submission System?</h6>
                                            <div class="form-check form-check-inline">
                                                <p>Yes, the Document Submission System will require a PC device.</p>
                                            </div>
                                        </li>
                                        <li>
                                            <h6>I cannot see my Unit, what do I do?</h6>
                                            <div class="form-check form-check-inline">
                                                <p> Contact Admin as soon as possible and inform them.</p>
                                            </div>
                                        </li>
                                        <li>
                                            <h6>How do I contact admin?</h6>
                                            <div class="form-check form-check-inline">
                                                <p>Contact admin via Email: admin101@swin.edu.au.</p>
                                            </div>
                                        </li>
                                        <li>
                                            <h6>Do I need to put my personal information to use the Document Submission System?</h6>
                                            <div class="form-check form-check-inline">
                                                <p>The Document Submission System will only require students' emails and names.</p>
                                            </div>
                                        </li>
                                        <li>
                                            <h6>Can I use the Document Submission System for other purposes not related to university work?</h6>
                                            <div class="form-check form-check-inline">
                                                <p> No, the Document Submission System is strictly for university work only.</p>
                                            </div>
                                        </li>
                                        <li>
                                            <h6>What are the minimum requirements to run the Document Submission System?</h6>
                                            <div class="form-check form-check-inline">
                                                <p>Minimum Hardware Requirements</p>
                                                <p>Processor: Intel Core i3(6th Generation or Later) or equivalent</p>
                                                <p>Random Access Memory (RAM) 8GB</p>
                                                <p>Storage Capactiy: 512 GB Internal Solid-State Drive (SSD) or 1 TB Internal HDD</p>
                                                <p>Minimum Software Requirements</p>
                                                <p>Operating System: Windows 10</p>
                                                </p>
                                            </div>
                                        </li>
                                        <li>
                                            <h6>How do I use the Document Submission System?</h6>
                                            <div class="form-check form-check-inline">
                                                <p>Refer to the User Manual. The manual will provide a guide on the steps on how to use the Document Submission System.</p>
                                            </div>
                                        </li>
                                        <li>
                                            <h6>Do I require internet connectivity?</h6>
                                            <div class="form-check form-check-inline">
                                                <p>Yes, the Document Submission System will require internet connectivity since it performs web searches when generating a report.</p>
                                            </div>
                                        </li>
                                        <li>
                                            <h6>Do I have to use a PC device to use the Document Submission System?</h6>
                                            <div class="form-check form-check-inline">
                                                <p>Yes, the Document Submission System will require a PC device.</p>
                                            </div>
                                        </li>
                                    </ol>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

</body>

</html>