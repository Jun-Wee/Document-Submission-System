<?php
include "src/library/GoogleNLP/vendor/autoload.php";
include "classes/analysis.php";
include "classes/database.php";
include "classes/sentimentAnalysis.php";
include "classes/analysisTable.php";
include "classes/entityTable.php";
include "classes/submission.php";
include "classes/submissionTable.php";
include "classes/reference.php";
include "classes/referenceTable.php";
include "src/library/PDFParser/vendor2/autoload.php";

use Google\Cloud\Language\LanguageClient;   
session_start();
if (!isset($_SESSION['student'])) {
    header("Location: studentLogin.php");
}
else {
    try {
        $language = new LanguageClient([
            //Replace if needed (admin only)
            'keyFilePath' => getcwd().'/src/library/GoogleNLP/vigilant-design-362312-adb90a0fb461.json',
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
            $emotion = $sentimentAnalysis->evaluate($score, $magnitude);          //Call the sentiment evaluation function

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

        //Add reference to database----------------------------------------------------------------------------------------
        function reference($reference, $subId) {
            $db3 = new Database();
            strip_tags($reference);
            $referenceTable = new ReferenceTable($db3);
            $referenceTable->add($subId, $reference);
        }

        //Misc------------------------------------------------------------------------------------------------------------
        // $webSearch = $_POST['webSearch'];
        // $_SESSION['webSearch'] = $webSearch;

        //Text extraction-------------------------------------------------------------------------------------------------
        $raw = $_SESSION['pdfText'];                                    //Issue: does not recognize images (� character)

        //Ignore non UTF-8 characters                                   //Works
        $text = iconv("UTF-8", "UTF-8//IGNORE", $raw);

        // echo $text;

        if (str_contains(strtolower($text), "content") && strpos(strtolower($text), "content") < 5000 || 
        str_contains(strtolower($text), "contents") && strpos(strtolower($text), "contents") < 5000) {
            //echo "First option";
            //Extract the abstract if exists
            if (str_contains(strtolower($text), "abstract") && strpos(strtolower($text), "abstract") < 5000) {
                $abstractInitial = explode("Abstract", $text);      
                $abstractFinal = preg_split("/\s*\n(\s*\n)*\s/", trim($abstractInitial[2]));
                // echo "Abstract: " . $abstractFinal[0];
                $type = "Abstract";
                sentiment($language, $abstractInitial[2], $subId, $type);
                entity($language, $abstractInitial[2], $subId);
            }

            //Extract the introduction if exists
            elseif (str_contains(strtolower($text), "introduction") && strpos(strtolower($text), "introduction") < 10000) {    
                $introductionInitial = explode("Introduction", $text);
                $introductionFinal = preg_split("/\s*\n(\s*\n)*\s/", trim($introductionInitial[2]));
                // echo "Introduction: " . $introductionFinal[0];
                // echo "Introduction: " . $introductionInitial[2];
                $type = "Introduction";
                sentiment($language, $introductionInitial[2], $subId, $type);

                if (!isset($abstractFinal[0])) {
                    entity($language, $introductionInitial[2], $subId);
                }
            }       //Note: Only takes either Abstract + Intro, Intro, Abstract, cannot Intro + Abstract
            
            //Just extract whole document
            else {
                $type = "content";
                sentiment($language, $text, $subId, $type);
                entity($language, $text, $subId);
            }

            //Extract references if exists
            if (str_contains(strtolower($text), "references") || strpos(strtolower($text), "reference") >= 1) {
                if (!isset($abstractInitial[2])) {   //If abstract is not the first paragraph, replace with original text
                    $abstractInitial[2] = $text;
                }
                $referenceInitial = explode("References", $text);
                $referenceFinal = preg_split("/\s*\n(\s*\n)*\s/", trim($referenceInitial[2]));
                // echo "References: " . $referenceFinal[0];
                reference($referenceFinal[0], $subId);
            }
        }

        else {
            // echo "2nd option";
            // echo strpos(strtolower($text), "contents");
            //Extract the abstract if exists
            if (str_contains(strtolower($text), "abstract") && strpos(strtolower($text), "abstract") < 5000) {
                $abstractInitial = explode("Abstract", $text);      
                $abstractFinal = preg_split("/\s*\n(\s*\n)*\s/", trim($abstractInitial[1]));
                // echo "Abstract: " . $abstractFinal[0];
                $type = "Abstract";
                sentiment($language, $abstractInitial[1], $subId, $type);
                entity($language, $abstractInitial[1], $subId);
            }

            //Extract the introduction if exists
            elseif (str_contains(strtolower($text), "introduction") && strpos(strtolower($text), "introduction") < 10000) {    
                $introductionInitial = explode("Introduction", $text);
                $introductionFinal = preg_split("/\s*\n(\s*\n)*\s/", trim($introductionInitial[1]));
                // echo "Introduction: " . $introductionInitial[1];
                $type = "Introduction";
                sentiment($language, $introductionInitial[1], $subId, $type);

                if (!isset($abstractFinal[0])) {
                    entity($language, $introductionInitial[1], $subId);
                }
            }
            //Just extract whole document
            else {
                $type = "content";
                sentiment($language, $text, $subId, $type);
                entity($language, $text, $subId);
            }

            //Extract references if exists
            if (str_contains(strtolower($text), "references") || str_contains(strtolower($text), "reference")) {
                if (!isset($abstractInitial[1])) {   //If abstract is not the first paragraph, replace with original text
                    $abstractInitial[1] = $text;
                }
                $referenceInitial = explode("References", $abstractInitial[1]);
                $referenceFinal = preg_split("/\s*\n(\s*\n)*\s/", trim($referenceInitial[1]));
                // echo "References: " . $referenceFinal[0];
                reference($referenceFinal[0], $subId);
            }
        }
        
//         //Legacy solution (Too ambiguous)-------------------------------------------------------------------------------
//         //$introduction = explode("Introduction", $text);
//         // $context = explode("Context", $text);
//         // $conclusion = explode("Conclusion", $text);
//         // $reference = explode('Reference', str_replace(array('References'), 'Reference', $text));
//         // $title = explode('By', str_replace(array('By', 'by', 'Author'), 'By', $text));
//         // $text = preg_split("/\.|\?|!/", $abstract[2]);
//         //print_r($extractedText);

//         //Choose the correct extracted sentences (guessing from paragraph)
//         //Grouping the sentences
//         // $paragraph1 = $text[1] . $text[2] . $text[3];                   //Abstract
//         // $paragraph2 = $text[5] . $text[6] . $text[7] . $text[8];        //Introduction

//         //Make it if else loop depending on page length
//         //$pageCount = $pdf->getPages();
//         //echo $pageCount;
//         // $paragraph3 = $text[9] . $text[10] . $text[11] . $text[12] . $text[13] . $text[14];


//         //Combine the paragraphs together
//         //$extractedText = $paragraph1 . $paragraph2 . $paragraph3 . $paragraph4 . $paragraph5;
//         //$extractedText = $abstract[2];
    }

    catch(Exception $e) {
        echo $e->getMessage();
    }
}

?>