<?php
include_once("../../../../vendor/autoload.php");
use Http\Helpers as Helper;
/*inicio de campos obligatorios*/

//estableciendo zona horaria del El salvador !!!IMPORTANTE
date_default_timezone_set("America/El_Salvador");


$pdf = new Helper\StandardPdf("P","mm","A4");
//establecemos el titulo del PDF !!!!IMPORTANTE
$pdf->setHeaderText("Reporte de prueba");
$pdf->AliasNbPages();
//agregamos la pagina inicial
$pdf->AddPage();
//establecemos los margenes(en mm so 10mm = 1cm)
$pdf->setMargins(10,10,10);
//establecemos que se generen nuevas paginas automaticamente de ser necesario
$pdf->SetAutoPageBreak(true,10);
//establecemos fuente del contenido
$pdf->SetFont('Times','',12);
/*Fin campos obligatorios*/

/* Contenido de PDF*/
for($i=1;$i<=40;$i++)
    $pdf->Cell(0,10,'Imprimiendo linea numero '.$i,0,1);

//imprimiendo <3
$pdf->Output( "I" ,"report.pdf",true);
?>