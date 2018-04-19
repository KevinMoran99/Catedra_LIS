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


$pdf = new Helper\StandardPdf("P","mm","A4");
//establecemos el titulo del PDF !!!!IMPORTANTE
$pdf->setHeaderText("Juegos obtenidos por usuario");
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
$selected_user = $_GET['user'];
}catch (\Exception $e){
    $selected_user = 0;
}
$users = new Controller\UserController();
$user = $users->getUser($selected_user,false);
if($selected_user != 0){
if($user == null){
    $pdf->Cell(50);
    $pdf->Cell(0,10,'El usuario no existe',0,1);
}else{
        //Validando si es un usuario cliente
        if($user->getUserType()->getId() == 2) {
            //estableciendo color de texto de primera linea
            $pdf->SetTextColor(255, 255, 255);
            //estableciendo color con el que se llenara el cell
            $pdf->SetFillColor(53, 234, 188);
            //estableciendo el color de los bordes del cell
            $pdf->SetDrawColor(53, 234, 188);
            //cell container
            $pdf->Cell(190, 10, "", 1, 0, "L", true);
            //cell hack para poder imprimir sobre el cell anterior
            $pdf->Cell(0, 0, "", 0, 1, "L");
            //comienzo de datos de pdf
            $pdf->Cell(5);
            $pdf->Cell(30, 11, $user->getAlias(), 0, 1, "L");
            //obteniendo todos las facturas de usuario
            $bills = new Controller\BillController();
            $bill = $bills->getBillsByUser($user->getId(), false);
            //variable contador de valor total
            $sum = 0.00;
            //estableciendo el color de texto negro de nuevo
            $pdf->SetTextColor(0, 0, 0);
            //arrar para evitar juegos duplicados
            $lastGame = [];
            foreach ($bill as $b) {
                //obteniendo todos los items de factura de usuario
                $bItems = $b->getItems();
                foreach ($bItems as $i) {
                    //si el; juego no existe en el array, imprimirlo
                    if (!in_array($i->getStorePage()->getGame()->getName(),$lastGame)) {
                        $sum += $i->getPrice();
                        $pdf->Cell(30, 10, $i->getStorePage()->getGame()->getName(), 0, 0, "L");
                        $pdf->Cell(110);
                        $pdf->Cell(30, 10, "Obtenido en: ".$b->getBillDate()->format('d-m-Y'), 0, 1, "L");
                    }
                    //enviando juego al array
                    array_push($lastGame,$i->getStorePage()->getGame()->getName());
                }
            }
            //estableciendo color de texto
            $pdf->SetTextColor(53, 234, 188);
            $pdf->Cell(30, 10, "Valor de cuenta: $".$sum, 0, 1, "L");
            $pdf->Ln(5);
            //estableciendo color de texto a negro de nuevo
            $pdf->SetTextColor(0, 0, 0);
        }else{
            $pdf->Cell(50);
            $pdf->Cell(0,10,'Este usuario no es elegible para compras',0,1);
        }
}


//imprimiendo <3
$pdf->Output( "I" ,"report.pdf",true);
}else{
    header("Location:../../login.php");
    die();
}
?>