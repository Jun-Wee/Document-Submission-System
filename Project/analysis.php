<?php
include "src/library/GoogleNLP/vendor/autoload.php";
include "classes/analysis.php";
include "classes/database.php";
include "classes/sentimentAnalysis.php";
include "classes/analysisTable.php";
include "classes/entityTable.php";
include "classes/submission.php";
include "classes/submissionTable.php";
include "src/library/PDFParser/vendor2/autoload.php";

use Google\Cloud\Language\LanguageClient;   
session_start();
if (!isset($_SESSION['student'])) {
    header("Location: studentLogin.php");
}
else {
    try {
        $language = new LanguageClient([
            'keyFilePath' => getcwd().'/src/library/GoogleNLP/psyched-hulling-355705-0568447d899e.json',
        ]);

        //Retrieve the submission ID
        $subId = $_SESSION['subId'];
        //echo $subId;

        //Sentiment Analysis----------------------------------------------------------------------------------------------
        function sentiment($language, $extractedText, $subId, $type) {

            $db = new Database();
            $annotationS = $language->analyzeSentiment($extractedText);     //Analyze the sentiments
            // echo "Extracted text: " . $extractedText;
            // echo "<pre>";print_r($annotationS->sentiment()); echo "</pre>";

            $score = $annotationS->sentiment()['score'];                    //Converting the results array to variable
            $magnitude = $annotationS->sentiment()['magnitude'];

            $sentimentAnalysis = new SentimentAnalysis();
            $emotion = $sentimentAnalysis->evaluate($annotationS);          //Call the sentiment evaluation function

            //Call analysis table interface to store sentiment results--------------------------------------------------------
            $analysisTable = new AnalysisTable($db);

            $analysisTable->add($subId, $type, $emotion, $score, $magnitude);  //Call the add function
        }

        //Entity Analysis-------------------------------------------------------------------------------------------------
        function entity($language, $extractedText, $subId) {
            $annotationE = $language->analyzeEntities($extractedText);      //Analyze the entities

            $myEntities = array_slice($annotationE->entities(), 0, 5);      //Limit entities to top 5 based on salience score

            //echo "<pre>"; print_r($myEntities); echo "</pre>";

            foreach ($myEntities as $entity) {   
                //echo $entity['name'];
                //echo $entity['salience'];

                //Call entity table interface to store results---------------------------------------
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
        }

        //Text extraction-------------------------------------------------------------------------------------------------
        $raw = $_SESSION['pdfText'];                                    //Issue: does not recognize images (� character)

        //Ignore non UTF-8 characters                                   //
        $text = iconv("UTF-8", "UTF-8//IGNORE", $raw);

        //Extract the abstract if exists
        if (strpos(strtolower($text), "abstract") !== false) {
            $abstractInitial = explode("Abstract", $text);
            $abstractFinal = preg_split("/\s*\n(\s*\n)*\s/", trim($abstractInitial[2]));
            // echo "Abstract: " . $abstractFinal[0];
            $type = "Abstract";
            sentiment($language, $abstractFinal[0], $subId, $type);
            entity($language, $abstractFinal[0], $subId);
        }

        //Extract the introduction if exists
        if (strpos(strtolower($text), "introduction") !== false) {    
            if (empty($abstractInitial[2])) {
                $abstractInitial[2] = $text;    //If abstract is not the first paragraph, replace with original text
            }
            $introductionInitial = explode("Introduction", $abstractInitial[2]);
            $introductionFinal = preg_split("/\s*\n(\s*\n)*\s/", trim($introductionInitial[1]));
            // echo "Introduction: " . $introductionFinal[0];
            $type = "Introduction";
            sentiment($language, $introductionFinal[0], $subId, $type);

            if (empty($abstractFinal[0])) {
                entity($language, $introductionFinal[0], $subId);
            }
        }

        //Extract executive summary if exists
        if (strpos(strtolower($text), "executive summary") !== false) {
            if (empty($abstractInitial[2])) {   //If abstract is not the first paragraph, replace with introduction
                $abstractInitial[2] = $introductionInitial[1];
            }
            $esInitial = explode("Executive summary", $abstractInitial[2]);
            $esFinal = preg_split("/\s*\n(\s*\n)*\s/", trim($esInitial[1]));
            $type = "Executive summary";
            sentiment($language, $esFinal[0], $subId, $type);
        }

        //Extract conclusion if exists
        if (strpos(strtolower($text), "conclusion") !== false) {
            if (empty($abstractInitial[2])) {   //If abstract is not the first paragraph, replace with introduction
                $abstractInitial[2] = $introductionInitial[1];
            }
            $conclusionInitial = explode("Conclusion", $abstractInitial[2]);
            $conclusionFinal = preg_split("/\s*\n(\s*\n)*\s/", trim($conclusionInitial[1]));
            echo "Conclusion: " . $conclusionFinal[0]; 
            $type = "Conclusion";
            sentiment($language, $conclusionFinal[0], $subId, $type);
        }

        //Extract discussion if exists
        if (strpos(strtolower($text), "discussion") !== false) {
            if (empty($abstractInitial[2])) {   //If abstract is not the first paragraph, replace with introduction
                $abstractInitial[2] = $introductionInitial[1];
            }
            $discussionInitial = explode("Discussion", $abstractInitial[2]);
            $discussionFinal = preg_split("/\s*\n(\s*\n)*\s/", trim($discussionInitial[1]));
            $type = "Discussion";
            sentiment($language, $discussionFinal[0], $subId, $type);
        }

        //Extract references if exists
        if (strpos(strtolower($text), "references") !== false || strpos(strtolower($text), "reference") !== false) {
            if (empty($abstractInitial[2])) {   //If abstract is not the first paragraph, replace with original text
                $abstractInitial[2] = $introductionInitial[1];
            }
            $referenceInitial = explode("References", $abstractInitial[2]);
            $referenceFinal = preg_split("/\s*\n(\s*\n)*\s/", trim($referenceInitial[1]));
            // echo "References: " . $referenceFinal[0];
        }

        //$introduction = explode("Introduction", $text);
        // $context = explode("Context", $text);
        // $conclusion = explode("Conclusion", $text);
        // $reference = explode('Reference', str_replace(array('References'), 'Reference', $text));
        // $title = explode('By', str_replace(array('By', 'by', 'Author'), 'By', $text));
        // $text = preg_split("/\.|\?|!/", $abstract[2]);
        //print_r($extractedText);

        //Choose the correct extracted sentences (guessing from paragraph)
        //Grouping the sentences
        // $paragraph1 = $text[1] . $text[2] . $text[3];                   //Abstract
        // $paragraph2 = $text[5] . $text[6] . $text[7] . $text[8];        //Introduction

        //Make it if else loop depending on page length
        //$pageCount = $pdf->getPages();
        //echo $pageCount;
        // $paragraph3 = $text[9] . $text[10] . $text[11] . $text[12] . $text[13] . $text[14];
        // $paragraph4 = $text[30] . $text[31] . $text[32] . $text[33] . $text[34] . $text[35];
        // $paragraph5 = $text[36] . $text[37] . $text[38] . $text[39] . $text[40] . $text[41];

        //Combine the paragraphs together
        //$extractedText = $paragraph1 . $paragraph2 . $paragraph3 . $paragraph4 . $paragraph5;
        //$extractedText = $abstract[2];
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
    <!--<meta http-equiv="refresh" content = "5; url = question.php"/>-->
	<link rel="icon" href="src/images/logo.png">

	
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <br><br><br><br><br><br><br><br><br><br><br><br>
    <div class="text-center">
        <div class="spinner-border text-success m-10" style="width: 5rem; height: 5rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <br><br>
        <strong>Processing document...</strong>
    </div>
</body>
</html>

