<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 15/3/2018
 * Time: 10:28 AM
 */

namespace Http\Controllers;
use Http\Models as Model;
use Http\Helpers as Helper;


class UserTypeController
{
    //OBTENER TODOS LOS REGISTROS
    public function getAllUserTypes(){
        //creamos un nuevo objeto
        $userType = new Model\UserType();
        //retornamos todos los datos
        return $userType->getAll();
    }

    //Obtener todos los registros activos --- USADO PARA POBLAR COMBOBOXES EN EL CRUD DE USER
    public function getAllActiveUserTypes(){
        //creamos un nuevo objeto
        $userType = new Model\UserType();
        //retornamos todos los datos
        return $userType->getAll(true);
    }

    //Obtener todos los registros modificables --- USADO PARA POBLAR EL CRUD DE USERTYPE
    public function getAllModifiableUserTypes(){
        //creamos un nuevo objeto
        $userType = new Model\UserType();
        //retornamos todos los datos
        return $userType->getAll(false, true);
    }

    //AGREGAR REGISTRO
    public function  addUserType($name,$state,$games, $users, $support, $stadistics, 
                                $reviews, $esrbs, $publishers, $genres, $specs, $typeSpecs){
        //creamos objetos de validacion y tipo de usuario
        $validator = new Helper\Validator();
        $type = new Model\UserType();
        //variables de validacion
        $flag = false;
        $validateError= "";
        //si no es alfanumerico, setear el flag a true y agregar mensaje de error
        if(!$validator->validateAlphanumeric($name,3,50)){
            $validateError = "Solo se permiten numeros y letras en el nombre de tipo de usuario";
            $flag = true;
        }

        //si el flag sigue siendo falso en este punto, agrega un nuevo registro
        if(!$flag){
            //llenamos el objeto con los datos proporcionados
            $type->setName($name);
            $type->setState($state);
            $type->setGames($games);
            $type->setUsers($users);
            $type->setSupport($support);
            $type->setStadistics($stadistics);
            $type->setReviews($reviews);
            $type->setEsrbs($esrbs);
            $type->setPublishers($publishers);
            $type->setGenres($genres);
            $type->setSpecs($specs);
            $type->setTypeSpecs($typeSpecs);

            $response = $type->insert(); //Si se hace el insert retornará true. Si no, retornará el código de la excepción mysql
            if (is_bool($response)) {
                Helper\Component::showMessage(Helper\Component::$SUCCESS, "Tipo de usuario añadido");
            }else {
                Helper\Component::showMessage(Helper\Component::$WARNING, $response);
            }
        }else{
            //si el flag es verdadero, muestra el mensaje de error de validacion
            Helper\Component::showMessage(Helper\Component::$ERROR,$validateError);
        }
    }

    //OBTENER REGISTRO
    public function getUserType($id, $ajax){
        //nuevo objeto de tipo de usuario
        $type = new Model\UserType();
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
    public function updateUserType($id, $name, $state, $games, $users, $support, $stadistics, 
                                  $reviews, $esrbs, $publishers, $genres, $specs, $typeSpecs){
        //objetos de validacion y tipo de usuario
        $validator = new Helper\Validator();
        $type = new Model\UserType();
        //variables de validacion
        $flag = false;
        $validateError="";

        //si no es alfanumerico setear flag a verdadero y agregar mensaje
        if(!$validator->validateAlphanumeric($name,3,50)){
            $validateError = "Solo se permiten numeros y letras en nombre de genero";
            $flag = true;
        }

        //si en este punto el flag es falso, actualizar el registro
        if(!$flag){
            $type->setId($id);
            $type->setName($name);
            $type->setState($state);
            $type->setGames($games);
            $type->setUsers($users);
            $type->setSupport($support);
            $type->setStadistics($stadistics);
            $type->setReviews($reviews);
            $type->setEsrbs($esrbs);
            $type->setPublishers($publishers);
            $type->setGenres($genres);
            $type->setSpecs($specs);
            $type->setTypeSpecs($typeSpecs);

            $response = $type->update();
            if (is_bool($response)) {
                Helper\Component::showMessage(Helper\Component::$SUCCESS, "Tipo de usuario actualizado");
            }else {
                Helper\Component::showMessage(Helper\Component::$WARNING, $response);
            }
        }else{
            //si el flag es verdadero, enviar mensaje de error
            Helper\Component::showMessage(Helper\Component::$ERROR, $validateError);
        }
    }

    public function searchUserType($name,$ajax){
        //nuevo objeto de tipo de usuario
        $type = new Model\UserType();
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
        if ($_POST["method"] == "addUserType") {
            $_POST = $val->validateForm($_POST);
            //creamos un nuevo registro con los datos del array
            (new UserTypeController())->addUserType($_POST['name'],$_POST['state'],$_POST['games'], 
                                                    $_POST['users'], $_POST['support'], $_POST['stadistics'], 
                                                    $_POST['reviews'], $_POST['esrbs'], $_POST['publishers'], 
                                                    $_POST['genres'], $_POST['specs'], $_POST['typeSpecs']);
        }

        if ($_POST["method"] == "getUserType") {
            $_POST = $val->validateForm($_POST);
            //obtenemos el registro
            (new UserTypeController())->getUserType($_POST["id"], true);
        }

        if($_POST["method"] == "updateUserType"){
            $_POST = $val->validateForm($_POST);
            //actualizamos el registro
            (new UserTypeController())->updateUserType($_POST['id'],$_POST['name'],$_POST['state'],$_POST['games'], 
                                                        $_POST['users'], $_POST['support'], $_POST['stadistics'], 
                                                        $_POST['reviews'], $_POST['esrbs'], $_POST['publishers'], 
                                                        $_POST['genres'], $_POST['specs'], $_POST['typeSpecs']);
        }

        if($_POST["method"] == "searchUserType"){
            $_POST = $val->validateForm($_POST);
            (new UserTypeController())->searchUserType($_POST["param"],true);
        }

    }
}
catch (\Exception $error) {
    Helper\Component::showMessage(Helper\Component::$ERROR, $error->getMessage());
}