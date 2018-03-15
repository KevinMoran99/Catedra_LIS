<?php
/**
 * Created by PhpStorm.
 * User: oscar
 * Date: 14/03/2018
 * Time: 19:16
 */

namespace Http\Controllers;
//Namespaces necesarios
use Http\Models as Model;
use Http\Helpers as Helper;

class EsrbController
{
//OBTENER TODOS LOS REGISTROS
    public function getAllEsrb(){
        //creamos un nuevo objeto
        $esrb = new Model\Esrb();
        //retornamos todos los datos
        return $esrb->getAll();
    }

    //AGREGAR REGISTRO
    public function  addEsrb($name,$state){
        //creamos objetos de validacion y genero
        $validator = new Helper\Validator();
        $esrb = new Model\Esrb();
        //variables de validacion
        $flag = false;
        $validateError= "";
        //si no es alfanumerico, setear el flag a true y agregar mensaje de error
        if(!$validator->validateAlphanumeric($name,1,50)){
            $validateError = "Solo se permiten numeros y letras en nombre de clasificacion";
            $flag = true;
        }

        //si el flag sigue siendo falso en este punto, agrega un nuevo registro
        if(!$flag){
            //llenamos el objeto con los datos proporcionados
            $esrb->setName($name);
            $esrb->setState($state);

            $response = $esrb->insert(); //Si se hace el insert retornará true. Si no, retornará el código de la excepción mysql
            if (is_bool($response)) {
                Helper\Component::showMessage(Helper\Component::$SUCCESS, "Clasificacion añadido");
            }else {
                Helper\Component::showMessage(Helper\Component::$WARNING, $response);
            }
        }else{
            //si el flag es verdadero, muestra el mensaje de error de validacion
            Helper\Component::showMessage(Helper\Component::$ERROR,$validateError);
        }
    }

    //OBTENER REGISTRO
    public function getEsrb($id, $ajax){
        //nuevo objeto de generos
        $esrb = new Model\Esrb();
        //llenamos el objeto con los datos proporcionados
        $esrb->setId($id);
        $esrb->getById();
        //si es una request ajax retorna un json con los datos
        if($ajax) {
            $json = json_encode(array(
                'id' => $esrb->getId(),
                'name' => $esrb->getName(),
                'state' => $esrb->getState()
            ));
            echo $json;
        }else{
            //si no es ajax, retorna un objeto
            return $esrb;
        }
    }

    //ACTUALIZAR REGISTRO
    public function updateEsrb($id,$name,$state){
        //objetos de validacion y genero
        $validator = new Helper\Validator();
        $esrb = new Model\Esrb();
        //variables de validacion
        $flag = false;
        $validateError="";

        //si no es alfanumerico setear flag a verdadero y agregar mensaje
        if(!$validator->validateAlphanumeric($name,1,50)){
            $validateError = "Solo se permiten numeros y letras en nombre de clasificacion";
            $flag = true;
        }

        //si en este punto el flag es falso, actualizar el registro
        if(!$flag){
            $esrb->setId($id);
            $esrb->setName($name);
            $esrb->setState($state);
            $response = $esrb->update();
            if (is_bool($response)) {
                Helper\Component::showMessage(Helper\Component::$SUCCESS, "Clasificacion actualizado");
            }else {
                Helper\Component::showMessage(Helper\Component::$WARNING, $response);
            }
        }else{
            //si el flag es verdadero, enviar mensaje de error
            Helper\Component::showMessage(Helper\Component::$ERROR, $validateError);
        }
   }

    //buscar
    public function searchEsrb($name,$ajax){
        //nuevo objeto de esrb
        $esrb = new Model\Esrb();
        $data = $esrb->search($name);
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
        if ($_POST["method"] == "addEsrb") {
            //obtenemos la data
            $data = $_POST["esrb"];
            //creamos un array el cual llenaremos con la data
            $params = array();
            //filleamos el array
            parse_str($data, $params);
            //creamos un nuevo registro con los datos del array
            (new EsrbController())->addEsrb($params['name'], $params['state']);
        }

        if ($_POST["method"] == "getEsrb") {
            //obtenemos el id proporcionado
            $id = $_POST["id"];
            //obtenemos el registro
            (new EsrbController())->getEsrb($id, true);
        }

        if($_POST["method"] == "updateEsrb"){
            //obtenemos la data
            $data = $_POST["esrb"];
            //creamos un array el cual llenaremos con la data
            $params = array();
            //llenamos el array
            parse_str($data, $params);
            //actualizamos el registro con los datos del array
            (new EsrbController())->updateEsrb($params['id'],$params['name'],$params['state']);
        }

        if($_POST["method"] == "searchEsrb"){
            $data = $_POST["param"];
            (new EsrbController())->searchEsrb($data,true);
        }
    }
}
catch (\Exception $error) {
    Helper\Component::showMessage(Helper\Component::$ERROR, $error->getMessage());
}