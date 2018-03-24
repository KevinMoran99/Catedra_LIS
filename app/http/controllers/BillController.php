<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 24/3/2018
 * Time: 12:55 PM
 */

namespace Http\Controllers;
use Http\Models as Model;
use Http\Helpers as Helper;

class BillController
{
    //Obtener todos los registros
    public function getAllBills() {
        //creamos un nuevo objeto
        $bill = new Model\Bill();
        //retornamos todos los datos
        return $bill->getAll();
    }

    //OBTENER REGISTRO
    public function getBill($id, $ajax){
        //nuevo objeto de tipo de specs
        $bill = new Model\Bill();
        //llenamos el objeto con los datos proporcionados
        $bill->setId($id);
        $bill->getById();
        //si es una request ajax retorna un json con los datos
        if($ajax) {
            echo json_encode($bill);
        }else{
            //si no es ajax, retorna un objeto
            return $bill;
        }
    }

    //Obtener todas las facturas de un usuario
    public function getBillsByUser($user, $ajax) {
        $userM = new Model\User();
        $userM->setId($user);
        $userM->getById();

        $bill = new Model\Bill();

        if ($ajax) {
            echo json_encode($bill->getByUser($userM));
        }
        else {
            return $bill->getByUser($userM);
        }

    }

    public function addBill() {
        session_start();

        $bill = new Model\Bill();
        $bill->setUser($_SESSION['user']);
        $bill->setBillDate(new \DateTime());
        $response = $bill->insert();
        //mostramos mensaje de error
        if(is_bool($response)){
            //No imprimir el mensaje de exito en el js, pues despues de agregar esto se deben agregar
            //tambien los bill_items. Mostrar swal de exito hasta que el ultimo bill_item haya sido
            //ingresado
            Helper\Component::showMessage(Helper\Component::$SUCCESS, "No imprimir esto");
        }else{
            Helper\Component::showMessage(Helper\Component::$WARNING, $response);
        }
        if (is_empty($bill->getLastId())) {

        }
    }
}