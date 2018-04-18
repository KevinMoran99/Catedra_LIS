<?php
/**
 * Created by PhpStorm.
 * User: ara
 * Date: 4/18/18
 * Time: 11:00 a.m.
 */
include_once("../../../../vendor/autoload.php");
use Http\Helpers as Helper;
use Http\Controllers as Controller;
/*inicio de campos obligatorios*/

//estableciendo zona horaria del El salvador !!!IMPORTANTE
date_default_timezone_set("America/El_Salvador");


$pdf = new Helper\StandardPdf("P","mm","A4");
//establecemos el titulo del PDF !!!!IMPORTANTE
$pdf->setHeaderText("Clientes baneados del sistema");
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

$users = new Controller\UserController();
$list = $users->getAllInactiveUsers();

if(sizeof($list)<1){
    $pdf->Cell(50);
    $pdf->Cell(0,10,'No hay usuarios deshabilitados por el momento',0,1);
}else{
    //Bloque de header de datos
    $pdf->SetTextColor(107,90,250);
    $pdf->Cell(5);
    $pdf->Cell(30,11,'Alias',0,0,"L");
    $pdf->Cell(25);
    $pdf->Cell(30,10,'Correo',0,0,"L");
    $pdf->Cell(45);
    $pdf->Cell(30,10,'Monto invertido',0,1,"L");
    $pdf->SetTextColor(0,0,0);
    $pdf->SetDrawColor(53, 234, 188);
    //linea divisoria
    $pdf->Line(10, 55, 210-10, 55);
    $pdf->Ln(10);
    /* Contenido de PDF*/
    foreach ($list as $item) {

        $pdf->Cell(5);
        $pdf->Cell(30,11,$item->getAlias(),0,0,"L");
        $pdf->Cell(25);
        $pdf->Cell(30,10,$item->getEmail(),0,0,"L");
        $pdf->Cell(45);
        $pdf->Cell(30,10,'Monto invertido',0,1,"L");
    }
}


//imprimiendo <3
$pdf->Output( "I" ,"report.pdf",true);
?>