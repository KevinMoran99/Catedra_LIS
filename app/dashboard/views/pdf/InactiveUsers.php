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
session_start();
if(!isset($_SESSION['user'])){
    header("Location:../../index.php");
}
//estableciendo zona horaria del El salvador !!!IMPORTANTE
date_default_timezone_set("America/El_Salvador");


$pdf = new Helper\StandardPdf("P","mm","Letter");
//establecemos el titulo del PDF !!!!IMPORTANTE
$pdf->setHeaderText("Clientes baneados del sistema");
$pdf->setUser($_SESSION['user']->getAlias());
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
        //obteniendo todos las facturas de usuario
        $bills = new Controller\BillController();
        $bill = $bills->getBillsByUser($item->getId(),false);
        $sum = 0.00;
        foreach($bill as $b){
            //obteniendo todos los items de factura de usuario
            $bItems = $b->getItems();
            //sumatoria de precios
            foreach($bItems as $i){
                $sum += $i->getPrice();
            }
        }
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
        $pdf->Cell(30,11,$item->getAlias(),0,0,"L");
        $pdf->Cell(25);
        $pdf->Cell(30,10,$item->getEmail(),0,0,"L");
        $pdf->Cell(45);
        $pdf->Cell(30,10,'$'.$sum,0,1,"L");
        $pdf->Ln(5);
        //estableciendo el color de texto a negro de nuevo
        $pdf->SetTextColor(0,0,0);
    }
}


//imprimiendo <3
$pdf->Output( "I" ,"report.pdf",true);
?>