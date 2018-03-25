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

    //Obtiene como parametro un array con los ids de todas las store_pages incluidas en la factura
    public function addBill($pageArray) {
        session_start();

        $bill = new Model\Bill();
        $bill->setUser($_SESSION['user']);
        $bill->setBillDate(new \DateTime());
        $response = $bill->insert();
        $id = $bill->getLastId();
        $bill->setId($id);
        //mostramos mensaje de error
        if(is_bool($response)){
            $flag = true;
            //Añadiendo los items de la factura
            foreach ($pageArray as $pageId) {

                $item = new Model\BillItem();
                $item->setBill($bill);
                    $page = new Model\StorePage();
                    $page->setId($pageId);
                    $page->getById();
                $item->setStorePage($page);
                $itemResponse = $item->insert();

                if (!is_bool($itemResponse)) {
                    $flag = false;
                }
            }
            //Si no ocurrieron errores, devuelve un string conteniendo el json de la factura generada
            if ($flag) {
                $bill->getById();
                Helper\Component::showMessage(Helper\Component::$SUCCESS, json_encode($bill));
            }
            else {
                Helper\Component::showMessage(Helper\Component::$ERROR, "Ocurrió un error al procesar la factura");
            }
        }else{
            Helper\Component::showMessage(Helper\Component::$WARNING, $response);
        }
    }
}

try {
    if (isset($_POST["method"])) {
        //incluimos la clase autoload para poder utilizar los namespaces
        include_once("../../../vendor/autoload.php");
        if ($_POST["method"] == "addBill") {
            //PARA HACER EL INSERT DE LA FACTURA, ENVIAR UN STRING CONTENIENDO LOS IDS DE TODAS LAS
            //STORE PAGES A COMPRAR, DELIMITADOS POR UNA COMA
            $array = explode(",", $_POST['store_pages']);
            (new BillController())->addBill($array);
        }

        else if ($_POST["method"] == "getBill") {
            //obtenemos el registro
            (new BillController())->getBill($_POST["id"], true);
        }

        else if ($_POST["method"] == "getBillsByUser") {
            //obtenemos el registro
            (new BillController())->getBillsByUser($_POST["user_id"], true);
        }
    }
}
catch (\Exception $error) {
    Helper\Component::showMessage(Helper\Component::$ERROR, $error->getMessage());
}