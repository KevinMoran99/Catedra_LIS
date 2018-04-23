<?php
/**
 * Created by PhpStorm.
 * User: oscar
 * Date: 18/04/2018
 * Time: 21:46
 */
include_once("../../../../vendor/autoload.php");
use Http\Helpers as Helper;
use Http\Controllers as Controller;

/*inicio de campos obligatorios*/
//estableciendo zona horaria del El salvador !!!IMPORTANTE
date_default_timezone_set("America/El_Salvador");

$bill = new Controller\BillController();
$bill = $bill->getBillForClient($_POST["id"],false);

$pdf = new Helper\StandardPdf("P","mm","Letter");
//establecemos el titulo del PDF !!!!IMPORTANTE
$pdf->setHeaderText("Factura No. " . $_POST["id"]);
$pdf->AliasNbPages();
//agregamos la pagina inicial
$pdf->AddPage();
//establecemos los margenes(en mm so 10mm = 1cm)
$pdf->setMargins(10,10,10);
//establecemos que se generen nuevas paginas automaticamente de ser necesario
$pdf->SetAutoPageBreak(true,10);
//establecemos fuente del contenido
$pdf->SetFont('Arial','',16);
/*Fin campos obligatorios*/


if($bill == null){
    $pdf->Cell(50);
    $pdf->Cell(0,10,'La factura no existe',0,1);
}else{
        
    //estableciendo color con el que se llenara el cell
    $pdf->SetFillColor(53, 234, 188);
    //estableciendo el color de los bordes del cell
    $pdf->SetDrawColor(53, 234, 188);
    
    $pdf->Cell(190, 10, "Usuario: " . $bill->getUser()->getAlias(), 0, 1, "C");
    $pdf->Cell(190, 10, "Fecha: " . $bill->getBillDate()->format('d/m/Y'), 0, 1, "C");
    $pdf->Ln(5);

    $pdf->SetFont('Arial','',12);
    //variable contador de valor total
    $sum = 0.00;
    //estableciendo el color de texto negro de nuevo
    $pdf->SetTextColor(0, 0, 0);
    
    foreach ($bill->getItems() as $i) {
        //Imprimiendo juegos
        $subtotal = $i->getStorePage()->getPrice() - ($i->getStorePage()->getPrice() * $i->getStorePage()->getDiscount() / 100);
        $sum += $subtotal;

        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(190, 10, "", 1, 0, "L", true);
        //cell hack para poder imprimir sobre el cell anterior
        $pdf->Cell(0, 0, "", 0, 1, "L");
        $pdf->MultiCell(190, 10, $i->getStorePage()->getGame()->getName(), 1);

        $pdf->SetTextColor(33, 150, 243);
        $pdf->Cell(10);
        $pdf->Cell(60, 10, "Key", 0, 0, "L");
        $pdf->Cell(10);
        $pdf->Cell(30, 10, "Precio", 0, 0, "L");
        $pdf->Cell(10);
        $pdf->Cell(30, 10, "Descuento", 0, 0, "L");
        $pdf->Cell(10);
        $pdf->Cell(30, 10, "Subtotal", 0, 1, "L");

        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(10);
        $pdf->Cell(60, 10, $i->getGameKey(), 0, 0, "L");
        $pdf->Cell(10);
        $pdf->Cell(30, 10, "$" . $i->getStorePage()->getPrice(), 0, 0, "L");
        $pdf->Cell(10);
        $pdf->Cell(30, 10, "-" . $i->getStorePage()->getDiscount() . "%", 0, 0, "L");
        $pdf->Cell(10);
        $pdf->Cell(30, 10, "$" . number_format($subtotal,2), 0, 1, "L");
        
    }
    //estableciendo color de texto
    $pdf->SetTextColor(53, 234, 188);
    $pdf->SetFont('Arial','',18);
    $pdf->Ln(5);
    $pdf->Cell(190, 10, "Total: $".number_format($sum,2), 0, 1, "R");
    $pdf->Ln(5);
    //estableciendo color de texto a negro de nuevo
    $pdf->SetTextColor(0, 0, 0);
        

    //imprimiendo <3
    $pdf->Output( "I" ,"report.pdf",true);
}
?>