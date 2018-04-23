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


$pdf = new Helper\StandardPdf("P","mm","Letter");
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

try{
$selected_page = $_GET['page'];
}catch (\Exception $e){
    $selected_page=0;
}

if($selected_page != 0){
//obteniendo todos los reviews inactivos
$ratings = new Controller\RatingController();
$list = $ratings->getInactiveRatingsByPage($selected_page);
//validando que hayan registros
if(sizeof($list)<1){
    $pdf->Cell(50);
    $pdf->Cell(0,10,'No hay reviews deshabilitados por el momento',0,1);
}else{
    foreach ($list as $review){
        //Estableciendo texto en color blanco
        $pdf->SetTextColor(255,255,255);
        //estableciendo color con el que se llenara el cell row
        $pdf->SetFillColor(53, 234, 188);
        //estableciendo colores de bordes del cell row
        $pdf->SetDrawColor(53, 234, 188);
        //cell row
        $pdf->Cell(190,30,"",1,0,"L",true);
        //cell hack para poder escribir sobre el cell row
        $pdf->Cell(0,0,"",0,1,"L");
        //imprimiendo los datos del row
        $pdf->Cell(5);
        $pdf->Cell(30,11,$review->getBillItem()->getBill()->getUser()->getAlias(),0,1,"L");
        //estableciendo color de texto a negro de nuevo
        $pdf->SetTextColor(0,0,0);
        //estableciendo tama;o de fuente menor
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(5);
        $pdf->Cell(30,11,$review->getDescription(),0,1,"L");
        $pdf->Ln(10);
        $pdf->SetFont('Arial','',12);
    }
}



//imprimiendo <3
$pdf->Output( "I" ,"report.pdf",true);
}else{
    header("Location:../../login.php");
    die();
}
?>