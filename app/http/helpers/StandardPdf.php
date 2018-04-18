<?php
/**
 * Created by PhpStorm.
 * User: oscar
 * Date: 17/04/2018
 * Time: 20:24
 */

namespace Http\Helpers;
use \FPDF as PDF;
class StandardPdf extends PDF
{
    function Header()
    {
        $this->image('../../web/img/logo.png', 10, 10, 20, 20);
        $this->setFont('Arial', 'B', 15);
        $this->Cell(80);
        $this->Cell(30, 20, 'Reporte', 0, 0, "C");
        $this->Cell(40);
        $this->Cell(30, 20, 'Sttom xD', 1, 0, "C");
        $this->Ln(20);
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}