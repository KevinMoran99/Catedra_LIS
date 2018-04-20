<?php
/**
 * Created by PhpStorm.
 * User: oscar
 * Date: 11/03/2018
 * Time: 7:06
 */

namespace Http\Controllers;
//Namespaces necesarios
use Http\Models as Model;
use Http\Helpers as Helper;

class GenreController
{
    //OBTENER TODOS LOS REGISTROS
    public function getAllGenres(){
        //creamos un nuevo objeto
        $genres = new Model\Genre();
        //retornamos todos los datos
        return $genres->getAll();
    }

    public function getAllGenresPublic($ajax){
        //creamos un nuevo objeto
        $genres = new Model\Genre();
        //retornamos todos los datos
        if ($ajax) {
            echo json_encode($genres->getAll(true));
        }
        else {
            return $genres->getAll(true);
        }
    }

    //AGREGAR REGISTRO
    public function  addGenre($name,$state){
        //creamos objetos de validacion y genero
        $validator = new Helper\Validator();
        $genre = new Model\Genre();
        //variables de validacion
        $flag = false;
        $validateError= "";
        //si no es alfanumerico, setear el flag a true y agregar mensaje de error
        if(!$validator->validateAlphanumeric($name,3,50)){
            $validateError = "Solo se permiten numeros y letras en nombre de genero";
            $flag = true;
        }

        //si el flag sigue siendo falso en este punto, agrega un nuevo registro
        if(!$flag){
            //llenamos el objeto con los datos proporcionados
            $genre->setName($name);
            $genre->setState($state);

            $response = $genre->insert(); //Si se hace el insert retornará true. Si no, retornará el código de la excepción mysql
            if (is_bool($response)) {
                Helper\Component::showMessage(Helper\Component::$SUCCESS, "Género añadido");
            }else {
                Helper\Component::showMessage(Helper\Component::$WARNING, $response);
            }
        }else{
            //si el flag es verdadero, muestra el mensaje de error de validacion
            Helper\Component::showMessage(Helper\Component::$ERROR,$validateError);
        }
    }

    //OBTENER REGISTRO
    public function getGenre($id, $ajax){
        //nuevo objeto de generos
        $genre = new Model\Genre();
        //llenamos el objeto con los datos proporcionados
        $genre->setId($id);
        $genre->getById();
        //si es una request ajax retorna un json con los datos
        if($ajax) {
            /*$json = json_encode(array(
                'id' => $genre->getId(),
                'name' => $genre->getName(),
                'state' => $genre->getState()
            ));*/
            echo json_encode($genre);
        }else{
            //si no es ajax, retorna un objeto
            return $genre;
        }
    }

    //ACTUALIZAR REGISTRO
    public function updateGenre($id,$name,$state){
        //objetos de validacion y genero
        $validator = new Helper\Validator();
        $genre = new Model\Genre();
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
            $genre->setId($id);
            $genre->setName($name);
            $genre->setState($state);
            $response = $genre->update();
            if (is_bool($response)) {
                Helper\Component::showMessage(Helper\Component::$SUCCESS, "Género actualizado");
            }else {
                Helper\Component::showMessage(Helper\Component::$WARNING, $response);
            }
        }else{
            //si el flag es verdadero, enviar mensaje de error
            Helper\Component::showMessage(Helper\Component::$ERROR, $validateError);
        }
    }

    public function searchGenre($name,$ajax){
        //nuevo objeto de generos
        $genre = new Model\Genre();
        $data = $genre->search($name);
        //si es una request ajax retorna un json con los datos
        if($ajax) {
           /* $array = [];
            $json = null;
            for($i = 0;$i<sizeof($data);$i++){
                $tmp = array(
                    'id' => $data[$i]->getId(),
                    'name' => $data[$i]->getName(),
                    'state' => $data[$i]->getState()
                );
                array_push($array,$tmp);
            }
            $json = json_encode($array);*/
            echo json_encode($data);
        }else{
            //si no es ajax, retorna un objeto
            return $data;
        }
    }

    public function getChartGenre() {
        echo json_encode((new Model\Genre())->getChartInfo());
    }
}

//Fuera de la clase handleamos las request y las enviamos a su respectivo metodo
try {
    if (isset($_POST["method"])) {
        //incluimos la clase autoload para poder utilizar los namespaces
        include_once("../../../vendor/autoload.php");
        if ($_POST["method"] == "addGenre") {
            //creamos un nuevo registro con los datos del array
            (new GenreController())->addGenre($_POST['name'], $_POST['state']);
        }

        if ($_POST["method"] == "getGenre") {
            //obtenemos el registro
            (new GenreController())->getGenre($_POST["id"], true);
        }

        if($_POST["method"] == "updateGenre"){
            //actualizamos el registro
            (new GenreController())->updateGenre($_POST['id'],$_POST['name'],$_POST['state']);
        }

        if($_POST["method"] == "searchGenre"){
            (new GenreController())->searchGenre($_POST["param"],true);
        }

        if ($_POST["method"] == "getAllGenresPublic") {
            //obtenemos el registro
            (new GenreController())->getAllGenresPublic(true);
        }
        if ($_POST["method"] == "getChartGenre") {
            //obtenemos el registro
            (new GenreController())->getChartGenre();
        }
    }
}
catch (\Exception $error) {
    Helper\Component::showMessage(Helper\Component::$ERROR, $error->getMessage());
}