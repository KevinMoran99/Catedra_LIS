<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 23/3/2018
 * Time: 9:23 PM
 */

namespace Http\Controllers;
use Http\Models as Model;
use Http\Helpers as Helper;


class PageSpecController
{

    public function getSpecsByPage ($id, $ajax) {
        $page = new Model\StorePage();
        $page->setId($id);
        $page->getById();
        $pageSpec = new Model\PageSpec();
        //Si se llamó por ajax, devuelve un json, si no, devuelve el objeto
        if (empty($pageSpec->getByPage($page, true))) {
            return "Aún no se establecen especificaciones para este juego";
        }
        else if ($ajax) {
            echo json_encode($pageSpec->getByPage($page, true));
        }
        else {
            return $pageSpec->getByPage($page, true);
        }
    }

    public function getPageSpec ($id, $ajax) {
        //nuevo objeto de generos
        $pageSpec = new Model\PageSpec();
        //llenamos el objeto con los datos proporcionados
        $pageSpec->setId($id);
        $pageSpec->getById();
        //si es una request ajax retorna un json con los datos
        if($ajax) {
            echo json_encode($pageSpec);
        }else{
            //si no es ajax, retorna un objeto
            return $pageSpec;
        }
    }

    public function addPageSpec ($storePage, $spec)
    {
        //instancia
        $pageSpec = new Model\PageSpec();
        $storePageM = new Model\StorePage();
        $storePageM->setId($storePage);
        $storePageM->getById();
        $pageSpec->setStorePage($storePageM);
        $specM = new Model\Spec();
        $specM->setId($spec);
        $specM->getById();
        $pageSpec->setSpec($specM);
        $pageSpec->setState(1);

        $flag = false;
        $validateError = "";

        //validando valores repetidos
        if ($pageSpec->isRepeated()) {
            $flag = true;
            $validateError = "Dato duplicado, no se puede guardar";
        }

        if (!$flag) {
            $response = $pageSpec->insert();

            //mostramos mensaje de error
            if (is_bool($response)) {
                Helper\Component::showMessage(Helper\Component::$SUCCESS, "Especificación de juego añadida");
            } else {
                Helper\Component::showMessage(Helper\Component::$WARNING, $response);
            }
        }
        else {
            Helper\Component::showMessage(Helper\Component::$WARNING, $validateError);
        }

    }

    /*public function updatePageSpec ($id, $storePage, $spec, $state){
        //instancia
        $pageSpec = new Model\PageSpec();

        $pageSpec->setId($id);
        $storePageM = new Model\StorePage();
        $storePageM->setId($storePage);
        $storePageM->getById();
        $pageSpec->setStorePage($storePageM);
        $specM = new Model\Spec();
        $specM->setId($spec);
        $specM->getById();
        $pageSpec->setSpec($specM);
        $pageSpec->setState($state);
        $response = $pageSpec->update();

        //mostramos mensaje de error
        if(is_bool($response)){
            Helper\Component::showMessage(Helper\Component::$SUCCESS, "Especificación de juego modificada");
        }else{
            Helper\Component::showMessage(Helper\Component::$WARNING, $response);
        }
    }*/

    public function deletePageSpec ($id){
        //instancia
        $pageSpec = new Model\PageSpec();

        $pageSpec->setId($id);
        $response = $pageSpec->delete();

        //mostramos mensaje de error
        if(is_bool($response)){
            Helper\Component::showMessage(Helper\Component::$SUCCESS, "Especificación de juego elminada");
        }else{
            Helper\Component::showMessage(Helper\Component::$WARNING, $response);
        }
    }
}

try {
    if (isset($_POST["method"])) {
        //incluimos la clase autoload para poder utilizar los namespaces
        include_once("../../../vendor/autoload.php");
        $val = new Helper\Validator();
        if ($_POST["method"] == "addPageSpec") {
            $_POST = $val->validateForm($_POST);
            //creamos un nuevo registro con los datos del array
            (new PageSpecController())->addPageSpec($_POST['storePage'],$_POST['spec']);

        }

        if ($_POST["method"] == "getPageSpec") {
            $_POST = $val->validateForm($_POST);
            //obtenemos el registro

            (new PageSpecController())->getPageSpec($_POST["id"], true);
        }

        if ($_POST["method"] == "getSpecsByPage") {
            $_POST = $val->validateForm($_POST);
            //obtenemos el registro

            (new PageSpecController())->getSpecsByPage($_POST["storePage"], true);
        }

        /*if($_POST["method"] == "updatePageSpec"){
            //actualizamos el registro. Si no se establecio otra imagen, no se toma en cuenta ese campo

            (new PageSpecController())->updatePageSpec($_POST['id'], $_POST['storePage'],$_POST['spec'],$_POST['state']);

        }*/

        if($_POST["method"] == "deletePageSpec"){
            $_POST = $val->validateForm($_POST);
            //actualizamos el registro. Si no se establecio otra imagen, no se toma en cuenta ese campo

            (new PageSpecController())->deletePageSpec($_POST['id']);

        }
    }
}
catch (\Exception $error) {
    Helper\Component::showMessage(Helper\Component::$ERROR, $error->getMessage());
}