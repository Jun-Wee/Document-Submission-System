<!-- Description: Question Page in PHP -->
<!-- Author: Adrian Sim Huan Tze -->
<!-- Contributor: Adrian Sim Huan Tze -->
<!-- Date: 22nd August 2022 -->
<!-- Validated: =-->

<?php

include "classes/user.php";

session_start();
if (!isset($_SESSION['student'])) {
    header("Location: studentLogin.php");
} else {
    $student = unserialize($_SESSION['student']);
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Question</title>
    <meta name="language" content="english" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link rel="icon" href="src/images/logo.png">
    <link rel="stylesheet" href="style/studentIndexStyle.css">
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
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark d-flex flex-column justify-content-between">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white">
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="sidebar">
                        <li class="nav-item">
                            <a href="submission.php" class="nav-link align-middle px-0" id="active">
                                <i class="fs-2 bi bi-file-earmark-pdf" id="navicon-active"></i>
                                <span class="ms-1 d-none d-sm-inline" id="navtext-active">Submission</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link align-middle px-0">
                                <i class="fs-2 bi bi-question-circle" id="navicon"></i>
                                <span class="ms-1 d-none d-sm-inline" id="navtext">FAQ</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white">
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
                                <h1 class="navbar-brand"><small class="text-dark"><strong>Multiple-choice questions</strong></small></h1>
                                <p>Please fill the details and answers the all questions-</p>
                                <form action="#" method="post">
                                    <ol>
                                        <li>
                                            <h6>Who is the father of PHP? </h6>
                                            <div class="form-group">
                                                <ul>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="q1" id="inlineRadio1" value="Rasmus Lerdorf">
                                                        <label class="form-check-label" for="inlineRadio1">Rasmus Lerdorf</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="q1" id="inlineRadio2" value="Larry Wall">
                                                        <label class="form-check-label" for="inlineRadio2">Larry Wall</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="q1" id="inlineRadio3" value="Zeev Suraski">
                                                        <label class="form-check-label" for="inlineRadio3">Zeev Suraski</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="q1" id="inlineRadio3" value="Zeev Suraski">
                                                        <label class="form-check-label" for="inlineRadio3">Zeev Suraski</label>
                                                    </div>
                                                </ul>
                                            </div>
                                        </li>
                                        <br />
                                        <br />
                                        <li>
                                            <h6>Which of the functions is used to sort an array in descending order?</h6>
                                            <div class="form-group">
                                                <ul>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="q2" id="inlineRadio1" value="sort()">
                                                        <label class="form-check-label" for="inlineRadio1">sort()</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="q2" id="inlineRadio2" value="asort()">
                                                        <label class="form-check-label" for="inlineRadio2">asort()</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="q2" id="inlineRadio3" value="rsort()">
                                                        <label class="form-check-label" for="inlineRadio3">rsort()</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="q2" id="inlineRadio3" value="rsort()">
                                                        <label class="form-check-label" for="inlineRadio3">rsort()</label>
                                                    </div>
                                                </ul>
                                            </div>
                                        </li>
                                        <br />
                                        <br />
                                        <li>
                                            <h6>Which version of PHP introduced the instanceof keyword?</h6>
                                            <div class="form-group">
                                                <ul>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="q3" id="inlineRadio1" value="PHP 4">
                                                        <label class="form-check-label" for="inlineRadio1">PHP 4</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="q3" id="inlineRadio2" value="PHP 5">
                                                        <label class="form-check-label" for="inlineRadio2">PHP 5</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="q3" id="inlineRadio3" value="PHP 6">
                                                        <label class="form-check-label" for="inlineRadio3">PHP 6</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="q3" id="inlineRadio3" value="PHP 6">
                                                        <label class="form-check-label" for="inlineRadio3">PHP 6</label>
                                                    </div>
                                                </ul>
                                            </div>
                                        </li>
                                        <br />
                                        <br />
                                        <li>
                                            <h6>Which version of PHP introduced the instanceof keyword?</h6>
                                            <div class="form-group">
                                                <ul>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="q4" id="inlineRadio1" value="PHP 4">
                                                        <label class="form-check-label" for="inlineRadio1">PHP 4</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="q4" id="inlineRadio2" value="PHP 5">
                                                        <label class="form-check-label" for="inlineRadio2">PHP 5</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="q4" id="inlineRadio3" value="PHP 6">
                                                        <label class="form-check-label" for="inlineRadio3">PHP 6</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="q4" id="inlineRadio3" value="PHP 6">
                                                        <label class="form-check-label" for="inlineRadio3">PHP 6</label>
                                                    </div>
                                                </ul>
                                            </div>
                                        </li>
                                        <br />
                                        <br />
                                        <li>
                                            <h6>Which version of PHP introduced the instanceof keyword?</h6>
                                            <div class="form-group">
                                                <ul>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="q5" id="inlineRadio1" value="PHP 4">
                                                        <label class="form-check-label" for="inlineRadio1">PHP 4</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="q5" id="inlineRadio2" value="PHP 5">
                                                        <label class="form-check-label" for="inlineRadio2">PHP 5</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="q5" id="inlineRadio3" value="PHP 6">
                                                        <label class="form-check-label" for="inlineRadio3">PHP 6</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="q5" id="inlineRadio3" value="PHP 6">
                                                        <label class="form-check-label" for="inlineRadio3">PHP 6</label>
                                                    </div>
                                                </ul>
                                            </div>
                                        </li>
                                        <br />
                                        <br />
                                        <li>
                                            <h6>Which version of PHP introduced the instanceof keyword?</h6>
                                            <div class="form-group">
                                                <ul>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="q5" id="inlineRadio1" value="PHP 4">
                                                        <label class="form-check-label" for="inlineRadio1">PHP 4</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="q5" id="inlineRadio2" value="PHP 5">
                                                        <label class="form-check-label" for="inlineRadio2">PHP 5</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="q5" id="inlineRadio3" value="PHP 6">
                                                        <label class="form-check-label" for="inlineRadio3">PHP 6</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="q5" id="inlineRadio3" value="PHP 6">
                                                        <label class="form-check-label" for="inlineRadio3">PHP 6</label>
                                                    </div>
                                                </ul>
                                            </div>
                                        </li>
                                        <br />
                                        <br />
                                        <li>
                                            <h6>Which version of PHP introduced the instanceof keyword?</h6>
                                            <div class="form-group">
                                                <ul>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="q5" id="inlineRadio1" value="PHP 4">
                                                        <label class="form-check-label" for="inlineRadio1">PHP 4</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="q5" id="inlineRadio2" value="PHP 5">
                                                        <label class="form-check-label" for="inlineRadio2">PHP 5</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="q5" id="inlineRadio3" value="PHP 6">
                                                        <label class="form-check-label" for="inlineRadio3">PHP 6</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="q5" id="inlineRadio3" value="PHP 6">
                                                        <label class="form-check-label" for="inlineRadio3">PHP 6</label>
                                                    </div>
                                                </ul>
                                            </div>
                                        </li>
                                        <br />
                                        <br />
                                    </ol>
                                    <div class="form-group justify-content-end">
                                        <input type="submit" value="Submit Answers" name="submit" class="btn btn-primary float-right" />
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


</body>

</html>