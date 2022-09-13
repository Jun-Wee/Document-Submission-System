<!-- Description: Form Handling for Question Page in PHP -->
<!-- Author:  Yovinma Konara -->
<!-- Contributor: Adrian Sim Huan Tze -->
<!-- Date: 5th September 2022 -->
<!-- Validated: =-->

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
  <body>
    <div>

    <?php

    #start session to get the super global submissionID
    session_start();
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
        
        echo "<p>Congratulations! Your submission is complete! You will be redirected to the home page in 3 seconds</p>";
        header( "refresh:3;url=index.php");
      }
      else {
        die("Please check database and query for getting the predicted answers; no rows returned");
      }

      }
      else {
        echo "<h6>You have not answered all the MCQ questions! Please go back to the previous page to access your answers and resubmit your answers to finalize your submission. </h6>";
      
      }
      #unset session variable that contains submission ID
      unset($_SESSION["submissionid"]);
      

      

    #close connection
    mysqli_close($conn);
      

    }else { echo "<h6>erroneous access</h6>";}


    ?>
    </div>
  </body>
</html>