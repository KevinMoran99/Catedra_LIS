<?php
/**
 * Created by PhpStorm.
 * User: ara
 * Date: 3/14/18
 * Time: 1:04 p.m.
 */

namespace Http\Controllers;

//namespace necesarios

use Http\Models as Model;
use Http\Helpers as Helper;
class PublisherController
{
    //obtener todos los publicadores
    public function getAllPublishers(){
        //instancia
        $publishers = new Model\Publisher();
        //retornamos todos los objetos
        return $publishers->getAll();
    }

    //agregar publicador
    public  function  addPublisher($name, $state){
        //instancia
        $validator = new Helper\Validator();
        $publisher = new Model\Publisher();
        //variables de validacion
        $flag = false;
        $validateError= "";

        //validamos si es alfanumerico
        if(!$validator->validateAlphanumeric($name,3,50)){
            $validateError = "Solo se permiten numeros y letras en nombre de publicador";
            $flag=true;
        }

        //validamos
        if(!$flag) {
            $publisher->setName($name);
            $publisher->setState($state);
            $response = $publisher->insert();

            //mostramos mensaje de error
            if(is_bool($response)){
                Helper\Component::showMessage(Helper\Component::$SUCCESS, "Publicador añadido");
            }else{
                Helper\Component::showMessage(Helper\Component::$WARNING, $response);
            }
        }else{
            Helper\Component::showMessage(Helper\Component::$ERROR,$validateError);
        }
    }

    //obtener publisher
    public function getPublisher($id,$ajax){
        //instancia
        $publisher = new Model\Publisher();
        $publisher->setId($id);
        $publisher->getById();

        if($ajax){
            //si es ajax retornamos json
            $json = json_encode(array(
                'id' => $publisher->getId(),
                'name' => $publisher->getName(),
                'state' => $publisher->getState()
            ));
            echo $json;
        }else{
            //si no es ajax retornamos objeto
            return $publisher;
        }
    }

    //actualizar publisher
    public function updatePublisher($id,$name,$state){
        //instancia
        $validator = new Helper\Validator();
        $publisher = new Model\Publisher();
        //variables de validacion
        $flag = false;
        $validateError= "";

        //validamos si es alfanumerico
        if(!$validator->validateAlphanumeric($name,3,50)){
            $validateError = "Solo se permiten numeros y letras en nombre de publicador";
            $flag=true;
        }

        if(!$flag){
            $publisher->setId($id);
            $publisher->setName($name);
            $publisher->setState($state);
            //validando si se guarda
            $response = $publisher->update();
            if (is_bool($response)) {
                Helper\Component::showMessage(Helper\Component::$SUCCESS, "Publicador actualizado");
            }else {
                Helper\Component::showMessage(Helper\Component::$WARNING, $response);
            }
        }else{
            Helper\Component::showMessage(Helper\Component::$ERROR, $validateError);
        }
    }


    //buscar
    public function searchPublisher($name,$ajax){
        //nuevo objeto de publisher
        $publisher = new Model\Publisher();
        $data = $publisher->search($name);
        //si es una request ajax retorna un json con los datos
        if($ajax) {
            $array = [];
            $json = null;
            for($i = 0;$i<sizeof($data);$i++){
                $tmp = array(
                    'id' => $data[$i]->getId(),
                    'name' => $data[$i]->getName(),
                    'state' => $data[$i]->getState()
                );
                array_push($array,$tmp);
            }
            $json = json_encode($array);
            echo $json;
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
        if ($_POST["method"] == "addPublisher") {
            //creamos un nuevo registro con los datos del array
            (new PublisherController())->addPublisher($_POST['name'], $_POST['state']);
        }

        if ($_POST["method"] == "getPublisher") {
            //obtenemos el registro
            (new PublisherController())->getPublisher($_POST["id"], true);
        }

        if($_POST["method"] == "updatePublisher"){
            //actualizamos el registro con los datos del array
            (new PublisherController())->updatePublisher($_POST['id'],$_POST['name'],$_POST['state']);
        }

        if($_POST["method"] == "searchPublisher"){
            (new PublisherController())->searchPublisher($_POST["param"],true);
        }
    }
}
catch (\Exception $error) {
    Helper\Component::showMessage(Helper\Component::$ERROR, $error->getMessage());
}