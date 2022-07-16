<?php
include "vendor/autoload.php";
include "classes/analysis.php";
include "classes/database.php";
include "classes/sentimentAnalysis.php";
include "classes/analysisTable.php";
include "classes/entityTable.php";

use Google\Cloud\Language\LanguageClient;   

try {
    $language = new LanguageClient([    //ignore red underline on this line if exists
        'keyFilePath' => getcwd().'/GoogleNLP/psyched-hulling-355705-0568447d899e.json',
    ]);

    //Locate the submission ID
    //$id = $_POST["submit"];

    //Sentiment Analysis-------------------------------------------------------------------------------------------------

    $extractedText = 'Google Cloud Platform, table, chair, bus, bottle, Elon Musk, Marvel and car is a powerful tool.';
    $annotationS = $language->analyzeSentiment($extractedText);
    echo "Extracted text: " . $extractedText;
    echo "<pre>";print_r($annotationS->sentiment()); echo "</pre>";

    $score = $annotationS->sentiment()['score'];
    $magnitude = $annotationS->sentiment()['magnitude'];

    $sentimentAnalysis = new SentimentAnalysis();
    $emotion = $sentimentAnalysis->evaluate($annotationS);          //Call the sentiment evaluation function

    //Entity Analysis----------------------------------------------------------------------------------------------------

    $annotationE = $language->analyzeEntities($extractedText);

    $myEntities = array_slice($annotationE->entities(), 0, 3);      //Limit the entities to 3 based on salience score

    echo "<pre>"; print_r($myEntities); echo "</pre>";

    foreach ($myEntities as $entity) {   
        //echo $entity['name'];
        //echo $entity['salience'];

        //Call entity table interface to store results-------------------------------------------------------------
        $db2 = new Database();
        $entityTable = new EntityTable($db2);

        if (isset($entity['metadata']['wikipedia_url'])) {          //Store wikipedia url if exists
            //echo $entity['metadata']['wikipedia_url'];
            $entityTable->add($entity['name'], $entity['salience'], $entity['metadata']['wikipedia_url']);
        }

        else {                                                      //Store only name and salience otherwise
            $entityTable->add($entity['name'], $entity['salience'], null);
        }

    }

    //Call analysis table interface to store results-----------------------------------------------------------
    $db = new Database();
    $analysisTable = new AnalysisTable($db);

    $analysisTable->add($emotion, $score, $magnitude);              //Call the add function
}

catch(Exception $e) {
    echo $e->getMessage();
}

?>