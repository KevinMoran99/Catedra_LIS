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

    //Obtiene sus datos de la variable de sesion del carrito
    public function addBill() {
        session_start();

        //Array de ids de todas las storepages (individualmente) a añadir a la factura
        $pageArray = [];

        foreach ($_SESSION['cart'] as $item) {
            for ($i = 0; $i < $item[1]; $i++) {
                array_push($pageArray, $item[0]->getId());
            }
        }

        $flag1 = false;
        $validateError = "";

        //Validando ids pasados
        foreach ($pageArray as $pageId) {
            $page = new Model\StorePage();
            $page->setId($pageId);
            $page->getById();
            //Si no se devolvio nada de la base, dará error
            if(is_null($page->getId())) {
                $flag1 = true;
                $validateError = "ID desconocido. Por favor, deje de intentar hackearnos :C";
            }
        }

        if (!$flag1) {
            $bill = new Model\Bill();
            $bill->setUser($_SESSION['user']);
            $bill->setBillDate(new \DateTime());
            $response = $bill->insert();
            $id = $bill->getLastId();
            $bill->setId($id);
            //mostramos mensaje de error
            if(is_bool($response)){
                $flag = false;
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
                        $flag = true;
                    }
                }
                //Si no ocurrieron errores, devuelve un string conteniendo el json de la factura generada
                if (!$flag) {
                    //Vaciando carrito
                    $_SESSION['cart'] = [];

                    //Devolviendo objeto de factura
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
        else {
            Helper\Component::showMessage(Helper\Component::$ERROR, $validateError);
        }
    }
}

try {
    if (isset($_POST["method"])) {
        //incluimos la clase autoload para poder utilizar los namespaces
        include_once("../../../vendor/autoload.php");
        if ($_POST["method"] == "addBill") {
            (new BillController())->addBill();
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