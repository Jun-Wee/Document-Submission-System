<!-- Description: Question Page in PHP -->
<!-- Author: Adrian Sim Huan Tze and Yovinma Konara -->
<!-- Contributor: Adrian Sim Huan Tze -->
<!-- Date: 31st August 2022 -->
<!-- Validated: =-->

<?php
include "classes/database.php";
include "classes/questionTable.php";
include "classes/question.php";
include "classes/submissionTable.php";
include "classes/submission.php";
include "classes/user.php";

session_start();
$submissionId = $_SESSION["subId"];

session_start();
if (!isset($_SESSION['student'])) {
    header("Location: studentLogin.php");
} else {
    $student = unserialize($_SESSION['student']);
    $db = new Database();
    $questionTable = new QuestionTable($db, $submissionId);
    $submissionTable = new SubmissionTable($db);
    $submission = $submissionTable->Get($submissionId);
}
?>

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

<body onload="startTIME();" style="background-image: url('src/images/questionsval-image.jpg');">

    <!--Title-->
    <div class="jumbotron text-center" style="color:white;">
        <h1>Document Submission System</h1>
    </div>

    <!--nav bar-->
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark" id="navbar">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="mynavbar">
                <li class="navbar-brand" href="#"><span class="glyphicon glyphicon-user"></span>
                    Hello, <?php echo $student->getName();
                            ?>
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
                            <a href="studentfaq.php" class="nav-link align-middle px-0">
                                <i class="fs-2 bi bi-question-circle" id="navicon"></i>
                                <span class="ms-1 d-none d-sm-inline" id="navtext">FAQ</span>
                            </a>
                        </li>
                    </ul>

                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fs-2 bi bi-person"></i>
                            <span class="d-none d-sm-inline mx-2"><?php echo $student->getName()
                                                                    ?></span>
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

            <!-- question validation form-->
            <div class="col py-3">
                <div class="row">
                    <div class="col-10 mx-auto">
                        <div class="container">
                            <div class="p-5 mb-0 bg-light opacity-75 bg-gradient rounded text-dark">
                                <?php
                                #get the answers from mysql
                                #compare it with them
                                #tally score 
                                #validate everything
                                #confirm successful submission

                                //create connection
                                $db->createConnection();

                                // Check connection
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                } else if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                    //check if all the MCQs are submitted, prolly get a count of all number of questions based on the submission ID
                                    $row = $questionTable->GetTotalNumofQues();
                                    // echo ($row);
                                    // echo (count($_POST));
                                    // print_r($_POST);

                                    #check if all questions are answered 
                                    if ($row == (count($_POST) - 1)) {
                                        #allow processing of MCQ answers 
                                        // echo "All Questions answered";

                                        $questions = array();
                                        for ($i = 0; $i < $row; $i++) {
                                            array_push($questions, $questionTable->Get($i + 1));
                                        }

                                        if (count($questions) != 0) {
                                            $actualAnswers = array();
                                            $stuAnswers = array();

                                            // echo "All Questions retrieved from database";

                                            for ($i = 0; $i < count($questions); $i++) {
                                                array_push($actualAnswers, ucfirst($questions[$i]->getAnswer()));
                                            }

                                            // print_r($actualAnswers);

                                            #case-insensitive comparison of strings to check if the answers match 
                                            $quesNum = 1;
                                            foreach ($_POST as $question => $studAns) {
                                                if ($studAns != "Submit Answers") { # to ignore the comparison of the submit button value as it's not an answer
                                                    array_push($stuAnswers, $studAns);
                                                    #update student's answer in their repective record
                                                    $questions[$quesNum - 1]->setStuAnswer($studAns);
                                                    $questionTable->Edit($questions[$quesNum - 1]);
                                                    $quesNum++;
                                                }
                                            }

                                            // print_r($stuAnswers);

                                            $score = $questionTable->CalculateTotalScore($actualAnswers, $stuAnswers);

                                            // echo $score;

                                            #insert tally of the student's correct answers into the database
                                            $submission->setMCQscore($score);
                                            $submissionTable->Edit($submissionId, $submission);

                                            echo '<h3><img src="src/images/tick.png" width="150" height="150" title="correct submission"/> Your submission was successful!</h3>';
                                            echo '<p>Congratulations! Your submission is complete! Please click <a href="submission.php">here</a> to return to the homepage</p>';
                                        } else {
                                            die("Please check database and query for getting the predicted answers; no rows returned");
                                        }
                                    } else {

                                        echo '<h3><img src="src/images/cross.png" width="100" height="100" title="incorrect submission"/> Sorry your submission didnt go through!</h3>';
                                        echo "<h6>You have not answered all the MCQ questions! Please go back to the previous page to access your answers and resubmit your answers to finalize your submission. </h6>";
                                    }

                                    #close connection
                                    $db->closeConnection();
                                } else {
                                    echo "<h6>erroneous access</h6>";
                                }

                                ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


</body>

</html>