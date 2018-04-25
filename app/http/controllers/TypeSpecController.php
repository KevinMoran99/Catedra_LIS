<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 14/3/2018
 * Time: 9:29 PM
 */

namespace Http\Controllers;
//Namespaces necesarios
use Http\Models as Model;
use Http\Helpers as Helper;


class TypeSpecController
{
    //Obtener todos los registros
    public function getAllTypeSpecs(){
        //creamos un nuevo objeto
        $type = new Model\TypeSpec();
        //retornamos todos los datos
        return $type->getAll();
    }

    //Obtener todos los registros activos
    public function getAllActiveTypeSpecs(){
        //creamos un nuevo objeto
        $type = new Model\TypeSpec();
        //retornamos todos los datos
        return $type->getAll(true);
    }

    //AGREGAR REGISTRO
    public function  addTypeSpec($name,$state){
        //creamos objetos de validacion y tipo de spec
        $validator = new Helper\Validator();
        $type = new Model\TypeSpec();
        //variables de validacion
        $flag = false;
        $validateError= "";
        //si no es alfanumerico, setear el flag a true y agregar mensaje de error
        if(!$validator->validateAlphanumeric($name,3,50)){
            $validateError = "Solo se permiten numeros y letras en el nombre del tipo de especificación";
            $flag = true;
        }

        //si el flag sigue siendo falso en este punto, agrega un nuevo registro
        if(!$flag){
            //llenamos el objeto con los datos proporcionados
            $type->setName($name);
            $type->setState($state);

            $response = $type->insert(); //Si se hace el insert retornará true. Si no, retornará el código de la excepción mysql
            if (is_bool($response)) {
                Helper\Component::showMessage(Helper\Component::$SUCCESS, "Tipo de especificación añadido");
            }else {
                Helper\Component::showMessage(Helper\Component::$WARNING, $response);
            }
        }else{
            //si el flag es verdadero, muestra el mensaje de error de validacion
            Helper\Component::showMessage(Helper\Component::$ERROR,$validateError);
        }
    }

    //OBTENER REGISTRO
    public function getTypeSpec($id, $ajax){
        //nuevo objeto de tipo de specs
        $type = new Model\TypeSpec();
        //llenamos el objeto con los datos proporcionados
        $type->setId($id);
        $type->getById();
        //si es una request ajax retorna un json con los datos
        if($ajax) {
            echo json_encode($type);
        }else{
            //si no es ajax, retorna un objeto
            return $type;
        }
    }

    //ACTUALIZAR REGISTRO
    public function updateTypeSpec($id,$name,$state){
        //objetos de validacion y tipo de spec
        $validator = new Helper\Validator();
        $type = new Model\TypeSpec();
        //variables de validacion
        $flag = false;
        $validateError="";

        //si no es alfanumerico setear flag a verdadero y agregar mensaje
        if(!$validator->validateAlphanumeric($name,3,50)){
            $validateError = "Solo se permiten numeros y letras en nombre de tipo de especificación";
            $flag = true;
        }

        //si en este punto el flag es falso, actualizar el registro
        if(!$flag){
            $type->setId($id);
            $type->setName($name);
            $type->setState($state);
            $response = $type->update();
            if (is_bool($response)) {
                Helper\Component::showMessage(Helper\Component::$SUCCESS, "Tipo de especificación actualizado");
            }else {
                Helper\Component::showMessage(Helper\Component::$WARNING, $response);
            }
        }else{
            //si el flag es verdadero, enviar mensaje de error
            Helper\Component::showMessage(Helper\Component::$ERROR, $validateError);
        }
    }

    public function searchTypeSpec($name,$ajax){
        //nuevo objeto de tipo de especificacion
        $type = new Model\TypeSpec();
        $data = $type->search($name);
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
        if ($_POST["method"] == "addTypeSpec") {
            $_POST = $val->validateForm($_POST);
            //creamos un nuevo registro con los datos del array
            (new TypeSpecController())->addTypeSpec($_POST['name'], $_POST['state']);
        }

        else if ($_POST["method"] == "getTypeSpec") {
            $_POST = $val->validateForm($_POST);
            //obtenemos el registro
            (new TypeSpecController())->getTypeSpec($_POST["id"], true);
        }

        else if($_POST["method"] == "updateTypeSpec"){
            $_POST = $val->validateForm($_POST);
            //actualizamos el registro con los datos del array
            (new TypeSpecController())->updateTypeSpec($_POST['id'],$_POST['name'],$_POST['state']);
        }

        else if($_POST["method"] == "searchTypeSpec"){
            $_POST = $val->validateForm($_POST);
            (new TypeSpecController())->searchTypeSpec($_POST["param"],true);
        }
    }
}
catch (\Exception $error) {
    Helper\Component::showMessage(Helper\Component::$ERROR, $error->getMessage());
}