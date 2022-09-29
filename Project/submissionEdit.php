<!-- Description: Submission Edit Page in PHP -->
<!-- Author: Adrian Sim Huan Tze -->
<!-- Contributor: Adrian Sim Huan Tze -->
<!-- Date: 18th July 2022 -->
<!-- Validated: =-->

<?php
include "classes/user.php";
include "classes/studentTable.php";
include "classes/submission.php";
include "classes/submissionTable.php";
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
$fileUploadErrorMsg = "";

if (!isset($_SESSION['admin'])) {
    if (!isset($_SESSION['convenor'])) {
        header("Location: adminLogin.php");
    } else {
        $convenor = unserialize($_SESSION['convenor']);
        $convenor->fetchTeachingUnits($db);
        $submission_records = $submissionTable->GetAll($convenor->getTeachingUnits());
        $student_records = $studentTable->GetAll($convenor->getTeachingUnits());
    }
} else {
    $admin = unserialize($_SESSION['admin']);
    $submission_records = $submissionTable->GetAll();
    $student_records = $studentTable->GetAll();
    $allUnits = $admin->fetchAllUnits($db);
}

if (isset($_GET['subId'])) {
    if (!empty($_GET['subId'])) {
        $submissionId = $_GET['subId'];
        $existing_submission = $submissionTable->Get($submissionId);
    }
}
?>

<!-- Cancel Submission Edit -->
<?php
if (isset($_GET['cancel'])) {
    if (!empty($_GET['cancel'])) {
        header("Location: submissionManagement.php");
    }
}
?>

<!-- Edit Submission -->
<?php
if (isset($_POST['submit'])) {
    $submissionId = $_POST['subId'];
    $existing_submission = $submissionTable->Get($submissionId);
    $submission_unit = $_POST['unitOption'];
    $code = explode(" ", $submission_unit);
    // update the details of existing submission with new info
    $existing_submission->setUnitCode($code[0]);
    $existing_submission->setMCQscore($_POST['mcqScore']);
    $existing_submission->setdatetime($_POST['submissionDatetime']);

    // $file = $_FILES['newfile']; //gets all the info from the uploaded file
    // if (isset($file)) {
    //     if (!empty($file['name'])) {
    //         $filepath_arr = explode("/", $existing_submission->getfilepath());
    //         $filename = end($filepath_arr);
    //         $filename_arr = explode(".", $filename);
    //         $studentName = $filename_arr[0];
    //         echo $studentName;
    //         [$fileUploadErrorMsg, $path] = checkNewUploadedFile($file['name'], $file['tmp_name'], $file['error'], $file['size'], $studentName, $code[0]);
    //         if ($fileUploadErrorMsg == "") {
    //             $server_root_directory = "/var/www/html";
    //             // delete the existing file after successfully adding the new file as a replacement
    //             if (file_exists($server_root_directory . $existing_submission->getfilepath())) {
    //                 if (unlink($server_root_directory . $existing_submission->getfilepath())) {
    //                     $existing_submission->setfilepath($path);
    //                 }
    //             }
    //         }
    //     }
    // }
    // Delegate the edit task to SubmissionTable class
    if ($submissionTable->Edit($submissionId, $existing_submission) == 1) {
        header("Location: submissionManagement.php");
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

                <form action="submissionEdit.php" method="POST" enctype="multipart/form-data">
                    <legend class=" col-form-label-lg col-sm-2"><strong>Submission <?php echo $existing_submission->getId() ?></strong></legend>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="Id" class="col-sm-2 col-form-label col-form-label-md"><em>Id</em></label>
                            <input name="subId" readonly type="text" class="form-control form-control-md" id="Id" aria-describedby="IdHelp" value="<?php echo $existing_submission->getId() ?>">
                            <small id="IdHelp" class="form-text text-muted">Submission Id is unchangeable.</small>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="studentId" class="col-sm-4 col-form-label col-form-label-md"><em>Student Id</em></label>
                            <input readonly type="text" class="form-control form-control-md" id="studentId" aria-describedby="IdHelp" value="<?php echo $existing_submission->getstuId() ?>">
                            <small id="IdHelp" class="form-text text-muted">Student Id is unchangeable.</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="unitSubmission" class="col-sm-6 col-form-label col-form-label-md"><em>Unit Code</em></label>
                            <select name="unitOption" id="unitSubmission" class="col-sm-2 form-control form-control-md">
                                <?php
                                if ($admin == null) {
                                    foreach ($convenor->getTeachingUnits() as $unit) {
                                        if ($existing_submission->getUnitCode() == $unit['code']) {
                                            echo "<option selected>" . $unit['code'] . " " . $unit['description'] . "</option>";
                                        } else {
                                            echo "<option>" . $unit['code'] . " " . $unit['description'] . " " . "</option>";
                                        }
                                    }
                                } else {
                                    foreach ($allUnits as $unit) {
                                        if ($existing_submission->getUnitCode() == $unit['code']) {
                                            echo "<option selected>" . $unit['code'] . " " . $unit['description'] . "</option>";
                                        } else {
                                            echo "<option>" . $unit['code'] . " " . $unit['description'] . " " . "</option>";
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="mcqScore" class="col-sm-6 col-form-label col-form-label-md"><em>MCQ Score</em></label>
                            <input name="mcqScore" type="number" min="0" max="5" class="col-sm-2 form-control form-control-md" id="mcqScore" aria-describedby="IdHelp" value="<?php echo $existing_submission->getMCQscore() ?>">
                            <small id="IdHelp" class="form-text text-muted">For each submission, the maximum score is 5.</small>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group col-md-6">
                            <label for="subtime" class="col-sm-6 col-form-label col-form-label-md"><em>Submission (Date and Time)</em></label>
                            <input name="submissionDatetime" type="datetime-local" step="any" class="form-control form-control-md" id="subtime" name="subtime" value="<?php echo $existing_submission->getdatetime() ?>">
                        </div>

                        <!-- <div class="form-group col-md-10">
                            <label for="formFile" class="col-sm-2 col-form-label col-form-label-md"><em>Submit new Document</em></label>
                            <?php
                            // $filepath_array = explode("/", $existing_submission->getfilepath());
                            // $filename = end($filepath_array);
                            ?>
                            <a class='text-decoration-none col-form-label-md' href="<?php // echo $existing_submission->getfilepath() 
                                                                                    ?>" target='_blank'><?php // echo $filename 
                                                                                                        ?><span class='bi bi-file-pdf red-color'></span></a>
                        </div>
                        <div class="form-group col-md-8">
                            <input class="form-control form-control-md" type="file" name="newfile">
                        </div> -->
                        <br>

                        <?php
                        if ($fileUploadErrorMsg != "" && isset($_POST['submit'])) {
                            echo "<div><p>" . $fileUploadErrorMsg . "</p></div>";
                        }
                        ?>
                    </div>
                    <br>
                    <a class='btn btn-success me-3' href='submissionEdit.php?cancel=true'>Cancel</a>
                    <button type="submit" name="submit" class="btn btn-warning">Save Changes</button>
                </form>
            </div>

        </div>
    </div>
</body>

</html>