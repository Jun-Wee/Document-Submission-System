<?php
require "vendor/autoload.php";
require "classes/analysis.php";
require "classes/database.php";
require "classes/sentimentAnalysis.php";

use Google\Cloud\Language\LanguageClient;   

try {
    $language = new LanguageClient([    //ignore red underline on this line if exists
        'keyFilePath' => getcwd().'/GoogleNLP/psyched-hulling-355705-0568447d899e.json',
    ]);

    //Sentiment Analysis---------------------------------------------------------------------------------------------------

    $extractedText = 'Google Cloud Platform is a powerful tool.';
    $annotationS = $language->analyzeSentiment($extractedText);
    echo "Extracted text: " . $extractedText;
    echo "<pre>";print_r($annotationS->sentiment()); echo "</pre>";

    $sentimentAnalysis = new SentimentAnalysis();
    $sentimentAnalysis->evaluate($annotationS);                 //Call the sentiment evaluation function

    //Entity Analysis-----------------------------------------------------------------------------------------------------

    $annotationE = $language->analyzeEntities($extractedText);
    echo "<pre>"; print_r($annotationE->entities()); echo "</pre>";

    foreach ($annotationE->entities() as $entity) {
        echo $entity['type'];
    }

    //Function to call analysis table interface in the sentiment analysis class
    $db = new Database();
    $sentimentAnalysis->storeSentiment($db);

}

catch(Exception $e) {
    echo $e->getMessage();
}

?>