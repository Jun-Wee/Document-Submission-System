<!-- Description: Question Page in PHP -->
<!-- Author: Adrian Sim Huan Tze and Yovinma Konara -->
<!-- Contributor: Adrian Sim Huan Tze -->
<!-- Date: 31st August 2022 -->
<!-- Validated: =-->

<?php
session_start();
/*include "classes/user.php";

session_start();
if (!isset($_SESSION['student'])) {
    header("Location: studentLogin.php");
} else {
    $student = unserialize($_SESSION['student']);
}*/
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
                    Hello, <?php //echo $student->getName(); ?>
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
                            <a href="#" class="nav-link align-middle px-0">
                                <i class="fs-2 bi bi-question-circle" id="navicon"></i>
                                <span class="ms-1 d-none d-sm-inline" id="navtext">FAQ</span>
                            </a>
                        </li>
                    </ul>

                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fs-2 bi bi-person"></i>
                            <span class="d-none d-sm-inline mx-2"><?//php echo $student->getName() ?></span>
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

                                
                                $_SESSION["submissionid"] = "100072";

                                #get the answers from mysql
                                #compare it with them
                                #tally score 
                                #validate everything
                                #confirm successful submission

                                $serverName = "127.0.0.1";
                                $username = "root";
                                $password = "root";
                                $dbName = "documentsubmissionsystem";

                                /*$serverName="documentsubmissionsystem.c2tnrfke8bpv.us-east-1.rds.amazonaws.com",
                                $username="admin",
                                $password="documentsubmissionsystem",
                                $dbName="documentsubmissionsystem"
                                */

                                //create connection
                                $conn = new mysqli($serverName, $username, $password, $dbName);

                                // Check connection
                                if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                                }
                                else if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                //check if all the MCQs are submitted, prolly get a count of all number of questions
                                $getNumOfQuestions = "SELECT COUNT(questionNum) FROM question WHERE submissionId =".$_SESSION["submissionid"].";";
                                $result = $conn -> query($getNumOfQuestions) or die("Something has gone wrong! ".$conn->errorno);
                                $row = $result -> fetch_row();

                                #check if all questions are answered 
                                if($row[0]== (count($_POST)-1)){
                                    #allow processing of MCQ answers 

                                    //get the set of answers stored in the database that belong to the questions generated for the respective submission ID 
                                $getAnswersQuery = "SELECT answer FROM `question` WHERE submissionId = ".$_SESSION["submissionid"].";";
                                $result = $conn -> query($getAnswersQuery) or die("Something has gone wrong! ".$conn->errorno);

                                #fetch matching records 
                                $predictedAnswers = mysqli_fetch_all ($result, MYSQLI_ASSOC);
                                
                                if($predictedAnswers!= NULL){
                                    $actualAnswers = [];
                                    foreach ($predictedAnswers as $p){
                                    $answers= array_push($actualAnswers, ucfirst($p["answer"]));
                                    
                                
                                    }
                                
                                
                                    #tally for keeping track of score 
                                    $tally =0;
                                
                                    #case-insensitive comparison of strings to check if the answers match 
                                    $quesNum = 1;
                                    foreach ($_POST as $question => $studAns) {
                          
                                    
                                    if($studAns!= "Submit Answers"){ # to ignore the comparison of the submit button value as it's not an answer
                                        if(in_array($studAns,$actualAnswers)){
                                    
                                        $tally++;
                                        }
                                        
                                        #update student's answer in their repective record
                                        $setAnswersQuery = 'UPDATE question SET stuAnswer =" '.$studAns.'" WHERE submissionId='.$_SESSION["submissionid"].' AND questionNum='.$quesNum.';';
                                        $result = $conn -> query($setAnswersQuery) or die("Something has gone wrong! ".$conn->errorno) ;
                                        $quesNum++;
                                    }
                                    
                                    }
                                
                                    #insert tally of the student's correct answers into the database
                                    $setTallyQuery = 'UPDATE submission SET score = '.$tally.' WHERE Id='.$_SESSION["submissionid"].';';
                                    $result = $conn -> query($setTallyQuery)or die("Something has gone wrong! ".$conn->errorno);;
                                    
                                    echo '<p>Congratulations! Your submission is complete! Please click <a href="index.php">here</a> to return to the homepage</p>';
                                    
                                }
                                else {
                                    die("Please check database and query for getting the predicted answers; no rows returned");
                                }

                                }
                                else {
                                    echo "<h6>You have not answered all the MCQ questions! Please go back to the previous page to access your answers and resubmit your answers to finalize your submission. </h6>";
                                
                                }

                                

                                

                                #close connection
                                mysqli_close($conn);
                                

                                }else { echo "<h6>erroneous access</h6>";}

                                unset($_SESSION["submissionid"])

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