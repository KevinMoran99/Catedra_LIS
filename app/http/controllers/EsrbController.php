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

    public function getAllEsrbsPublic($ajax){
        //creamos un nuevo objeto
        $esrb = new Model\Esrb();
        //retornamos todos los datos
        if ($ajax) {
            echo json_encode($esrb->getAll(true));
        }
        else {
            return $esrb->getAll(true);
        }
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
            echo json_encode($esrb);
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
            echo json_encode($data);
        }else{
            //si no es ajax, retorna un objeto
            return $data;
        }
    }

    //Información de gráfica
    public function getChartEsrb() {
        echo json_encode((new Model\Esrb())->getChartInfo());
    }
}


//Fuera de la clase handleamos las request y las enviamos a su respectivo metodo
try {
    if (isset($_POST["method"])) {
        //incluimos la clase autoload para poder utilizar los namespaces
        include_once("../../../vendor/autoload.php");
        if ($_POST["method"] == "addEsrb") {
            //creamos un nuevo registro con los datos del array
            (new EsrbController())->addEsrb($_POST['name'], $_POST['state']);
        }

        if ($_POST["method"] == "getEsrb") {
            //obtenemos el registro
            (new EsrbController())->getEsrb($_POST["id"], true);
        }

        if($_POST["method"] == "updateEsrb"){
            //actualizamos el registro con los datos del array
            (new EsrbController())->updateEsrb($_POST['id'],$_POST['name'],$_POST['state']);
        }

        if($_POST["method"] == "searchEsrb"){
            (new EsrbController())->searchEsrb($_POST["param"],true);
        }

        if ($_POST["method"] == "getAllEsrbsPublic") {
            //obtenemos el registro
            (new EsrbController())->getAllEsrbsPublic( true);
        }

        if ($_POST["method"] == "getChartEsrb") {
            //obtenemos los datos
            (new EsrbController())->getChartEsrb();
        }
    }
}
catch (\Exception $error) {
    Helper\Component::showMessage(Helper\Component::$ERROR, $error->getMessage());
}