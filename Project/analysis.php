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
} else {
    try {
        $language = new LanguageClient([
            //Replace if needed (admin only)
            'keyFilePath' => getcwd() . '/src/library/GoogleNLP/vigilant-design-362312-adb90a0fb461.json',
        ]);

        //Retrieve the submission ID
        $subId = $_SESSION['subId'];
        $title = $_SESSION['title'];
        echo $subId;
        echo $title;

        // //Sentiment Analysis----------------------------------------------------------------------------------------------
        function sentiment($language, $extractedText, $subId, $type)
        {

            $db = new Database();
            $annotationS = $language->analyzeSentiment($extractedText);     //Analyze the sentiments
            //echo "Extracted text: " . $extractedText;
            // echo "<pre>";
            // print_r($annotationS->sentiment());
            // echo "</pre>";

            $score = $annotationS->sentiment()['score'];                    //Converting the results array to variable
            $magnitude = $annotationS->sentiment()['magnitude'];

            $sentimentAnalysis = new SentimentAnalysis();
            $emotion = $sentimentAnalysis->evaluate($score, $magnitude);          //Call the sentiment evaluation function

            // echo $emotion;

            //Call analysis table interface to store sentiment results--------------------------------------------------------
            $analysisTable = new AnalysisTable($db);

            $analysisTable->add($subId, $type, $emotion, $score, $magnitude);  //Call the add function
        }

        // //Entity Analysis-------------------------------------------------------------------------------------------------
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

            return $myEntities;
        }

        //Limit text for question generation------------------------------------------------------------------------------
        function substrWords($text, $maxchar, $end = "...")
        {
            if (strlen($text) > $maxchar || $text == '') {
                $words = preg_split('/\s/', $text);
                $output = '';
                $i = 0;

                while (1) {
                    $length = strlen($output) + strlen($words[$i]);
                    if ($length > $maxchar) {
                        break;
                    } else {
                        $output .= " " . $words[$i];
                        ++$i;
                    }
                }
                $output .= $end;
            } else {
                $output = $text;
            }
            return $output;
        }

        //Add reference to database----------------------------------------------------------------------------------------
        function reference($reference, $subId)
        {
            $db3 = new Database();
            strip_tags($reference);
            $referenceTable = new ReferenceTable($db3);
            $referenceTable->add($subId, $reference);
        }

        //Text extraction-------------------------------------------------------------------------------------------------
        $raw = $_SESSION['pdfText'];                                    //Issue: does not recognize images (� character)

        //Ignore non UTF-8 characters                                   //Works
        $text = iconv("UTF-8", "UTF-8//IGNORE", $raw);

        sentiment($language, $text, $subId, "Content");
        $myentities = entity($language, $text, $subId);

        // echo "<pre>";
        // print_r($myentities);
        // echo "</pre>";

        $entityString = "";

        foreach ($myentities as $entity) {
            $entityString = $entityString . " " . $entity['name'];
        }

        $title = $title . " " . $entityString;

        //Extract references if exists
        if (strpos(strtolower($text), "references") >= 1) {
            $referenceInitial = explode("references", strtolower($text));
            //Stop at the word "Appendix", capture rest if none
            $referenceFinal = preg_split("/Appendix/", trim($referenceInitial[count($referenceInitial) - 1]));
            // echo "References: " . $referenceFinal[0];
            reference($referenceFinal[0], $subId);
        }

        //Extract reference without the S if exists
        elseif (strpos(strtolower($text), "reference") >= 1) {
            $referenceInitial = explode("reference", strtolower($text));
            //Stop at the word "Appendix", capture rest if none
            $referenceFinal = preg_split("/Appendix/", trim($referenceInitial[count($referenceInitial) - 1]));
            // echo "Reference: " . $referenceFinal[0];
            reference($referenceFinal[0], $subId);
        }

        //Extract bibliography if exists
        elseif (strpos(strtolower($text), "bibliography") >= 1) {
            $referenceInitial = explode("bibliography", strtolower($text));
            //Stop at the word "Appendix", capture rest if none
            $referenceFinal = preg_split("/Appendix/", trim($referenceInitial[count($referenceInitial) - 1]));
            // echo "Bibliography: " . $referenceFinal[0];
            reference($referenceFinal[0], $subId);
        }

        //Extract literature cited if exists
        elseif (strpos(strtolower($text), "reference") >= 1) {
            $referenceInitial = explode("literature cited", strtolower($text));
            //Stop at the word "Appendix", capture rest if none
            $referenceFinal = preg_split("/Appendix/", trim($referenceInitial[count($referenceInitial) - 1]));
            // echo "Literature: " . $referenceFinal[0];
            reference($referenceFinal[0], $subId);
        }

        $limitedText = substrWords($text, 510000);                      //Limit words to <=~512kb
        //echo strlen($limitedText);
        //echo $limitedText;

        $_SESSION['questGen'] = $limitedText;
        $_SESSION['title'] = $title;

        header("Location: websearch.php");

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
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
