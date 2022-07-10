<?php 
include "../classes/fpdfHeader.php";
include "../classes/database.php";

//Connect to database


//Instantiate and use the FPDF class
$pdf = new FPDF();
$pdf->AliasNbPages();

//Add page title and author
$pdf->SetAuthor('SEP=28');
$pdf->SetTitle('Analysis Report | Document Submission System');

//Add a new page
$pdf->AddPage();

//Add an image
//$image1 = "src/image/logo.png";
//$pdf->Image($image1, 10, 8, 33);

//Set the font
$pdf->SetFont('Arial', 'B', '18');

//Add page heading
$pdf->SetXY(50, 20);
$pdf->Cell(100, 10, 'Analysis Report', 1, 0, 'C', 0);

//Add content-----------------------------------Change this last
$pdf->SetXY(10, 50);
$pdf->SetFontSize(12);                          //Change font size
$pdf->Cell(0, 10, 'Student ID: ', 0, 1);
$pdf->Cell(0, 10, 'Student Name: ', 0, 1);
$pdf->Cell(0, 10, 'Course Code: ', 0, 1);
$pdf->Cell(0, 10, 'Document: ', 0, 1);

//Return the generated output
$pdf->Output();

//$db->closeConnection();

?>