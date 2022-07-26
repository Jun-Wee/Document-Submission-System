<?php 
include "../classes/MyPDF.php";
include "../classes/database.php";
include "../classes/analysisTable.php";
include "../classes/entity.php";
include "../classes/entityTable.php";
include "../classes/submissionTable.php";
include "../classes/analysis.php";
include "../classes/submission.php";

//Connect to database
$db = new Database();
$submissionTable = new SubmissionTable($db);
$analysisTable = new AnalysisTable($db);
$entityTable = new EntityTable($db);

//Instantiate and use the FPDF class
$pdf = new MyPDF();
$pdf->AliasNbPages();

//Add page title and author
$pdf->SetAuthor('SEP=28');
$pdf->SetTitle('Analysis Report | Document Submission System');

//Add a new page
$pdf->AddPage();

//Add an image
$image1 = "../src/images/logo.png";
$pdf->Image($image1, 10, 8, 33);

//Set the font
$pdf->SetFont('Arial', 'B', '18');

//Add page heading
$pdf->SetXY(55, 20);
$pdf->Cell(100, 10, 'Analysis Report', 1, 0, 'C', 0);

//Add content-----------------------------------Change this last
$pdf->SetXY(10, 50);
$pdf->SetFontSize(12);                          //Change font size

//Document general information------------------------------------------------------------------------------
$submission = $submissionTable->getAll();       //Obtain submission details
//$submission = $submissiontable->get($subId);  //Obtain submission details
$pdf->Cell(0, 10, 'Student ID: ' . ($submission[0]->getstuId()), 0, 1);
$pdf->Cell(0, 10, 'Course Code: ' . ($submission[0]->getUnitCode()), 0, 1);
$pdf->Cell(0, 10, 'Document: ' . ($submission[0]->getFilePath()), 0, 1);

//Document analysis information-----------------------------------------------------------------------------
$subId = $submission[0]->getId();                  //Obtain submission ID
$analysisOutput = $analysisTable->getAll();     //Obtain analysis details
//analysisOutput = $analysisTable->get($subId)  //Obtain analysis details
$pdf->Cell(0, 10, 'Sentiment summary: ' . ($analysisOutput[0]->getSummary()), 0, 1);
$pdf->Cell(0, 10, 'Sentiment score: ' . ($analysisOutput[0]->getSentimentScore()), 0, 1);
$pdf->Cell(0, 10, 'Sentiment magnitude: ' . ($analysisOutput[0]->getSentimentMagnitude()), 0, 1);

$entityOutput = $entityTable->getAll();         //Obtain entity details
//$entityOutput = $entityTable->get($subId)     //Obtain entity details     //Make it a table
// for ($i = 0; $i < count($entityOutput); $i++) {
//     $pdf->Cell(0, 10, 'Entity: ' . ($entityOutput[$i]->getName()), 0, 1);
//     $pdf->Cell(0, 10, 'Salience: ' . ($entityOutput[$i]->getSalience()), 0, 1);
//     $pdf->Cell(0, 10, 'Source: ' . ($entityOutput[$i]->getLink()), 0, 1);
// }

//Create a PDF table for entity analysis
$width_cell = array(20, 60, 40, 70);                                        //Array for column size
$pdf->SetFont('Arial', 'B', 13);

$pdf->SetFillColor(193, 229, 252);                                          //Set background colour

$pdf->Cell($width_cell[0], 10, 'ID', 1, 0, 'C', true);                      //Set header 
$pdf->Cell($width_cell[1], 10, 'Entity name', 1, 0, 'C', true);
$pdf->Cell($width_cell[2], 10, 'Salience score', 1, 0, 'C', true);
$pdf->Cell($width_cell[3], 10, 'Wikipedia link', 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 12);
$pdf->SetFillColor(235, 236, 236);                                          //Header background colour;
$fill = false;

for ($i = 0; $i < count($entityOutput); $i++) {                             //Each record is one row
    $pdf->Cell($width_cell[0], 12, ($entityOutput[$i]->getEntityId()), 0, 0, 'C', $fill);
    $pdf->Cell($width_cell[1], 12, ($entityOutput[$i]->getName()), 0, 0, 'L', $fill);
    $pdf->Cell($width_cell[2], 12, ($entityOutput[$i]->getSalience()), 0, 0, 'C', $fill);
    $pdf->MultiCell($width_cell[3], 12, ($entityOutput[$i]->getLink()), 0, 1, 'L', !$fill);

    $fill = !$fill;
}

//Return the generated output-------------------------------------------------------------------------------
$pdf->Output();

?>