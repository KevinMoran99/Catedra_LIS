<?php

include_once("../../../../vendor/autoload.php");
use Http\Helpers as Helper;
use Http\Controllers as Controller;
/*inicio de campos obligatorios*/

//estableciendo zona horaria del El salvador !!!IMPORTANTE
date_default_timezone_set("America/El_Salvador");


$pdf = new Helper\StandardPdf("P","mm","Letter");
//establecemos el titulo del PDF !!!!IMPORTANTE
$pdf->setHeaderText("Juegos con descuentos");
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

$dGames = new Controller\StorePageController();
$list = $dGames->getDiscountGames();

if(sizeof($list)<1){
    $pdf->Cell(50);
    $pdf->Cell(0,10,'no hay Juegos con descuento listados por el momento',0,1);
}else{
    //Bloque de header de datos
    $pdf->SetTextColor(107,90,250);
    $pdf->Cell(5);
    $pdf->Cell(30,11,'Nombre',0,0,"L");
    $pdf->Cell(25);
    $pdf->Cell(30,10,'Descuento',0,0,"L");
    $pdf->Cell(25);
    $pdf->Cell(30,10,'Fecha de salida',0,0,"L");
    $pdf->Cell(45);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetDrawColor(53, 234, 188);
    //linea divisora
    $pdf->Line(10, 55, 210-10, 55);
    $pdf->Ln(10);
    /* Contenido de PDF*/
    foreach ($list as $item) {
        //estableciendo el color de texto a blanco
        $pdf->SetTextColor(255,255,255);
        //color con el que se llenara el row
        $pdf->SetFillColor(53, 234, 188);
        //color del borde del cell que hara de container
        $pdf->SetDrawColor(53, 234, 188);
        //cell container
        $pdf->Cell(190,10,"",1,0,"L",true);
        //cell hack para poder imprimir sobre el container
        $pdf->Cell(0,0,"",0,1,"L");
        //contenido del row
        $pdf->Cell(5);
        $pdf->Cell(30,11,$item->getGame()->getName(),0,0,"L");
        $pdf->Cell(25);
        $pdf->Cell(30,10,$item->getDiscount()."%",0,0,"L");
        $pdf->Cell(25);
        $pdf->Cell(30,10,$item->getReleaseDate(),0,0,"L");
        $pdf->Cell(45);
        $pdf->Ln(15);
        //estableciendo el color de texto a negro de nuevo
        $pdf->SetTextColor(0,0,0);
    }
}


//imprimiendo <3
$pdf->Output( "I" ,"report.pdf",true);
?>