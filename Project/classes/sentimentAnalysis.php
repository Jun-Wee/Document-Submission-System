<?php 

class SentimentAnalysis {
    private $emotion;
    private $score;
    private $magnitude;

    function sentimentAnalysis() {                  //Fill this spot in the future

    }

    function evaluate($annotationS) {               //Fill this spot with return values
        //Determine the sentiment value from score and magnitude
        //Score = Positive/Negative statement
        //Magnitude = Severity of emotion put into the sentence
        if ($annotationS->sentiment()['score'] > 0) {                   //Positive messages----------------------------
            if ($annotationS->sentiment()['magnitude'] >= 3) {
                echo "This is an extremely positive message!";
            }

            if ($annotationS->sentiment()['magnitude'] >= 1.5 && $annotationS->sentiment()['magnitude'] < 3) {
                echo "This is a very positive message.";
            }

            if ($annotationS->sentiment()['magnitude'] < 1.5) {
                echo "This is a somewhat positive message.";
            }
        }

        if ($annotationS->sentiment()['score'] < 0) {
            if ($annotationS->sentiment()['magnitude'] >= 3) {          //Negative messages---------------------------
                echo "This is an extremely negative message!";
            }

            if ($annotationS->sentiment()['magnitude'] >= 1.5 && $annotationS->sentiment()['magnitude'] < 3) {
                echo "This is a very negative message.";
            }

            if ($annotationS->sentiment()['magnitude'] < 1.5) {
                echo "This is a somewhat negative message.";
            }
        }

        if ($annotationS->sentiment()['score'] == 0) {                  //Neutral messages--------------------------
            if ($annotationS->sentiment()['magnitude'] >= 3) {
                echo "This message contains extremely mixed emotions!";
            }

            if ($annotationS->sentiment()['magnitude'] >= 1.5 && $annotationS->sentiment()['magnitude'] < 3) {
                echo "This message is very mixed.";
            }

            if ($annotationS->sentiment()['magnitude'] < 1.5) {
                echo "This is a somewhat neutral message.";
            }
        }
    }
}

?>