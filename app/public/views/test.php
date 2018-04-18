<?php
include_once ("../../../vendor/autoload.php");
use Http\Helpers as Helper;

$pdf = new Helper\StandardPdf("P","mm","A4");
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->setMargins(10,10,10);
$pdf->SetAutoPageBreak(true,10);
$pdf->SetFont('Times','',12);
for($i=1;$i<=40;$i++)
    $pdf->Cell(0,10,'Imprimiendo linea numero '.$i,0,1);


$pdf->Output( "D" ,"report.pdf",true);
?>