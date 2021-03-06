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
use ColorThief\ColorThief as ColorHeleper;


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
    public function getDiscountGames(){
        $game= new Model\StorePage();
        return $game->getDiscountGames();

    }
    public function getTop10Games(){
        $Top= new Model\StorePage();
        return $Top->getTop10Games();
    }

    public function getPage ($id, $ajax, $cart = false) {
        $flag = false;
        $validateError = "";

        //nuevo objeto de generos
        $page = new Model\StorePage();
        //llenamos el objeto con los datos proporcionados
        $page->setId($id);
        $page->getById();
        $dominantColor = ColorHeleper::getColor(substr($page->getGame()->getBanner(),$cart ? 0 : 3));
        $page->setDominantColor($dominantColor);
        //Validando ids invalidos
        if(is_null($page->getId())) {
            $flag = true;
            $validateError = "ID desconocido. Por favor, deje de intentar hackearnos :C";
        }

        if (!$flag) {
            //si es una request ajax retorna un json con los datos
            if ($ajax) {
                echo json_encode($page);
            } else {
                //si no es ajax, retorna un objeto
                return $page;
            }
        }
        else {
            Helper\Component::showMessage(Helper\Component::$ERROR,$validateError);
            return "Invalid";
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

    public function updatePage ($id, $releaseDate, $visible, $price, $discount){
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
            $page->getById();
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

    public function searchPage ($searchType, $param) {
        $page = new Model\StorePage();

        switch ($searchType) {
            case "game":
                return $page->search($param, Model\StorePage::$GAME);
                break;
            case "publisher":
                return $page->search($param, Model\StorePage::$PUBLISHER);
                break;
            case "genre":
                return $page->search($param, Model\StorePage::$GENRE);
                break;
            case "esrb":
                return $page->search($param, Model\StorePage::$ESRB);
                break;
            case "seller":
                return $page->search("", Model\StorePage::$SELLER);
                break;
            case "rating":
                return $page->search("", Model\StorePage::$RATING);
                break;
            case "date":
                return $page->search("", Model\StorePage::$DATE);
                break;
            case "offer":
                return $page->search("", Model\StorePage::$OFFER);
                break;
        }
    }

    //Información de gráfica lineal
    public function getLinePage($year, $game_id) {
        echo json_encode((new Model\StorePage())->getLineChartInfo($year, $game_id));
    }

    //Información de gráfica de radar
    public function getRadarPage($game_id) {
        echo json_encode((new Model\StorePage())->getRadarChartInfo($game_id));
    }
}

try {
    if (isset($_POST["method"])) {
        //incluimos la clase autoload para poder utilizar los namespaces
        include_once("../../../vendor/autoload.php");
        $val = new Helper\Validator();
        if ($_POST["method"] == "addPage") {
            $_POST = $val->validateForm($_POST);
            //creamos un nuevo registro con los datos del array
            (new StorePageController())->addPage($_POST['game'],$_POST['release_date'],$_POST['visible'],$_POST['price'],$_POST['discount']);

        }

        if ($_POST["method"] == "getPage") {
            $_POST = $val->validateForm($_POST);
            //obtenemos el registro

            (new StorePageController())->getPage($_POST["id"], true, true);
        }

        if ($_POST["method"] == "getPagesByGame") {
            $_POST = $val->validateForm($_POST);
            //obtenemos el registro

            (new StorePageController())->getPagesByGame($_POST["game"], true);
        }

        if($_POST["method"] == "updatePage"){
            $_POST = $val->validateForm($_POST);
            //actualizamos el registro. Si no se establecio otra imagen, no se toma en cuenta ese campo

            (new StorePageController())->updatePage($_POST['id'],$_POST['release_date'],$_POST['visible'],$_POST['price'],$_POST['discount']);

        }

        if($_POST["method"] == "searchPage"){
            $_POST = $val->validateForm($_POST);
            //actualizamos el registro. Si no se establecio otra imagen, no se toma en cuenta ese campo

            (new StorePageController())->searchPage($_POST['searchType'],$_POST['param']);

        }

        if ($_POST["method"] == "getLinePage") {
            $_POST = $val->validateForm($_POST);
            //obtenemos los datos
            (new StorePageController())->getLinePage($_POST["year"], $_POST["game"]);
        }

        if ($_POST["method"] == "getRadarPage") {
            $_POST = $val->validateForm($_POST);
            //obtenemos los datos
            (new StorePageController())->getRadarPage($_POST["game"]);
        }

        /*if($_POST["method"] == "searchStorePage"){
            (new StorePageController())->searchStorePage($_POST["param"],true);
        }*/
    }
}
catch (\Exception $error) {
    Helper\Component::showMessage(Helper\Component::$ERROR, $error->getMessage());
}