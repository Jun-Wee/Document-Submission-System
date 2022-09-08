<!-- Description: Question Page in PHP -->
<!-- Author: Adrian Sim Huan Tze and Yovinma Konara -->
<!-- Contributor: Adrian Sim Huan Tze -->
<!-- Date: 31st August 2022 -->
<!--NOT Validated: =-->

<?php

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

            <!--multiple-choice question form-->
            <div class="col py-3">
                <div class="row">
                    <div class="col-10 mx-auto">
                        <div class="container">
                            <div class="p-5 mb-0 bg-light opacity-75 bg-gradient rounded text-dark">
                                <h1 class="navbar-brand"><small class="text-dark"><strong>Multiple-choice questions</strong></small></h1>
                                <p>Please fill the details and answers the all questions:</p>
                                <form action="questionsval.php" method="post">
                                    <ol>
                                            <?php
                                            //for integration 
                                            //file permissions to be changed 
                                            putenv('PATH=/usr/local/bin'); //replace this with the file pathway of the directory containing our stuff
                                            $command = escapeshellcmd("python3 execution.py"); //replace with name of the file 
                                            $result = exec($command, $output, $return_var);

                                            echo "<p>ANSWER ".var_dump($output)."</p>";    
                                            
                                            $result ='{"questions": [{"answer": "egyptians","extra_options": ["Jordanians", "Jews", "Berbers"],"id": 1,"options": ["Arabs", "Turks", "Egypt"],"options_algorithm": "sense2vec","question_statement": "Who believed that if a tomb was robbed,the person buried there could not have a happy afterlife?","question_type": "MCQ"},{"answer": "nile river",
                                            "extra_options": ["Nile", "Inland Sea", "Headwaters", "Steppes","Marshlands", "Little Island"], "id": 2, "options": ["Himalayas", "Mountain Range", "Mediterranean"],   "options_algorithm": "sense2vec","question_statement": "What river fed Egyptian civilization for hundreds of years?",  "question_type": "MCQ"},{"answer": "pharaoh", "extra_options": ["Catacombs", "Temple","Ancient City", "Necropolis", "Cavern", "Priestess", "Yharnam"],"id": 4,"options": ["Shrine", "Mausoleum", "Crypt"],"options_algorithm": "sense2vec","question_statement": "What was the first ruler of Egypt buried in?", "question_type": "MCQ"}, {"answer": "priest", "id": 5, "options": ["Shaman", "Paladin", "Cleric"], "options_algorithm": "sense2vec", "question_statement": "What is one of the highest jobs in Egypt?", "question_type": "MCQ"},{"answer": "word",  "extra_options": [], "id": 6, "options": ["Phrase", "Actual Meaning", "Dictionary"], "options_algorithm": "sense2vec", "question_statement": "What is the Egyptian word for gold?", "question_type": "MCQ"}],"time_taken": 30.612271070480347}';
                                            
                                            $q = json_decode($result); 
                                            foreach ($q->questions as $qs) {
                                               
                                                echo '<li>';
                                                echo '<h6>Question: '.$qs->question_statement.'</h6>';
                                                echo '<div class="form-group"> <ul>';

                                                $answerpos = rand(0,2);
                                                $optionsarr =[];
                                                $arrselect = ""; 
                                                empty($qs->options) == FALSE ? $arrselect="options": $arrselect="extra_options";
                                                for($x=0; $x<3;$x++){
                                                    $x == $answerpos ?( array_push($optionsarr, ucfirst($qs->answer)) AND array_push($optionsarr,$qs->$arrselect[$x]))  : (array_push($optionsarr,$qs->$arrselect[$x]));
                                                }
                                                

                                                $pos =0; //to keep track of the number of options and integrate it to their HTML tags for proper MCQ selection
                                               
                                                $extraoptions= array("All of the above", "none of the above");
                                                $x=0;
                                                while (count($optionsarr) < 4){
                                                    array_push($optionsarr,$extraoptions[$x]);
                                                } 


                                                foreach ($optionsarr as $op) {
                                                  
                                                    echo '<div class="form-check form-check-inline">';
                                                    $qname ='q'.($qs->id);
                                                    $rdname ='inlineRadio'.($pos+=1);
                                                    echo '<input class="form-check-input" type="radio" name="'.$qname.'" id="'.$rdname.'" value="'.$op.'">';
                                                    echo '<label class="form-check-label" for="'.$rdname.'">'.$op.'</label></div><br/>';
                                                }
                                                echo '</ul></div></li><br/>';
                                            }
                                            
                                            ?>
                                    
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