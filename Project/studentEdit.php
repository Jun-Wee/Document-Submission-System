<!-- Description: Submission Edit Page in PHP -->
<!-- Author: Adrian Sim Huan Tze -->
<!-- Contributor: Adrian Sim Huan Tze -->
<!-- Date: 18th July 2022 -->
<!-- Validated: =-->

<?php
include "classes/user.php";
include "classes/submission.php";
include "classes/studentTable.php";
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

if (isset($_GET['stuId'])) {
    if (!empty($_GET['stuId'])) {
        $studentId = $_GET['stuId'];
        $existing_student = $studentTable->Get($studentId);
    }
}
?>

<!-- Cancel Student Edit -->
<?php
if (isset($_GET['cancel'])) {
    if (!empty($_GET['cancel'])) {
        header("Location: studentManagement.php");
    }
}
?>

<!-- Edit Student -->
<?php
// if (isset($_POST['submit'])) {
//     $submissionId = $_POST['subId'];
//     $existing_student = $submissionTable->Get($submissionId);
//     $submission_unit = $_POST['unitOption'];
//     $code = explode(" ", $submission_unit);
//     // update the details of existing submission with new info
//     $existing_student->setUnitCode($code[0]);
//     $existing_student->setMCQscore($_POST['mcqScore']);
//     $existing_student->setdatetime($_POST['submissionDatetime']);

//     $file = $_FILES['newfile']; //gets all the info from the uploaded file
//     if (isset($file)) {
//         if (!empty($file['name'])) {
//             $filepath_arr = explode("/", $existing_student->getfilepath());
//             $filename = end($filepath_arr);
//             $filename_arr = explode(".", $filename);
//             $studentName = $filename_arr[0];
//             echo $studentName;
//             [$fileUploadErrorMsg, $path] = checkNewUploadedFile($file['name'], $file['tmp_name'], $file['error'], $file['size'], $studentName, $code[0]);
//             if ($fileUploadErrorMsg == "") {
//                 // delete the existing file after successfully adding the new file as a replacement
//                 if (file_exists($existing_student->getfilepath())) {
//                     if (unlink($existing_student->getfilepath())) {
//                         $existing_student->setfilepath($path);
//                     }
//                 }
//             }
//         }
//     }
//     // Delegate the edit task to SubmissionTable class
//     if ($submissionTable->Edit($submissionId, $existing_student) == 1) {
//         header("Location: submissionManagement.php");
//     }
// }
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
                                <i class="fs-2 bi bi-file-earmark-pdf" id="navicon"></i>
                                <span class="ms-1 d-none d-sm-inline" id="navtext">Submission</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="studentManagement.php" class="nav-link align-middle px-0">
                                <i class="fs-2 bi bi-people-fill" id="navicon-active"></i>
                                <span class="ms-1 d-none d-sm-inline" id="navtext-active">Student</span>
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

                <form action="studentEdit.php" method="POST" enctype="multipart/form-data">
                    <legend class=" col-form-label-lg col-sm-2"><strong>Student <?php echo $existing_student->getId() ?></strong></legend>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="Id" class="col-sm-2 col-form-label col-form-label-md"><em>Id</em></label>
                            <input name="stuId" readonly type="text" class="form-control form-control-md" id="Id" aria-describedby="IdHelp" value="<?php echo $existing_student->getId() ?>">
                            <small id="IdHelp" class="form-text text-muted">Student Id is unchangeable.</small>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="Name" class="col-sm-2 col-form-label col-form-label-md"><em>Name</em></label>
                            <input name="stuName" type="text" class="form-control form-control-md" id="Name" value="<?php echo $existing_student->getName() ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="gender" class="col-sm-6 col-form-label col-form-label-md"><em>Gender</em></label>
                            <select name="gender" id="gender" class="col-sm-2 form-control form-control-md">
                                <?php
                                if ($existing_student->getGender() == "Male") {
                                    echo "<option selected>Male</option>";
                                    echo "<option>Female</option>";
                                } else {
                                    echo "<option>Male</option>";
                                    echo "<option selected>Female</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="unitSubmission" class="col-sm-6 col-form-label col-form-label-md"><em>Enrolled Units</em></label>
                            <select name="unitOption" id="unitSubmission" class="col-sm-2 form-control form-control-md">

                                ?>
                            </select>
                        </div>
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