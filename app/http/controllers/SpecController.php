<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 14/3/2018
 * Time: 10:45 PM
 */

namespace Http\Controllers;
//Namespaces necesarios
use Http\Models as Model;
use Http\Helpers as Helper;


class SpecController
{
    //OBTENER TODOS LOS REGISTROS
    public function getAllSpecs(){
        //creamos un nuevo objeto
        $specs = new Model\Spec();
        //retornamos todos los datos
        return $specs->getAll();
    }

    //Obtener todos los registros activos
    public function getAllActiveSpecs(){
        //creamos un nuevo objeto
        $spec = new Model\Spec();
        //retornamos todos los datos
        return $spec->getAll(true);
    }

    //AGREGAR REGISTRO
    public function  addSpec($name,$typeSpec,$state){
        //creamos objetos de validacion y spec
        $validator = new Helper\Validator();
        $spec = new Model\Spec();
        //variables de validacion
        $flag = false;
        $validateError= "";
        //si no es alfanumerico, setear el flag a true y agregar mensaje de error
        if(!$validator->validateText($name,3,50)){
            $validateError = "Solo se permiten numeros, letras y signos de puntuación en el nombre de la especificación";
            $flag = true;
        }
        //si no se ha seteado tipo de spec, setear le flag a true y agregar mensaje de error
        if(is_null($typeSpec)){
            $validateError = "Por favor elija un tipo de especificación";
            $flag = true;
        }

        //si el flag sigue siendo falso en este punto, agrega un nuevo registro
        if(!$flag){
            //Obteniendo padre del spec
            $type = new Model\TypeSpec();
            $type->setId($typeSpec);
            $type->getById();

            //llenamos el objeto con los datos proporcionados
            $spec->setName($name);
            $spec->setTypeSpec($type);
            $spec->setState($state);

            $response = $spec->insert(); //Si se hace el insert retornará true. Si no, retornará el código de la excepción mysql
            if (is_bool($response)) {
                Helper\Component::showMessage(Helper\Component::$SUCCESS, "Especificación añadida");
            }else {
                Helper\Component::showMessage(Helper\Component::$WARNING, $response);
            }
        }else{
            //si el flag es verdadero, muestra el mensaje de error de validacion
            Helper\Component::showMessage(Helper\Component::$ERROR,$validateError);
        }
    }

    //OBTENER REGISTRO
    public function getSpec($id, $ajax){
        //nuevo objeto de tipo de specs
        $spec = new Model\Spec();
        //llenamos el objeto con los datos proporcionados
        $spec->setId($id);
        $spec->getById();
        //si es una request ajax retorna un json con los datos
        if($ajax) {
            $json = json_encode(array(
                'id' => $spec->getId(),
                'name' => $spec->getName(),
                'typeSpec' => $spec->getTypeSpec()->getId(),
                'state' => $spec->getState()
            ));
            echo $json;
        }else{
            //si no es ajax, retorna un objeto
            return $spec;
        }
    }

    //ACTUALIZAR REGISTRO
    public function updateSpec($id,$name,$typeSpec,$state){
        //objetos de validacion y tipo de spec
        $validator = new Helper\Validator();
        $spec = new Model\Spec();
        //variables de validacion
        $flag = false;
        $validateError="";

        //si no es alfanumerico setear flag a verdadero y agregar mensaje
        if(!$validator->validateAlphanumeric($name,3,50)){
            $validateError = "Solo se permiten numeros y letras en el nombre de la especificación";
            $flag = true;
        }

        //si en este punto el flag es falso, actualizar el registro
        if(!$flag){
            //Obteniendo padre del spec
            $type = new Model\TypeSpec();
            $type->setId($typeSpec);
            $type->getById();

            $spec->setId($id);
            $spec->setName($name);
            $spec->setTypeSpec($type);
            $spec->setState($state);
            $response = $spec->update();
            if (is_bool($response)) {
                Helper\Component::showMessage(Helper\Component::$SUCCESS, "Especificación actualizada");
            }else {
                Helper\Component::showMessage(Helper\Component::$WARNING, $response);
            }
        }else{
            //si el flag es verdadero, enviar mensaje de error
            Helper\Component::showMessage(Helper\Component::$ERROR, $validateError);
        }
    }

    public function searchSpec($name,$ajax){
        //nuevo objeto de tipo de especificacion
        $spec = new Model\Spec();
        $data = $spec->search($name);
        //si es una request ajax retorna un json con los datos
        if($ajax) {
            $array = [];
            $json = null;
            for($i = 0;$i<sizeof($data);$i++){
                $tmp = array(
                    'id' => $data[$i]->getId(),
                    'name' => $data[$i]->getName(),
                    'typeSpec' => $data[$i]->getTypeSpec()->getName(),
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
        if ($_POST["method"] == "addSpec") {
            //creamos un nuevo registro con los datos del array
            (new SpecController())->addSpec($_POST['name'], $_POST['typeSpec'], $_POST['state']);
        }

        else if ($_POST["method"] == "getSpec") {
            //obtenemos el registro
            (new SpecController())->getSpec($_POST["id"], true);
        }

        else if($_POST["method"] == "updateSpec"){
            //actualizamos el registro con los datos del array
            (new SpecController())->updateSpec($_POST['id'],$_POST['name'],$_POST['typeSpec'],$_POST['state']);
        }

        else if($_POST["method"] == "searchSpec"){
            (new SpecController())->searchSpec($_POST["param"],true);
        }
    }
}
catch (\Exception $error) {
    Helper\Component::showMessage(Helper\Component::$ERROR, $error->getMessage());
}
