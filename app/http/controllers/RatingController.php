<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 24/3/2018
 * Time: 8:52 PM
 */

namespace Http\Controllers;
use Http\Models as Model;
use Http\Helpers as Helper;

class RatingController
{
    //Obtener todos los registros
    public function getAllRatings() {
        //creamos un nuevo objeto
        $rating = new Model\Rating();
        //retornamos todos los datos
        return $rating->getAll();
    }

    //OBTENER REGISTRO
    public function getRating($id, $ajax){
        //nuevo objeto de tipo de specs
        $rating = new Model\Rating();
        //llenamos el objeto con los datos proporcionados
        $rating->setId($id);
        $rating->getById();
        //si es una request ajax retorna un json con los datos
        if($ajax) {
            echo json_encode($rating);
        }else{
            //si no es ajax, retorna un objeto
            return $rating;
        }
    }

    public function getRatingsByPage ($page, $ajax) {
        $pageM = new Model\StorePage();
        $pageM->setId($page);
        $pageM->getById();

        $rating = new Model\Rating();

        if ($ajax) {
            echo json_encode($rating->getByPage($pageM));
        }
        else {
            return $rating->getByPage($pageM);
        }
    }
    public function getInactiveRatingsByPage($page) {
        $pageM = new Model\StorePage();
        $pageM->setId($page);
        $pageM->getById();

        $rating = new Model\Rating();

        return $rating->getByPageInactive($pageM);
    }
    public function getRatingsByPagePublic ($page, $ajax) {
        $pageM = new Model\StorePage();
        $pageM->setId($page);
        $pageM->getById();

        $rating = new Model\Rating();

        if ($ajax) {
            echo json_encode($rating->getByPage($pageM));
        }
        else {
            return $rating->getByPage($pageM,true);
        }
    }

    public function getFavorableByPage ($page) {
        $pageM = new Model\StorePage();
        $pageM->setId($page);
        $pageM->getById();

        $rating = new Model\Rating();

        $favorable = 0;
        $total = 0;

        foreach ($rating->getByPage($pageM) as $rating) {
            $total++;
            if ($rating->getRecommended() == 1) {
                $favorable++;
            }
        }

        if ($total == 0) {
            return "Aún no hay valoraciones de este juego";
        }
        return "El ". number_format($favorable * 100 / $total, 2) ."% de personas recomiendan este juego";
    }

    public function addRating ($billItem, $recommended, $description) {
        $validator = new Helper\Validator();
        $rating = new Model\Rating();

        $flag = false;
        $validateError = "";

        //Validaciones
        if (!$validator->validateText($description, 3, 500)) {
            $validateError = "Solo se permiten numeros, letras y signos de puntuación en el comentario";
            $flag = true;
        }

        $billItemM = new Model\BillItem();
        $billItemM->setId($billItem);
        $billItemM->getById();
        if (is_null($billItemM->getId())) {
            $validateError = "ID desconocido. Por favor, deje de intentar hackearnos :C";
            $flag = true;
        }

        //si en este punto el flag es falso, actualizar el registro
        if(!$flag){

            $rating->setBillItem($billItemM);
            $rating->setRecommended($recommended);
            $rating->setDescription($description);
            $rating->setReviewDate(new \DateTime());
            $response = $rating->insert();
            if (is_bool($response)) {
                Helper\Component::showMessage(Helper\Component::$SUCCESS, "Valoración añadida");
            }else {
                Helper\Component::showMessage(Helper\Component::$WARNING, $response);
            }
        }else{
            //si el flag es verdadero, enviar mensaje de error
            Helper\Component::showMessage(Helper\Component::$ERROR, $validateError);
        }
    }

    public function updateRating ($id, $recommended, $description) {
        $validator = new Helper\Validator();
        $rating = new Model\Rating();

        $flag = false;
        $validateError = "";

        //Validaciones
        if (!$validator->validateText($description, 3, 500)) {
            $validateError = "Solo se permiten numeros, letras y signos de puntuación en el comentario";
            $flag = true;
        }


        //si en este punto el flag es falso, actualizar el registro
        if(!$flag){
            $rating->setId($id);
            $rating->getById();
            $rating->setRecommended($recommended);
            $rating->setDescription($description);
            $rating->setReviewDate(new \DateTime());
            $response = $rating->update();
            if (is_bool($response)) {
                Helper\Component::showMessage(Helper\Component::$SUCCESS, "Valoración modificada");
            }else {
                Helper\Component::showMessage(Helper\Component::$WARNING, $response);
            }
        }else{
            //si el flag es verdadero, enviar mensaje de error
            Helper\Component::showMessage(Helper\Component::$ERROR, $validateError);
        }
    }

    public function updateRatingVisible ($id, $visible) {

        $rating = new Model\Rating();
        $rating->setId($id);
        $rating->getById();
        $rating->setVisible($visible);
        $response = $rating->update();
        if (is_bool($response)) {
            Helper\Component::showMessage(Helper\Component::$SUCCESS, "Valoración modificada");
        }else {
            Helper\Component::showMessage(Helper\Component::$WARNING, $response);
        }
    }

    public function searchRating ($param, $ajax) {
        //nuevo objeto de tipo de especificacion
        $rating = new Model\Rating();
        $data = $rating->search($param);
        //si es una request ajax retorna un json con los datos
        if($ajax) {
            echo json_encode($data);
        }else{
            //si no es ajax, retorna un objeto
            return $data;
        }
    }
}

try {
    if (isset($_POST["method"])) {
        //incluimos la clase autoload para poder utilizar los namespaces
        include_once("../../../vendor/autoload.php");
        $val = new Helper\Validator();
        if ($_POST["method"] == "addRating") {
            $_POST = $val->validateForm($_POST);
            (new RatingController())->addRating($_POST['bill_item_id'], $_POST['recommended'], $_POST['description']);
        }

        else if ($_POST["method"] == "updateRating") {
            $_POST = $val->validateForm($_POST);
            (new RatingController())->updateRating($_POST['id'], $_POST['recommended'], $_POST['description']);
        }

        else if ($_POST["method"] == "getRating") {
            $_POST = $val->validateForm($_POST);
            //obtenemos el registro
            (new RatingController())->getRating($_POST["id"], true);
        }

        else if ($_POST["method"] == "getRatingByPage") {
            $_POST = $val->validateForm($_POST);
            //obtenemos el registro
            (new RatingController())->getRatingsByPage($_POST["store_page"], true);
        }

        else if ($_POST["method"] == "getFavorableByPage") {
            $_POST = $val->validateForm($_POST);
            //obtenemos el registro
            (new RatingController())->getFavorableByPage($_POST["store_page"]);
        }

        else if ($_POST["method"] == "updateRatingVisible") {
            $_POST = $val->validateForm($_POST);
            //obtenemos el registro
            (new RatingController())->updateRatingVisible($_POST["id"],$_POST["visible"]);
        }

        else if ($_POST["method"] == "searchRating") {
            $_POST = $val->validateForm($_POST);
            //obtenemos el registro
            (new RatingController())->searchRating($_POST["param"],true);
        }
    }
}
catch (\Exception $error) {
    Helper\Component::showMessage(Helper\Component::$ERROR, $error->getMessage());
}