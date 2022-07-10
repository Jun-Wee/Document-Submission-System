<?php
require "vendor/autoload.php";
require "classes/analysis.php";
require "classes/sentimentAnalysis.php";

use Google\Cloud\Language\LanguageClient;   

try {
    $language = new LanguageClient([    //ignore red underline on this line if exists
        'keyFilePath' => getcwd().'/GoogleNLP/psyched-hulling-355705-0568447d899e.json',
    ]);

    //Sentiment Analysis---------------------------------------------------------------------------------------------------

    $annotationS = $language->analyzeSentiment('Google Cloud Platform is a powerful tool.');
    echo "Sample sentence: Google Cloud Platform is a powerful tool.";
    echo "<pre>";print_r($annotationS->sentiment()); echo "</pre>";

    $sentimentAnalysis = new SentimentAnalysis();
    $sentimentAnalysis->evaluate($annotationS);

    //Entity Analysis-----------------------------------------------------------------------------------------------------

    $annotationE = $language->analyzeEntities('Google Cloud Platform is a powerful tool.');
    echo "<pre>"; print_r($annotationE->entities()); echo "</pre>";

    foreach ($annotationE->entities() as $entity) {
        echo $entity['type'];
    }

    //Sending the results to a database required!-------------------------------------------------------------------------
    /*$db = new Database;
    $db->createConnection();                                    //Create the connection to the database
    
    //Create variables to be stored in the database
    $resultSentimentScore = $annotationS->sentiment()['score'];
    $resultSentimentMagnitude = $annotationS->sentiment()['magnitude'];
    $resultEntity[] = $annotationE->entities();

    $db->closeConnection();*/
}

catch(Exception $e) {
    echo $e->getMessage();
}

?>