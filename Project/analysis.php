<?php
include "vendor/autoload.php";
include "classes/analysis.php";
include "classes/database.php";
include "classes/sentimentAnalysis.php";
include "classes/analysisTable.php";

use Google\Cloud\Language\LanguageClient;   

try {
    $language = new LanguageClient([    //ignore red underline on this line if exists
        'keyFilePath' => getcwd().'/GoogleNLP/psyched-hulling-355705-0568447d899e.json',
    ]);

    //Locate the submission ID
    //$id = $_POST["submit"];

    //Sentiment Analysis---------------------------------------------------------------------------------------------------

    $extractedText = 'Google Cloud Platform, table, chair, bus, bottle, Elon Musk, Marvel and car is a powerful tool.';
    $annotationS = $language->analyzeSentiment($extractedText);
    echo "Extracted text: " . $extractedText;
    echo "<pre>";print_r($annotationS->sentiment()); echo "</pre>";

    $score = $annotationS->sentiment()['score'];
    $magnitude = $annotationS->sentiment()['magnitude'];

    $sentimentAnalysis = new SentimentAnalysis();
    $emotion = $sentimentAnalysis->evaluate($annotationS);                 //Call the sentiment evaluation function

    //Entity Analysis------------------------------------------------------------------------------------------------------

    $annotationE = $language->analyzeEntities($extractedText);

    $myEntities = array_slice($annotationE->entities(), 0, 3);

    echo "<pre>"; print_r($myEntities); echo "</pre>";

    foreach ($myEntities as $entity) {                         //Limit the freq
        echo $entity['name'];
        echo $entity['salience'];

        if (isset($entity['metadata']['wikipedia_url'])) {
            echo $entity['metadata']['wikipedia_url'];
        }
    }

    //Function to call analysis table interface to store results-----------------------------------------------------------
    $db = new Database();
    $analysisTable = new AnalysisTable($db);

    $analysisTable->add($emotion, $score, $magnitude);  //Call the add function

    //$sql = "INSERT INTO `analysis`(`entity`, `salience`, `link`)";        //cannot store more than 1 entity

}

catch(Exception $e) {
    echo $e->getMessage();
}

?>