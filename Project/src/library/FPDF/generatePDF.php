<?php
include "../../../classes/MyPDF.php";
include "../../../classes/database.php";
include "../../../classes/analysisTable.php";
include "../../../classes/entity.php";
include "../../../classes/entityTable.php";
include "../../../classes/submissionTable.php";
include "../../../classes/analysis.php";
include "../../../classes/submission.php";
include "../../../classes/webSearch.php";
include "../../../classes/webSearchTable.php";
include "../../../classes/reference.php";
include "../../../classes/referenceTable.php";

// start the session
session_start();

if (!isset($_SESSION['admin'])) {
    if (!isset($_SESSION['convenor'])) {
        header("Location: ../../../../adminLogin.php");
    } else {
        $convenor = unserialize($_SESSION['convenor']);
    }
} else {
    $admin = unserialize($_SESSION['admin']);
}

// //Document general information------------------------------------------------------------------------------
$subId = null;                                                          //Placeholder ID for testing 

if (isset($_GET['subId'])) {
    if (!empty($_GET['subId'])) {
        $subId = $_GET['subId'];
    }
}

function stringFormat($string, $string_maxlength)
{
    $str_array = explode(" ", $string);
    $new_str_array = array();
    $str_maxlength = $string_maxlength;
    $str_length = 0;
    for ($j = 0; $j < count($str_array); $j++) {
        if ($str_length < $str_maxlength) {
            if (preg_match("/^[A-Za-z0-9-:,_.() \'\"]+$/D", $str_array[$j])) {
                array_push($new_str_array, $str_array[$j]);
            } else {
                array_push($new_str_array, "...");
            }
            $str_length = strlen(implode(" ", $new_str_array));
        } else {
            array_push($new_str_array, "...");
            break;
        }
    }
    $new_string = implode(" ", $new_str_array);
    return $new_string;
}

//Connect to database
$db = new Database();
$submissionTable = new SubmissionTable($db);
$analysisTable = new AnalysisTable($db);
$entityTable = new EntityTable($db);
$webSearchTable = new webSearchTable($db);
$referenceTable = new ReferenceTable($db);

// //Instantiate and use the FPDF class
$pdf = new MyPDF();
$pdf->AliasNbPages();

// //Add page title and author
$pdf->SetAuthor('SEP=28');
$pdf->SetTitle('Analysis Report | Document Submission System');

//Add a new page
$pdf->AddPage();

//Add an image
$image1 = "../../images/logo.png";             //Document Submission System Logo
$image2 = "../../images/swinburne.png";        //Swinburne Logo (Change to other logo if different campus)
$pdf->Image($image1, 160, 13, 37);
$pdf->Image($image2, 10, 15, 41);

//Set the font
$pdf->SetFont('Arial', 'B', '18');

//Add page heading
$pdf->SetXY(55, 20);
$pdf->Cell(100, 10, 'Analysis Report', 0, 0, 'C', 0);

//Add content-----------------------------------Change this last
$pdf->SetXY(10, 50);
$pdf->SetFontSize(12);                          //Change font size

$submission = $submissionTable->Get($subId);    //Obtain submission details
$pdf->Cell(0, 10, 'Submission ID: ' . ($subId), 0, 1);
$pdf->Cell(0, 10, 'Student ID: ' . ($submission->getstuId()), 0, 1);
$pdf->Cell(0, 10, 'Course Code: ' . ($submission->getUnitCode()), 0, 1);
// Make adjustment to the filepath so that it only outputs the file name instead of the entire filepath
$filepath_array = explode("/", $submission->getfilepath());
$filename = end($filepath_array);
$pdf->Cell(0, 10, 'Document: ' . (substr($filename, 0, -4)), 0, 1);

// //Document analysis information-----------------------------------------------------------------------------
$pdf->Cell(0, 10, '', 0, 1);
$pdf->Cell(0, 10, 'Sentiment Analysis Details', 0, 1);
$analysisOutput = $analysisTable->Get($subId);  //Obtain analysis details

// //Create a PDF table for sentiment analysis--------------------------------------------------------
$width_cell = array(15, 30, 40, 115, 30);                                    //Array for column size
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(253, 30, 50);                                            //Set background colour

$pdf->Cell($width_cell[0], 10, 'No.', 1, 0, 'C', true);                     //Set header
// $pdf->Cell($width_cell[4], 10, 'Type', 1, 0, 'C', true);
$pdf->Cell($width_cell[3], 10, 'Summary', 1, 0, 'C', true);
$pdf->Cell($width_cell[1], 10, 'Score', 1, 0, 'C', true);
$pdf->Cell($width_cell[1], 10, 'Magnitude', 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 10);
$pdf->SetFillColor(235, 236, 236);                                          //Header background colour;
$fill = false;

