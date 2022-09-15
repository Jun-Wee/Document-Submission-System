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
} else {
    try {
        $language = new LanguageClient([
            //Replace if needed (admin only)
            'keyFilePath' => getcwd() . '/src/library/GoogleNLP/psyched-hulling-355705-0568447d899e.json',
        ]);

        //Retrieve the submission ID
        $subId = $_SESSION['subId'];
        //echo $subId;

        //Sentiment Analysis----------------------------------------------------------------------------------------------
        function sentiment($language, $extractedText, $subId, $type)
        {

            $db = new Database();
            $annotationS = $language->analyzeSentiment($extractedText);     //Analyze the sentiments
            // echo "Extracted text: " . $extractedText;
            // echo "<pre>";print_r($annotationS->sentiment()); echo "</pre>";

            $score = $annotationS->sentiment()['score'];                    //Converting the results array to variable
            $magnitude = $annotationS->sentiment()['magnitude'];

            $sentimentAnalysis = new SentimentAnalysis();
            //$emotion = $sentimentAnalysis->evaluate($annotationS);          //Call the sentiment evaluation function

            //Call analysis table interface to store sentiment results--------------------------------------------------------
            $analysisTable = new AnalysisTable($db);

            //$analysisTable->add($subId, $type, $emotion, $score, $magnitude);  //Call the add function
        }

        //Entity Analysis-------------------------------------------------------------------------------------------------
        function entity($language, $extractedText, $subId)
        {
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
                } else {                                                      //Store only name and salience otherwise
                    $entityTable->add($subId, $entity['name'], $entity['salience'], null);
                }
            }
        }

        //Text extraction-------------------------------------------------------------------------------------------------
        $raw = $_SESSION['pdfText'];                                    //Issue: does not recognize images (� character)

        //Ignore non UTF-8 characters                                   //Works
        $text = iconv("UTF-8", "UTF-8//IGNORE", $raw);

        if (str_contains(strtolower($text), "content") && strpos(strtolower($text), "content") < 5000) {
            //Extract the abstract if exists
            if (str_contains(strtolower($text), "abstract") && strpos(strtolower($text), "abstract") < 5000) {
                $abstractInitial = explode("Abstract", $text);
                $abstractFinal = preg_split("/\s*\n(\s*\n)*\s/", trim($abstractInitial[2]));
                // echo "Abstract: " . $abstractFinal[0];
                $type = "Abstract";
                sentiment($language, $abstractFinal[0], $subId, $type);
                entity($language, $abstractInitial[2], $subId);
            }

            //Extract the introduction if exists
            if (str_contains(strtolower($text), "introduction") && strpos(strtolower($text), "introduction") < 10000) {
                if (empty($abstractInitial[2])) {
                    $abstractInitial[2] = $text;    //If abstract is not the first paragraph, replace with original text
                }
                $introductionInitial = explode("Introduction", $abstractInitial[2]);
                $introductionFinal = preg_split("/\s*\n(\s*\n)*\s/", trim($introductionInitial[2]));
                // echo "Introduction: " . $introductionFinal[0];
                // echo "Introduction: " . $introductionInitial[2];
                $type = "Introduction";
                sentiment($language, $introductionFinal[0], $subId, $type);

                if (empty($abstractFinal[0])) {
                    entity($language, $introductionInitial[2], $subId);
                }
            }       //Note: Only takes either Abstract + Intro, Intro, Abstract, cannot Intro + Abstract

            //Extract executive summary if exists
            if (str_contains(strtolower($text), "executive summary")) {
                if (empty($abstractInitial[2])) {   //If abstract is not the first paragraph, replace with introduction
                    $abstractInitial[2] = $introductionInitial[2];
                }
                $esInitial = explode("Executive summary", $abstractInitial[2]);
                $esFinal = preg_split("/\s*\n(\s*\n)*\s/", trim($esInitial[2]));
                $type = "Executive summary";
                sentiment($language, $esFinal[0], $subId, $type);
            }

            //Extract conclusion if exists
            if (str_contains(strtolower($text), "conclusion")) {
                if (empty($abstractInitial[2])) {   //If abstract is not the first paragraph, replace with introduction
                    $abstractInitial[2] = $introductionInitial[2];
                }
                $conclusionInitial = explode("Conclusion", $abstractInitial[2]);
                $conclusionFinal = preg_split("/\s*\n(\s*\n)*\s/", trim($conclusionInitial[2]));
                //echo "Conclusion: " . $conclusionFinal[0]; 
                $type = "Conclusion";
                sentiment($language, $conclusionFinal[2], $subId, $type);
            }

            //Extract discussion if exists
            if (str_contains(strtolower($text), "discussion")) {
                if (empty($abstractInitial[2])) {   //If abstract is not the first paragraph, replace with introduction
                    $abstractInitial[2] = $introductionInitial[2];
                }
                $discussionInitial = explode("Discussion", $abstractInitial[2]);
                $discussionFinal = preg_split("/\s*\n(\s*\n)*\s/", trim($discussionInitial[2]));
                $type = "Discussion";
                sentiment($language, $discussionFinal[0], $subId, $type);
            }

            //Extract references if exists
            if (str_contains(strtolower($text), "references") || strpos(strtolower($text), "reference") >= 1) {
                if (empty($abstractInitial[2])) {   //If abstract is not the first paragraph, replace with original text
                    $abstractInitial[2] = $introductionInitial[2];
                }
                $referenceInitial = explode("References", $text);
                $referenceFinal = preg_split("/\s*\n(\s*\n)*\s/", trim($referenceInitial[2]));
                //Store the reference in session for future usage
                $_SESSION["reference"] = $referenceFinal[0];
                // echo "References: " . $referenceFinal[0];
            }
        } else {
            // echo "No table of content found";
            // echo strpos(strtolower($text), "contents");
            //Extract the abstract if exists
            if (str_contains(strtolower($text), "abstract") && strpos(strtolower($text), "abstract") < 5000) {
                $abstractInitial = explode("Abstract", $text);
                $abstractFinal = preg_split("/\s*\n(\s*\n)*\s/", trim($abstractInitial[1]));
                // echo "Abstract: " . $abstractFinal[0];
                $type = "Abstract";
                sentiment($language, $abstractFinal[0], $subId, $type);
                entity($language, $abstractFinal[0], $subId);
            }

            //Extract the introduction if exists
            if (str_contains(strtolower($text), "introduction") && strpos(strtolower($text), "introduction") < 10000) {
                if (empty($abstractInitial[1])) {
                    $abstractInitial[1] = $text;    //If abstract is not the first paragraph, replace with original text
                }
                $introductionInitial = explode("Introduction", $abstractInitial[1]);
                $introductionFinal = preg_split("/\s*\n(\s*\n)*\s/", trim($introductionInitial[1]));
                // echo "Introduction: " . $introductionFinal[0];
                $type = "Introduction";
                sentiment($language, $introductionFinal[0], $subId, $type);

                if (empty($abstractFinal[0])) {
                    entity($language, $introductionFinal[0], $subId);
                }
            }

            //Extract executive summary if exists
            if (str_contains(strtolower($text), "executive summary")) {
                if (empty($abstractInitial[1])) {   //If abstract is not the first paragraph, replace with introduction
                    $abstractInitial[1] = $introductionInitial[1];
                }
                $esInitial = explode("Executive summary", $abstractInitial[1]);
                $esFinal = preg_split("/\s*\n(\s*\n)*\s/", trim($esInitial[1]));
                $type = "Executive summary";
                sentiment($language, $esFinal[0], $subId, $type);
            }

            //Extract conclusion if exists
            if (str_contains(strtolower($text), "conclusion")) {
                if (empty($abstractInitial[1])) {   //If abstract is not the first paragraph, replace with introduction
                    $abstractInitial[1] = $introductionInitial[1];
                }
                $conclusionInitial = explode("Conclusion", $abstractInitial[1]);
                $conclusionFinal = preg_split("/\s*\n(\s*\n)*\s/", trim($conclusionInitial[1]));
                //echo "Conclusion: " . $conclusionFinal[0]; 
                $type = "Conclusion";
                sentiment($language, $conclusionFinal[0], $subId, $type);
            }

            //Extract discussion if exists
            if (str_contains(strtolower($text), "discussion")) {
                if (empty($abstractInitial[1])) {   //If abstract is not the first paragraph, replace with introduction
                    $abstractInitial[1] = $introductionInitial[1];
                }
                $discussionInitial = explode("Discussion", $abstractInitial[1]);
                $discussionFinal = preg_split("/\s*\n(\s*\n)*\s/", trim($discussionInitial[1]));
                $type = "Discussion";
                sentiment($language, $discussionFinal[0], $subId, $type);
            }

            //Extract references if exists
            if (str_contains(strtolower($text), "references") || str_contains(strtolower($text), "reference")) {
                if (empty($abstractInitial[1])) {   //If abstract is not the first paragraph, replace with original text
                    $abstractInitial[1] = $introductionInitial[1];
                }
                $referenceInitial = explode("References", $abstractInitial[1]);
                $referenceFinal = preg_split("/\s*\n(\s*\n)*\s/", trim($referenceInitial[1]));
                // echo "References: " . $referenceFinal[0];
            }
        }

        //Legacy solution (Too ambiguous)-------------------------------------------------------------------------------
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


        //Combine the paragraphs together
        //$extractedText = $paragraph1 . $paragraph2 . $paragraph3 . $paragraph4 . $paragraph5;
        //$extractedText = $abstract[2];
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
