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
    //variable que almacena el texto del header
    private $text;

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setHeaderText($text)
    {
        $this->text = $text;
    }


    //Declarando header del pdf
    function Header()
    {
        //estableciendo imagen
        $this->image('../../../web/img/logo.png', 12, 10, 20, 20);
        //estableciendo fuente
        $this->setFont('Arial', 'B', 15);
        //espaciado
        $this->Cell(75);
        //Titulo del pdf
        $this->Cell(30, 20, $this->getText(), 0, 0, "C");
        //espaciado
        $this->Cell(45);
        //estableciendo color para nombre de proyecto
        $this->SetTextColor(53, 234, 188);
        //estableciendo un nuevo tama;o de fuente
        $this->setFont('Arial', 'B', 20);
        //nombre del pryecto
        $this->Cell(30, 20, 'Sttom xD', 0, 0, "C");
        //volviendo a tama;o original de letra
        $this->setFont('Arial', 'B', 15);
        //volviendo a color original de letra
        $this->SetTextColor(0,0,0);
        //salto de linea
        $this->Ln(30);
        //linea divisoria
        $this->SetDrawColor(53, 234, 188);
        $this->Line(10, 35, 210-10, 35);
    }

    // Pie de página
    function Footer()
    {
        session_start();
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        //nos posicionamos al final de la fila y le restamos 20
        $this->SetX(-20);
        //estableciendo numero de pagina en dicha posicion
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
        //nos establecemos casi al principio de la fila
        $this->SetX(-355);
        //estableciendo hora y fecha al principio de la fila
        $this->Cell(0,10,date("d/m/Y")." ".date("h:i:sa"),0,0,"C");
        //estableciendonos al centro de la fila
        $this->SetX(0);
        //nombre de usuario
        $this->Cell(0,10,$_SESSION['user']->getAlias(),0,0,"C");
    }
}
