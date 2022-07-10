<?php

require('../FPDF/fpdf.php');

class MyPDF extends FPDF {
    //Page Header
    function header() {
        //Font
        $this->SetFont('Arial', 'B', 15);
        
        //Title
        //$this->Cell(30, 10, 'Title', 1, 0, C);

        //Line break
        $this->Ln(20);
    }

    //Page Footer
    function footer() {
        //Position at the bottom
        $this->SetY(-15);

        //Font
        $this->SetFont('Arial', 'I', 8);

        //Page numbering
        $this->Cell(0, 10, 'Page'.$this->PageNo().'/{nb}', 0, 0, 'C');
    }
}

?>