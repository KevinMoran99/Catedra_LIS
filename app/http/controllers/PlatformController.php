<?php
/**
 * Created by PhpStorm.
 * User: ara
 * Date: 3/14/18
 * Time: 3:03 p.m.
 */

namespace Http\Controllers;

use Http\Models as Model;
use Http\Helpers as Helper;
class PlatformController
{
//obtener todos las plataformas
    public function getAllPlatforms(){
        //instancia
        $platforms = new Model\Platform();
        //retornamos todos los objetos
        return $platforms->getAll();
    }

    //agregar plataforma
    public  function  addPlatform($name, $state){
        //instancia
        $validator = new Helper\Validator();
        $platform = new Model\Platform();
        //variables de validacion
        $flag = false;
        $validateError= "";

        //validamos si es alfanumerico
        if(!$validator->validateAlphanumeric($name,3,50)){
            $validateError = "Solo se permiten numeros y letras en nombre de plataforma";
            $flag=true;
        }

        //validamos
        if(!$flag) {
            $platform->setName($name);
            $platform->setState($state);
            $response = $platform->insert();

            //mostramos mensaje de error
            if(is_bool($response)){
                Helper\Component::showMessage(Helper\Component::$SUCCESS, "Plataforma añadido");
            }else{
                Helper\Component::showMessage(Helper\Component::$WARNING, $response);
            }
        }else{
            Helper\Component::showMessage(Helper\Component::$ERROR,$validateError);
        }
    }

    //obtener plataforma
    public function getPlatform($id,$ajax){
        //instancia
        $platform = new Model\Platform();
        $platform->setId($id);
        $platform->getById();

        if($ajax){
            //si es ajax retornamos json
            echo json_encode($platform);
        }else{
            //si no es ajax retornamos objeto
            return $platform;
        }
    }

    //actualizar plataforma
    public function updatePlatform($id,$name,$state){
        //instancia
        $validator = new Helper\Validator();
        $platform = new Model\Platform();
        //variables de validacion
        $flag = false;
        $validateError= "";

        //validamos si es alfanumerico
        if(!$validator->validateAlphanumeric($name,3,50)){
            $validateError = "Solo se permiten numeros y letras en nombre de plataforma";
            $flag=true;
        }

        if(!$flag){
            $platform->setId($id);
            $platform->setName($name);
            $platform->setState($state);
            //validando si se guarda
            $response = $platform->update();
            if (is_bool($response)) {
                Helper\Component::showMessage(Helper\Component::$SUCCESS, "Plataforma actualizada");
            }else {
                Helper\Component::showMessage(Helper\Component::$WARNING, $response);
            }
        }else{
            Helper\Component::showMessage(Helper\Component::$ERROR, $validateError);
        }
    }


    //buscar
    public function searchPlatform($name,$ajax){
        //nuevo objeto de platform
        $platform = new Model\Platform();
        $data = $platform->search($name);
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
        if ($_POST["method"] == "addPlatform") {
            $_POST = $val->validateForm($_POST);
            //creamos un nuevo registro con los datos del array
            (new PlatformController())->addPlatform($_POST['name'], $_POST['state']);
        }

        if ($_POST["method"] == "getPlatform") {
            $_POST = $val->validateForm($_POST);
            //obtenemos el registro
            (new PlatformController())->getPlatform($_POST["id"], true);
        }

        if($_POST["method"] == "updatePlatform"){
            $_POST = $val->validateForm($_POST);
            //actualizamos el registro con los datos del array
            (new PlatformController())->updatePlatform($_POST['id'],$_POST['name'],$_POST['state']);
        }

        if($_POST["method"] == "searchPlatform"){
            $_POST = $val->validateForm($_POST);
            (new PlatformController())->searchPlatform($_POST["param"],true);
        }
    }
}
catch (\Exception $error) {
    Helper\Component::showMessage(Helper\Component::$ERROR, $error->getMessage());
}