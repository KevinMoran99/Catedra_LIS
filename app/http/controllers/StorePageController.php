<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 23/3/2018
 * Time: 2:45 PM
 */

namespace Http\Controllers;
use Http\Models as Model;
use Http\Helpers as Helper;


class StorePageController
{
    public function getAllPages () {
        $page = new Model\StorePage();
        return $page->getAll();
    }

    public function getTop3Pages () {
        $page = new Model\StorePage();
        return $page->getAll(true);
    }

    public function getAllPagesPublic () {
        $page = new Model\StorePage();
        return $page->getAll(true);
    }

    public function getPagesByGame ($id, $ajax) {
        $game = new Model\Game();
        $game->setId($id);
        $game->getById();
        $page = new Model\StorePage();
        if($ajax) {
            echo json_encode($page->getByGame($game, true));
        }
        else {
            return $page->getByGame($game, true);
        }
    }

    public function getPage ($id, $ajax) {
        //nuevo objeto de generos
        $page = new Model\StorePage();
        //llenamos el objeto con los datos proporcionados
        $page->setId($id);
        $page->getById();
        //si es una request ajax retorna un json con los datos
        if($ajax) {
            echo json_encode($page);
        }else{
            //si no es ajax, retorna un objeto
            return $page;
        }
    }

    public function addPage ($game, $releaseDate, $visible, $price, $discount){
        //instancia
        $validator = new Helper\Validator();
        $page = new Model\StorePage();
        //variables de validacion
        $flag = false;
        $validateError= "";
        //validamos que la fecha sea valida
        if (!$validator->validateDate($releaseDate)) {
            $validateError = "La fecha ingresada no es válida";
            $flag = true;
        }

        //validamos
        if(!$flag) {
            $gameM = new Model\Game();
            $gameM->setId($game);
            $gameM->getById();
            $page->setGame($gameM);
            $page->setReleaseDate(new \DateTime($releaseDate));
            $page->setVisible($visible);
            $page->setPrice($price);
            $page->setDiscount($discount);
            $response = $page->insert();

            //mostramos mensaje de error
            if(is_bool($response)){
                Helper\Component::showMessage(Helper\Component::$SUCCESS, "Página de juego añadida");
            }else{
                Helper\Component::showMessage(Helper\Component::$WARNING, $response);
            }
        }else{
            Helper\Component::showMessage(Helper\Component::$ERROR,$validateError);
        }
    }

    public function updatePage ($id, $game, $releaseDate, $visible, $price, $discount){
        //instancia
        $validator = new Helper\Validator();
        $page = new Model\StorePage();
        //variables de validacion
        $flag = false;
        $validateError= "";
        //validamos que la fecha sea valida
        if (!$validator->validateDate($releaseDate)) {
            $validateError = "La fecha ingresada no es válida";
            $flag = true;
        }

        //validamos
        if(!$flag) {
            $page->setId($id);
            $gameM = new Model\Game();
            $gameM->setId($game);
            $gameM->getById();
            $page->setGame($gameM);
            $page->setReleaseDate(new \DateTime($releaseDate));
            $page->setVisible($visible);
            $page->setPrice($price);
            $page->setDiscount($discount);
            $response = $page->update();

            //mostramos mensaje de error
            if(is_bool($response)){
                Helper\Component::showMessage(Helper\Component::$SUCCESS, "Página de juego modificada");
            }else{
                Helper\Component::showMessage(Helper\Component::$WARNING, $response);
            }
        }else{
            Helper\Component::showMessage(Helper\Component::$ERROR,$validateError);
        }
    }
}

try {
    if (isset($_POST["method"])) {
        //incluimos la clase autoload para poder utilizar los namespaces
        include_once("../../../vendor/autoload.php");
        if ($_POST["method"] == "addPage") {
            //creamos un nuevo registro con los datos del array
            (new StorePageController())->addPage($_POST['game'],$_POST['release_date'],$_POST['visible'],$_POST['price'],$_POST['discount']);

        }

        if ($_POST["method"] == "getPage") {
            //obtenemos el registro

            (new StorePageController())->getPage($_POST["id"], true);
        }

        if ($_POST["method"] == "getPagesByGame") {
            //obtenemos el registro

            (new StorePageController())->getPagesByGame($_POST["game"], true);
        }

        if($_POST["method"] == "updatePage"){
            //actualizamos el registro. Si no se establecio otra imagen, no se toma en cuenta ese campo

            (new StorePageController())->updatePage($_POST['id'], $_POST['game'],$_POST['release_date'],$_POST['visible'],$_POST['price'],$_POST['discount']);

        }

        /*if($_POST["method"] == "searchStorePage"){
            (new StorePageController())->searchStorePage($_POST["param"],true);
        }*/
    }
}
catch (\Exception $error) {
    Helper\Component::showMessage(Helper\Component::$ERROR, $error->getMessage());
}