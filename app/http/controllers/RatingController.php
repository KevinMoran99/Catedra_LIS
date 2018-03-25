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
        return $favorable * 100 / $total;
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
}

try {
    if (isset($_POST["method"])) {
        //incluimos la clase autoload para poder utilizar los namespaces
        include_once("../../../vendor/autoload.php");
        if ($_POST["method"] == "addRating") {
            (new RatingController())->addRating($_POST['bill_item'], $_POST['recommended'], $_POST['description']);
        }

        else if ($_POST["method"] == "updateRating") {
            (new RatingController())->updateRating($_POST['id'], $_POST['recommended'], $_POST['description']);
        }

        else if ($_POST["method"] == "getRating") {
            //obtenemos el registro
            (new RatingController())->getRating($_POST["id"], true);
        }

        else if ($_POST["method"] == "getRatingByPage") {
            //obtenemos el registro
            (new RatingController())->getRatingsByPage($_POST["store_page"], true);
        }

        else if ($_POST["method"] == "getFavorableByPage") {
            //obtenemos el registro
            (new RatingController())->getFavorableByPage($_POST["store_page"]);
        }
    }
}
catch (\Exception $error) {
    Helper\Component::showMessage(Helper\Component::$ERROR, $error->getMessage());
}