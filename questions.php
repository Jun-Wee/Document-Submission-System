<!-- Description: Question Page in PHP -->
<!-- Author: Adrian Sim Huan Tze and Yovinma Konara -->
<!-- Contributor: Adrian Sim Huan Tze -->
<!-- Date: 31st August 2022 -->
<!--NOT Validated: =-->

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

<body onload="startTIME();"  style= "background-image: url('src/images/questions-image.jpg');">

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
            <div class="col py-3" >
                <div class="row">
                    <div class="col-10 mx-auto">
                        <div class="container">
                            <div class="p-5 mb-0 bg-light opacity-75 bg-gradient rounded text-dark">
                                <h1 class="navbar-brand"><small class="text-dark"><strong>Multiple-choice questions</strong></small></h1>
                                <p>Please fill the details and answers the all questions:</p>
                                <form action="questionsval.php" method="post">
                                    <ol>
                                            <?php
                                            $serverName = "127.0.0.1";
                                            $username = "root";
                                            $password = "root";
                                            $dbName = "documentsubmissionsystem";
                                            
                                            
                                            $_SESSION["submissionid"] = "100072";
                                            /*$serverName="documentsubmissionsystem.c2tnrfke8bpv.us-east-1.rds.amazonaws.com",
                                            $username="admin",
                                            $password="documentsubmissionsystem",
                                            $dbName="documentsubmissionsystem"
                                            */

                                            //create connection
                                            $conn = new mysqli($serverName, $username, $password, $dbName);

                                            if ($conn->connect_error) {
                                                die("Connection failed: " . $conn->connect_error);
                                              }
                                            else {
                                                #get file path of the submitted file
                                                $getPathQuery = "SELECT filepath FROM submission WHERE Id = ".$_SESSION["submissionid"].";" ;
                                                $result = $conn -> query($getPathQuery) or die("Something has gone wrong! ".$conn->errorno);
                                                $row = $result -> fetch_row();

                                                if($row!=NULL){
                                                    #pass file as an argument for the python script
                                                    //for integration 
                                                    //file permissions to be changed 
                                                    putenv('PATH=C:/xampp/htdocs/xampp/softwareproj'); //replace this with the file pathway of the directory containing our stuff
                                                    $pythonCommand = "python myquestion.py ./".$row[0]."";//replace with name of the file 
                                                    echo "<p> pathway". $pythonCommand."</p>";
                                                    $command = escapeshellcmd($pythonCommand); 
                                                    $result = exec($command, $output, $returnVar);
                                                    
                                                    #the echo below is for web integration testing purposes 
                                                    echo "<p>ANSWER ".var_dump($result)."</p>";    

                                                    #the single quotes need to be replaced with double quotes to be decoded as a json object
                                                    $result = str_replace('\'','"',$result);
                                                   
                                                    
                                                    $result ='{"questions": [{"answer": "egyptians", "extra_options": ["Jordanians", "Jews", "Berbers"],
                                                        "id": 1,
                                                        "options": ["Arabs", "Turks", "Egypt"],
                                                        "options_algorithm": "sense2vec",
                                                        "question_statement": "Who believed that if a tomb was robbed,the person buried there could not have a happy afterlife?",
                                                        "question_type": "MCQ"},
                                                        {"answer": "nile river","extra_options": ["Nile", "Inland Sea","Headwaters", "Steppes",  "Marshlands", "Little Island"],
                                                        "id": 2,
                                                        "options": ["Himalayas", "Mountain Range", "Mediterranean"],
                                                        "options_algorithm": "sense2vec",
                                                        "question_statement": "What river fed Egyptian civilization for hundreds of years?",
                                                        "question_type": "MCQ"},
                                                         {"answer": "pharaoh",
                                                        "extra_options": ["Almighty", "Israelites"],
                                                        "id": 3,
                                                        "options": ["Moses", "High Priest", "Messiah"],
                                                        "options_algorithm": "sense2vec",
                                                        "question_statement": "Who was thought to be a god?",
                                                        "question_type": "MCQ"},
                                                        {"answer": "tomb",
                                                        "extra_options": ["Catacombs","Temple", "Ancient City", "Necropolis","Cavern", "Priestess","Yharnam"],
                                                        "id": 4,
                                                        "options": ["Shrine", "Mausoleum", "Crypt"],
                                                        "options_algorithm": "sense2vec",
                                                        "question_statement": "What was the first ruler of Egypt buried in?",
                                                        "question_type": "MCQ"},
                                                        {"answer": "priest",
                                                        "extra_options": ["Consecrate"],
                                                        "id": 5,
                                                        "options": ["Shaman", "Paladin", "Cleric"],
                                                        "options_algorithm": "sense2vec",
                                                        "question_statement": "What is one of the highest jobs in Egypt?",
                                                        "question_type": "MCQ"}] }';
                                                        
                                                        $q = json_decode($result);
                                                
                                                        foreach ($q->questions as $qs) {
                                                        
                                                            echo '<li>';
                                                            echo '<h6>Question: '.$qs->question_statement.'</h6>';
                                                            echo '<div class="form-group"> <ul>';

                                                            $answerPos = rand(0,2);
                                                            $optionsArr =[];
                                                            $arrSelect = ""; 
                                                            empty($qs->options) == FALSE ? $arrSelect="options": $arrSelect="extra_options";
                                                            for($x=0; $x<3;$x++){
                                                                $x == $answerPos ?( array_push($optionsArr, ucfirst($qs->answer)) AND array_push($optionsArr,$qs->$arrSelect[$x]))  : (array_push($optionsArr,$qs->$arrSelect[$x]));
                                                            }
                                                            

                                                            $pos =0; //to keep track of the number of options and integrate it to their HTML tags for proper MCQ selection
                                                        
                                                            $extraOptions= array("All of the above", "none of the above");
                                                            $x=0;
                                                            while (count($optionsArr) < 4){
                                                                array_push($optionsArr,$extraOptions[$x]);
                                                            } 

                                                            foreach ($optionsArr as $op) {
                                                            
                                                                echo '<div class="form-check form-check-inline">';
                                                                $qName ='q'.($qs->id);
                                                            
                                                                $rdName ='inlineRadio'.($pos+=1);
                                                                echo '<input class="form-check-input" type="radio" name="'.$qName.'" id="'.$rdName.'" value="'.$op.'">';
                                                                echo '<label class="form-check-label" for="'.$rdName.'">'.$op.'</label></div><br/>';
                                                            }
                                                            echo '</ul></div></li><br/>';
                                                        }
                                                
                                                }
                                                else {
                                                    die("Please check submission ID; no file pathway returned");
                                                }
                                                
                                               
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