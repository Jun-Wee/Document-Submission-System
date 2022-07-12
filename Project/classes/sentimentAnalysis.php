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
                $emotion = "This is an extremely positive message!";
                echo $emotion;                              //To be deleted at final stage
                return $emotion;
            }

            if ($magnitude >= 1.5 && $magnitude < 3) {
                $emotion = "This is a very positive message.";
                echo $emotion;                              //To be deleted at final stage
                return $emotion;
            }

            if ($magnitude< 1.5) {
                $emotion = "This is a somewhat positive message.";
                echo $emotion;                              //To be deleted at final stage
                return $emotion;
            }
        }

        if ($score < 0) {
            if ($magnitude >= 3) {          //Negative messages---------------------------
                $emotion =  "This is an extremely negative message!";
                echo $emotion;                              //To be deleted at final stage
                return $emotion;
            }

            if ($magnitude >= 1.5 && $magnitude < 3) {
                $emotion = "This is a very negative message.";
                echo $emotion;                              //To be deleted at final stage
                return $emotion;
            }

            if ($magnitude < 1.5) {
                $emotion = "This is a somewhat negative message.";
                echo $emotion;                              //To be deleted at final stage
                return $emotion;
            }
        }

        if ($score == 0) {                  //Neutral messages--------------------------
            if ($magnitude >= 3) {
                $emotion = "This message contains extremely mixed emotions!";
                echo $emotion;                              //To be deleted at final stage
                return $emotion;
            }

            if ($magnitude >= 1.5 && $magnitude < 3) {
                $emotion = "This message is very mixed.";
                echo $emotion;                              //To be deleted at final stage
                return $emotion;
            }

            if ($magnitude < 1.5) {
                $emotion = "This is a somewhat neutral message.";
                echo $emotion;                              //To be deleted at final stage
                return $emotion;
            }
        }
    }

    //Function to call the analysis table interface to store new analysis records
    function storeSentiment($db) {
        //$storeSentiment = new AnalysisTable();
        //$storeSentiment->add();

    }
    
}

?>