<?php

namespace Http\Controllers;
use Http\Models as Model;
use Http\Helpers as Helper;

Class GameController
{
    public function getAllGames(){
        $game= new Model\Game();
        return $game->getAll();
    }

    public  function  addGame($name, $cover, $description, $esrb, $publisher, $genre, $platform, $state){
        //instancia
        $validator = new Helper\Validator();
        $game = new Model\Game();
        //variables de validacion
        $flag = false;
        $validateError= "";
        $url=null;
        //validamos si la imagen
        if(!$validator->validateImage($cover,false,"../../web/img/",256,320)){
            $validateError = $validator->getImageError();
            $flag=true;
        }else{
            $url = $validator->finalUrl();
        }

        //validamos
        if(!$flag) {
            $game->setName($name);
            $game->setCover($url);
            $game->setDescription($description);
            $esrbM = new Model\Esrb();
            $esrbM->setId($esrb);
            $game->setEsrb($esrbM);
            $publisherM = new Model\Publisher();
            $publisherM->setId($publisher);
            $game->setPublisher($publisherM);
            $genreM=new Model\Genre();
            $genreM->setId($genre);
            $game->setGenre($genreM);
            $platformM= new Model\Platform();
            $platformM->setId($platform);
            $game->setPlatform($platformM);
            $game->setState($state);
            $response = $game->insert();

            //mostramos mensaje de error
            if(is_bool($response)){
                Helper\Component::showMessage(Helper\Component::$SUCCESS, "Juego añadido");
            }else{
                Helper\Component::showMessage(Helper\Component::$WARNING, $response);
            }
        }else{
            Helper\Component::showMessage(Helper\Component::$ERROR,$validateError);
        }
    }

    //OBTENER REGISTRO
    public function getGame($id, $ajax){
        //nuevo objeto de generos
        $game = new Model\Game();
        //llenamos el objeto con los datos proporcionados
        $game->setId($id);
        $game->getById();
        //si es una request ajax retorna un json con los datos
        if($ajax) {
            $json = json_encode(array(
                'id' => $game->getId(),
                'name' => $game->getName(),
                'cover' => $game->getCover(),
                'description' => $game->getDescription(),
                'esrb' => $game->getEsrb(),
                'publisher' => $game->getPublisher(),
                'genre' => $game->getGenre(),
                'platform' => $game->getPlatform(),
                'state' => $game->getState()
            ));
            echo $json;
        }else{
            //si no es ajax, retorna un objeto
            return $game;
        }
    }

    //ACTUALIZAR REGISTRO
    public function updateGame($id,$name, $cover, $description, $esrb, $publisher, $genre, $platform, $state){
        //objetos de validacion y genero
        $validator = new Helper\Validator();
        $game = new Model\Game();
        //variables de validacion
        $flag = false;
        $validateError="";

        //si no es alfanumerico setear flag a verdadero y agregar mensaje
        if(!$validator->validateImage($cover,false,"../../web/img",500,500)){
            $validateError = "Error al modificar la imagen";
            $flag = true;
        }
         //si en este punto el flag es falso, actualizar el registro
         if(!$flag){
            $game->setId($id);
            $game->setName($name);
            $game->setCover($url);
            $game->setDescription($description);
            $esrbM = new Model\Esrb();
            $esrbM->setId($esrb);
            $game->setEsrb($esrbM);
            $publisherM = new Model\Publisher();
            $publisherM->setId($publisher);
            $game->setPublisher($publisherM);
            $genreM=new Model\Genre();
            $genreM->setId($genre);
            $game->setGenre($genreM);
            $platformM= new Model\Platform();
            $platformM->setId($platform);
            $game->setPlatform($platformM);
            $game->setState($state);
            $response = $game->update();
            if (is_bool($response)) {
                Helper\Component::showMessage(Helper\Component::$SUCCESS, "Juego actualizado");
            }else {
                Helper\Component::showMessage(Helper\Component::$WARNING, $response);
            }
        }else{
            //si el flag es verdadero, enviar mensaje de error
            Helper\Component::showMessage(Helper\Component::$ERROR, $validateError);
        }
    }

    public function searchGame($name,$ajax){
        //nuevo objeto de generos
        $game = new Model\Game();
        $data = $game->search($name);
        //si es una request ajax retorna un json con los datos
        if($ajax) {
            $array = [];
            $json = null;
            for($i = 0;$i<sizeof($data);$i++){
                $tmp = array(
                    'id' => $data[$i]->getId(),
                    'name' => $data[$i]->getName(),
                    'cover' => $data[$i]->getCover(),
                    'esrb' => $data[$i]->getEsrb()->getName(),
                    'publisher' => $data[$i]->getPublisher()->getName(),
                    'genre' => $data[$i]->getGenre()->getName(),
                    'platform' => $data[$i]->getPlatform()->getName(),
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

try {
    if (isset($_POST["method"])) {
        //incluimos la clase autoload para poder utilizar los namespaces
        include_once("../../../vendor/autoload.php");
        if ($_POST["method"] == "addGame") {
            //creamos un nuevo registro con los datos del array
                (new GameController())->addGame($_POST['name'],$_FILES['cover'],$_POST['description'],$_POST['esrb'],$_POST['publisher'],$_POST['genre'],$_POST['platform'], $_POST['state']);
            
            
        }

        if ($_POST["method"] == "getGame") {
            //obtenemos el registro
            (new GameController())->getGame($_POST["id"], true);
        }

        if($_POST["method"] == "updateGame"){
            //actualizamos el registro
            (new GameController())->updateGame($_POST['id'],$_POST['name'],$_FILES['cover'],$_POST['description'],$_POST['esrb'],$_POST['publisher'],$_POST['genre'],$_POST['platform'], $_POST['state']);
        }

        if($_POST["method"] == "searchGame"){
            (new GameController())->searchGame($_POST["param"],true);
        }
    }
}
catch (\Exception $error) {
    Helper\Component::showMessage(Helper\Component::$ERROR, $error->getMessage());
}