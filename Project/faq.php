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
        $submission_records = $submissionTable->GetAll($convenor->getId());
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
    <link rel="stylesheet" href="style/studentIndexStyle.css">
    <script src="script/script.js"></script>

</head>

<body onload="startTIME();">

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
                            <a href="submissionManagement.php" class="nav-link align-middle px-0" id="active">
                                <i class="fs-2 bi bi-file-earmark-pdf" id="navicon"></i>
                                <span class="ms-1 d-none d-sm-inline" id="navtext">Submission</span>
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
                                <i class="fs-2 bi bi-question-circle" id="navicon-active"></i>
                                <span class="ms-1 d-none d-sm-inline" id="navtext-active">FAQ</span>
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
                                            <h6>How do I examine student submissions? </h6>
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
                                        <li>
                                            <h6>Can I edit student submissions?</h6>
                                            <div class="form-check form-check-inline">
                                                <p>Yes, to edit or update student submissions, refer to User Manual.</p>
                                            </div>
                                        </li>
                                        <li>
                                            <h6>How do I see the student's analysis report</h6>
                                            <div class="form-check form-check-inline">
                                                <p>Yes, to edit or update student submissions, refer to User Manual.</p>
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
    </div>
    </div>
    </div>
    </div>
</body>

</html>