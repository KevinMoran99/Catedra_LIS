<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 15/3/2018
 * Time: 1:35 AM
 */

namespace Http\Controllers;
//Namespaces necesarios
use Http\Models as Model;
use Http\Helpers as Helper;

class FaqController
{
    //Obtener todos los registros
    public function getAllFaqs(){
        //creamos un nuevo objeto
        $faq = new Model\Faq();
        //retornamos todos los datos
        return $faq->getAll();
    }

    //Obtener todos los registros activos
    public function getAllActiveFaqs(){
        //creamos un nuevo objeto
        $faq = new Model\Faq();
        //retornamos todos los datos
        return $faq->getAll(true);
    }

    //AGREGAR REGISTRO
    public function  addFaq($title,$description,$state){
        //creamos objetos de validacion y tipo de spec
        $validator = new Helper\Validator();
        $faq = new Model\Faq();
        //variables de validacion
        $flag = false;
        $validateError= "";
        //si no es alfanumerico, setear el flag a true y agregar mensaje de error
        if(!$validator->validateText($description,3,1000)){
            $validateError = "Solo se permiten numeros, letras y signos de puntuación en la respuesta";
            $flag = true;
        }
        if(!$validator->validateText($title,3,500)){
            $validateError = "Solo se permiten numeros, letras y signos de puntuación en la pregunta";
            $flag = true;
        }

        //si el flag sigue siendo falso en este punto, agrega un nuevo registro
        if(!$flag){
            session_start();

            //llenamos el objeto con los datos proporcionados
            $faq->setTitle($title);
            $faq->setDescription($description);
            $faq->setUser($_SESSION["user"]);
            $faq->setState($state);

            $response = $faq->insert(); //Si se hace el insert retornará true. Si no, retornará el código de la excepción mysql
            if (is_bool($response)) {
                Helper\Component::showMessage(Helper\Component::$SUCCESS, "FAQ añadida");
            }else {
                Helper\Component::showMessage(Helper\Component::$WARNING, $response);
            }
        }else{
            //si el flag es verdadero, muestra el mensaje de error de validacion
            Helper\Component::showMessage(Helper\Component::$ERROR,$validateError);
        }
    }

    //OBTENER REGISTRO
    public function getFaq($id, $ajax){
        //nuevo objeto de tipo de specs
        $faq = new Model\Faq();
        //llenamos el objeto con los datos proporcionados
        $faq->setId($id);
        $faq->getById();
        //si es una request ajax retorna un json con los datos
        if($ajax) {
            echo json_encode($faq);
        }else{
            //si no es ajax, retorna un objeto
            return $faq;
        }
    }

    //ACTUALIZAR REGISTRO
    public function updateFaq($id,$title,$description,$state){
        //objetos de validacion y tipo de spec
        $validator = new Helper\Validator();
        $faq = new Model\Faq();
        //variables de validacion
        $flag = false;
        $validateError="";

        //si no es alfanumerico, setear el flag a true y agregar mensaje de error
        if(!$validator->validateText($description,3,1000)){
            $validateError = "Solo se permiten numeros, letras y signos de puntuación en la respuesta";
            $flag = true;
        }
        if(!$validator->validateText($title,3,500)){
            $validateError = "Solo se permiten numeros, letras y signos de puntuación en la pregunta";
            $flag = true;
        }

        //si en este punto el flag es falso, actualizar el registro
        if(!$flag){
            $faq->setId($id);
            $faq->setTitle($title);
            $faq->setDescription($description);
            $faq->setState($state);
            $response = $faq->update();
            if (is_bool($response)) {
                Helper\Component::showMessage(Helper\Component::$SUCCESS, "FAQ actualizada");
            }else {
                Helper\Component::showMessage(Helper\Component::$WARNING, $response);
            }
        }else{
            //si el flag es verdadero, enviar mensaje de error
            Helper\Component::showMessage(Helper\Component::$ERROR, $validateError);
        }
    }


    public function searchFaq($name,$ajax){
        //nuevo objeto de tipo de especificacion
        $faq = new Model\Faq();
        $data = $faq->search($name);
        //si es una request ajax retorna un json con los datos
        if($ajax) {
            echo json_encode($data);
        }else{
            //si no es ajax, retorna un objeto
            return $data;
        }
    }

    public function searchActiveFaq($name,$ajax){
        //nuevo objeto de tipo de especificacion
        $faq = new Model\Faq();
        $data = $faq->searchActive($name);
        //si es una request ajax retorna un json con los datos
        if($ajax) {
            echo json_encode($data);
        }else{
            //si no es ajax, retorna un objeto
            return $data;
        }
    }
}


//Fuera de la clase handleamos las request y las enviamos a su respectivo metodo
try {
    if (isset($_POST["method"])) {
        //incluimos la clase autoload para poder utilizar los namespaces
        include_once("../../../vendor/autoload.php");
        $val = new Helper\Validator();
        if ($_POST["method"] == "addFaq") {
            $_POST = $val->validateForm($_POST);
            //creamos un nuevo registro con los datos del array
            (new FaqController())->addFaq($_POST['title'], $_POST['description'], $_POST['state']);
        }

        else if ($_POST["method"] == "getFaq") {
            $_POST = $val->validateForm($_POST);
            //obtenemos el registro
            (new FaqController())->getFaq($_POST["id"], true);
        }

        else if($_POST["method"] == "updateFaq"){
            $_POST = $val->validateForm($_POST);
            //actualizamos el registro con los datos del array
            (new FaqController())->updateFaq($_POST['id'],$_POST['title'], $_POST['description'],$_POST['state']);
        }

        else if($_POST["method"] == "searchFaq"){
            $_POST = $val->validateForm($_POST);
            (new FaqController())->searchFaq($_POST["param"],true);
        }

        else if($_POST["method"] == "searchActiveFaq"){
            $_POST = $val->validateForm($_POST);
            (new FaqController())->searchActiveFaq($_POST["param"],true);
        }
    }
}
catch (\Exception $error) {
    Helper\Component::showMessage(Helper\Component::$ERROR, $error->getMessage());
}