for ($i = 0; $i < count($analysisOutput); $i++) {                                               //Each record is one row
    $pdf->Cell($width_cell[0], 12, ($i + 1), 0, 0, 'C', $fill);
    //$pdf->Cell($width_cell[4], 12, ($analysisOutput[$i]->getType()), 0, 0, 'C', $fill);
    $pdf->Cell($width_cell[3], 12, ($analysisOutput[$i]->getSummary()), 0, 0, 'L', $fill);
    $pdf->Cell($width_cell[1], 12, ($analysisOutput[$i]->getSentimentScore()), 0, 0, 'C', $fill);
    $pdf->Cell($width_cell[1], 12, ($analysisOutput[$i]->getSentimentMagnitude()), 0, 1, 'C', $fill);

    $fill = !$fill;
}

// //Entity analysis information-------------------------------------------------------------------------------
$pdf->SetFont('Arial', 'B', 12);                          //Change font size
$pdf->Cell(0, 10, '', 0, 1);
$pdf->Cell(0, 10, 'Entity Details', 0, 1);

$entityOutput = $entityTable->get($subId);     //Obtain entity details

//Create a PDF table for entity analysis-----------------------------------------------------------
$width_cell = array(15, 50, 40, 85, 30);                                    //Array for column size
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(253, 30, 50);                                            //Set background colour

$pdf->Cell($width_cell[0], 10, 'No.', 1, 0, 'C', true);                     //Set header
$pdf->Cell($width_cell[1], 10, 'Entity name', 1, 0, 'C', true);
$pdf->Cell($width_cell[2], 10, 'Salience score', 1, 0, 'C', true);
$pdf->Cell($width_cell[3], 10, 'Wikipedia link', 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 10);
$pdf->SetFillColor(235, 236, 236);                                          //Header background colour;
$fill = false;

for ($i = 0; $i < count($entityOutput); $i++) {                                               //Each record is one row
    $pdf->Cell($width_cell[0], 12, ($i + 1), 0, 0, 'C', $fill);
    $pdf->Cell($width_cell[1], 12, ($entityOutput[$i]->getName()), 0, 0, 'L', $fill);
    $pdf->Cell($width_cell[2], 12, ($entityOutput[$i]->getSalience()), 0, 0, 'C', $fill);

    //Display link dependending on the availability of the link from database
    if (!empty($entityOutput[$i]->getLink())) {
        $link = $entityOutput[$i]->getLink();
        $pdf->Cell($width_cell[3], 12, "Available (Click here)", 0, 1, 'L', $fill, $link);
    } else {
        $pdf->Cell($width_cell[3], 12, "None", 0, 1, 'L', $fill);
    }
    $fill = !$fill;
}

//Add description of score, salience, magnitude-------------------------------------------------------------
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 10, '', 0, 1);
$pdf->Cell(0, 2, 'Score - Indicates the emotional leaning of the message. Negative value for negative message, 0 for Neutral Message', 0, 1);
$pdf->Cell(0, 10, 'Positive message are above 0.', 0, 1);
$pdf->Cell(0, 10, 'Salience - Importance of the entity within the document. The higher the score, the more salient the entity.', 0, 1);
$pdf->Cell(0, 10, 'Magnitude - The strength of the emotion, the higher the score the stronger the emotion.', 0, 1);

//Add a new page
$pdf->AddPage();

//Add reference list---------------------------------------------------------------------------
$pdf->SetFont('Arial', 'B', 12);                          //Change font size
$pdf->Cell(0, 10, '', 0, 1);
$pdf->Cell(0, 10, 'References ', 0, 1);

$pdf->SetFont('Arial', '', 10);                          //Change font size
$referenceOutput = $referenceTable->get($subId);

$result = $referenceOutput[0]->getText();
$formatted_result = str_replace("<br />", "", $result);
$pdf->Write(5, $formatted_result);

//Add a new page
$pdf->AddPage();

//Add the web search results-------------------------------------------------------------------
$pdf->SetFont('Arial', 'B', 12);                          //Change font size
$pdf->Cell(0, 10, 'Web search results', 0, 1);
$webSearchOutput = $webSearchTable->GetAll($subId);

$pdf->SetFont('Arial', '', 10);                          //Change font size

// for ($i = 0; $i < count($webSearchOutput); $i++) {
//     echo "<p>" . stringFormat($webSearchOutput[$i]['description']) . "</p>";
// }

$strlength = "";
for ($i = 0; $i < 100; $i++) {
    $strlength = $strlength . "a";
}

for ($i = 0; $i < count($webSearchOutput); $i++) {
    $pdf->Cell(0, 10, $i + 1 . '. ' . stringFormat($webSearchOutput[$i]['title'], 105), 0, 1, 'L', $fill);
    $pdf->Cell(0, 10, 'Description: ' . stringFormat($webSearchOutput[$i]['description'], 100), 0, 1);
    $pdf->Cell(0, 10, 'Author(s): ' . stringFormat($webSearchOutput[$i]['authors'], 100), 0, 1);
    $pdf->Cell(0, 10, "Link: Available (Click here)", 0, 1, '', false, $webSearchOutput[$i]['link']);
}


//Return the generated output-------------------------------------------------------------------------------
$pdf->Output();
