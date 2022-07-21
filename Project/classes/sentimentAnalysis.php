<?php 

class SentimentAnalysis {
    private $emotion;
    private $score;
    private $magnitude;

    function evaluate($annotationS) {               //Fill this spot with return values
        //Determine the sentiment value from score and magnitude
        //Score = Positive/Negative statement
        //Magnitude = Severity of emotion put into the sentence

        $score = $annotationS->sentiment()['score'];
        $magnitude = $annotationS->sentiment()['magnitude'];

        if ($score > 0) {                   //Positive messages----------------------------
            if ($magnitude >= 3) {
                $emotion = "The overall document contains extremely positive messages!";                  //Edit message
                echo $emotion;                              //To be deleted at final stage
                return $emotion;
            }

            if ($magnitude >= 1.5 && $magnitude < 3) {
                $emotion = "The overall document contains very positive messages.";
                echo $emotion;                              //To be deleted at final stage
                return $emotion;
            }

            if ($magnitude< 1.5) {
                $emotion = "The overall document contains somewhat positive messages.";
                echo $emotion;                              //To be deleted at final stage
                return $emotion;
            }
        }

        if ($score < 0) {
            if ($magnitude >= 3) {          //Negative messages---------------------------
                $emotion =  "The overall document contains extremely negative messages!";
                echo $emotion;                              //To be deleted at final stage
                return $emotion;
            }

            if ($magnitude >= 1.5 && $magnitude < 3) {
                $emotion = "The overall document contains very negative messages.";
                echo $emotion;                              //To be deleted at final stage
                return $emotion;
            }

            if ($magnitude < 1.5) {
                $emotion = "The overall document contains somewhat negative messages.";
                echo $emotion;                              //To be deleted at final stage
                return $emotion;
            }
        }

        if ($score == 0) {                  //Neutral messages--------------------------
            if ($magnitude >= 3) {
                $emotion = "The overall document contains extremely mixed emotions!";
                echo $emotion;                              //To be deleted at final stage
                return $emotion;
            }

            if ($magnitude >= 1.5 && $magnitude < 3) {
                $emotion = "The message in the overall document is very mixed.";
                echo $emotion;                              //To be deleted at final stage
                return $emotion;
            }

            if ($magnitude < 1.5) {
                $emotion = "The overall document contains somewhat neutral message.";
                echo $emotion;                              //To be deleted at final stage
                return $emotion;
            }
        }
    }
}

?>