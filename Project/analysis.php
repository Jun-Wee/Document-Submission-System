<?php
include "src/library/GoogleNLP/vendor/autoload.php";
include "classes/analysis.php";
include "classes/database.php";
include "classes/sentimentAnalysis.php";
include "classes/analysisTable.php";
include "classes/entityTable.php";
include "classes/submission.php";
include "classes/submissionTable.php";

use Google\Cloud\Language\LanguageClient;   
session_start();
if (!isset($_SESSION['student'])) {
    header("Location: studentLogin.php");
}
else {
    try {
        $language = new LanguageClient([    //ignore red underline on this line if exists
            'keyFilePath' => getcwd().'/src/library/GoogleNLP/psyched-hulling-355705-0568447d899e.json',
        ]);

        //Retrieve the submission ID
        $db = new Database();
        $submission = new SubmissionTable($db);
        $subId = $_SESSION['subId'];
        //echo $subId;

        //Text extraction-------------------------------------------------------------------------------------------------
        $text = $_SESSION['pdfText'];       //Issue: does not recognize images (� character)
        $abstract = explode("Abstract", $text);
        $introduction = explode("Introduction", $text);
        $context = explode("Context", $text);
        $conclusion = explode("Conclusion", $text);
        $reference = explode('Reference', str_replace(array('References'), 'Reference', $text));

        $keywords = "Keyword test";   //Temporary placeholders for database
        $matches = "Matched titles test";

        //Sentiment Analysis-------------------------------------------------------------------------------------------------
        $extractedText = $abstract[2];
        $annotationS = $language->analyzeSentiment($extractedText);     //Analyze the sentiments
        // echo "Extracted text: " . $extractedText;
        // echo "<pre>";print_r($annotationS->sentiment()); echo "</pre>";

        $score = $annotationS->sentiment()['score'];                    //Converting the results array to variable
        $magnitude = $annotationS->sentiment()['magnitude'];

        $sentimentAnalysis = new SentimentAnalysis();
        $emotion = $sentimentAnalysis->evaluate($annotationS);          //Call the sentiment evaluation function

        //Entity Analysis----------------------------------------------------------------------------------------------------

        $annotationE = $language->analyzeEntities($extractedText);      //Analyze the entities

        $myEntities = array_slice($annotationE->entities(), 0, 5);      //Limit the entities to top 5 based on salience score

        //echo "<pre>"; print_r($myEntities); echo "</pre>";

        foreach ($myEntities as $entity) {   
            //echo $entity['name'];
            //echo $entity['salience'];

            //Call entity table interface to store results----------------------------------------------------------
            $db2 = new Database();
            $entityTable = new EntityTable($db2);

            if (isset($entity['metadata']['wikipedia_url'])) {          //Store wikipedia url if exists
                //echo $entity['metadata']['wikipedia_url'];
                $entityTable->add($subId, $entity['name'], $entity['salience'], $entity['metadata']['wikipedia_url']);
            }

            else {                                                      //Store only name and salience otherwise
                $entityTable->add($subId, $entity['name'], $entity['salience'], null);
            }

        }

        //Call analysis table interface to store sentiment results-----------------------------------------------------------
        $analysisTable = new AnalysisTable($db);
        $analysisTable->add($subId, $emotion, $keywords, $matches, $score, $magnitude);              //Call the add function
    }

    catch(Exception $e) {
        echo $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Analyzing... | Document Submission System</title>
	<meta name="language" content="english" />
	<meta charset="utf-8">
	<meta name="author" content="Xin Zhe Chong">
	<meta name="description" content="Document Submission System">
	<meta name="keywords" content="assignment, submission, document">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="refresh" content = "5; url = question.php"/>
	<link rel="icon" href="src/images/logo.png">

	
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="spinner-border text-success" role="status">
        <span class="sr-only">Processing document...</span>
    </div>
</body>
</html>

