<?php
/**
 * Created by PhpStorm.
 * User: oscar
 * Date: 18/04/2018
 * Time: 20:45
 */
include_once("../../../../vendor/autoload.php");
use Http\Helpers as Helper;
use Http\Controllers as Controller;
/*inicio de campos obligatorios*/

//estableciendo zona horaria del El salvador !!!IMPORTANTE
date_default_timezone_set("America/El_Salvador");


$pdf = new Helper\StandardPdf("P","mm","A4");
//establecemos el titulo del PDF !!!!IMPORTANTE
$pdf->setHeaderText("Reviews baneados de la pagina");
$pdf->AliasNbPages();
//agregamos la pagina inicial
$pdf->AddPage();
//establecemos los margenes(en mm so 10mm = 1cm)
$pdf->setMargins(10,10,10);
//establecemos que se generen nuevas paginas automaticamente de ser necesario
$pdf->SetAutoPageBreak(true,10);
//establecemos fuente del contenido
$pdf->SetFont('Arial','',12);
/*Fin campos obligatorios*/




$ratings = new Controller\RatingController();
$list = $ratings->getInactiveRatingsByPage(5);
if(sizeof($list)<1){
    $pdf->Cell(50);
    $pdf->Cell(0,10,'No hay reviews deshabilitados por el momento',0,1);
}else{
    $index = 70;
    foreach ($list as $review){
        //Bloque de header de datos
        $pdf->SetTextColor(255,255,255);
        $pdf->SetFillColor(53, 234, 188);
        $pdf->SetDrawColor(53, 234, 188);
        $pdf->Cell(190,30,"",1,0,"L",true);
        $pdf->Cell(0,0,"",0,1,"L");
        $pdf->Cell(5);
        $pdf->Cell(30,11,$review->getBillItem()->getBill()->getUser()->getAlias(),0,1,"L");
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(5);
        $pdf->Cell(30,11,$review->getDescription(),0,1,"L");
        $pdf->Ln(10);
        $pdf->SetFont('Arial','',12);
        $index+=30;
    }
}



//imprimiendo <3
$pdf->Output( "I" ,"report.pdf",true);
?>