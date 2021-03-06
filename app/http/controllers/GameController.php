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

    public function getAllGamesPublic($ajax){
        $game= new Model\Game();
        //retornamos todos los datos
        if ($ajax) {
            echo json_encode($game->getAll(true));
        }
        else {
            return $game->getAll(true);
        }
    }

    public  function  addGame($name, $cover, $banner, $description, $esrb, $publisher, $genre, /*$platform,*/ $state){
        //instancia
        $validator = new Helper\Validator();
        $game = new Model\Game();
        //variables de validacion
        $flag = false;
        $validateError= "";
        $urlCover=null;
        $urlBanner=null;
        //validamos si la imagen es valida
        if(!$validator->validateImage($cover,false,"../../web/img/",256,320)){
            $validateError = $validator->getImageError();
            $flag=true;
        }else{
            $urlCover = $validator->finalUrl();
        }
        if(!$validator->validateImage($banner,false,"../../web/img/",1280,720)){
            $validateError = $validator->getImageError();
            $flag=true;
        }else{
            $urlBanner = $validator->finalUrl();
        }
        //validamos campos de texto
        if (!$validator->validateAlphanumeric($name, 3, 50)) {
            $validateError = "Solo se permiten numeros, letras y signos de puntuación en el nombre del juego";
            $flag = true;
        }
        if(!$validator->validateText($description,3,500)){
            $validateError = "Solo se permiten numeros, letras y signos de puntuación en la descripción";
            $flag = true;
        }

        //validamos
        if(!$flag) {
            $game->setName($name);
            $game->setCover($urlCover);
            $game->setBanner($urlBanner);
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
            /*$platformM= new Model\Platform();
            $platformM->setId($platform);
            $game->setPlatform($platformM);*/
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
            echo json_encode($game);
        }else{
            //si no es ajax, retorna un objeto
            return $game;
        }
    }

    //ACTUALIZAR REGISTRO
    public function updateGame($id,$name, $cover,$banner, $description, $esrb, $publisher, $genre, /*$platform,*/ $state){
        //objetos de validacion y genero
        $validator = new Helper\Validator();
        $game = new Model\Game();
        //variables de validacion
        $flag = false;
        $validateError="";
        $url=null;
        $urlBanner=null;

        //Validando imagen, si hay una
        if (!empty($cover)) {
            if (!$validator->validateImage($cover, false, "../../web/img/", 256, 320)) {
                $validateError = $validator->getImageError();
                $flag = true;
            } else {
                $url = $validator->finalUrl();
            }
        }
        //Validando imagen, si hay una
        if (!empty($banner)) {
            if (!$validator->validateImage($banner, false, "../../web/img/", 1280, 720)) {
                $validateError = $validator->getImageError();
                $flag = true;
            } else {
                $urlBanner = $validator->finalUrl();
            }
        }
        //validamos campos de texto
        if (!$validator->validateAlphanumeric($name, 3, 50)) {
            $validateError = "Solo se permiten numeros, letras y signos de puntuación en el nombre del juego";
            $flag = true;
        }
        if(!$validator->validateText($description,3,500)){
            $validateError = "Solo se permiten numeros, letras y signos de puntuación en la descripción";
            $flag = true;
        }

         //si en este punto el flag es falso, actualizar el registro
         if(!$flag){
            $game->setId($id);
            $game->getById(); //Para obtener cover actual si no fue actualizado
            $game->setName($name);
            if(!empty($cover)) {
                $game->setCover($url);
            }
            if(!empty($banner)){
                $game->setBanner($urlBanner);
            }
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
            /*$platformM= new Model\Platform();
            $platformM->setId($platform);
            $game->setPlatform($platformM);*/
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
            echo json_encode($data);
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
        $val = new Helper\Validator();
        if ($_POST["method"] == "addGame") {
            $_POST = $val->validateForm($_POST);
            //creamos un nuevo registro con los datos del array
            (new GameController())->addGame($_POST['name'],$_FILES['cover'],$_FILES['banner'],$_POST['description'],$_POST['esrb'],$_POST['publisher'],$_POST['genre'],/*$_POST['platform'],*/ $_POST['state']);

        }

        if ($_POST["method"] == "getGame") {
            //obtenemos el registro
            $_POST = $val->validateForm($_POST);
            (new GameController())->getGame($_POST["id"], true);
        }

        if($_POST["method"] == "updateGame"){
            $_POST = $val->validateForm($_POST);
            //actualizamos el registro. Si no se establecio otra imagen, no se toma en cuenta ese campo

            (new GameController())->updateGame($_POST['id'], $_POST['name'], is_uploaded_file($_FILES['cover']['tmp_name']) ? $_FILES['cover'] : '',is_uploaded_file($_FILES['banner']['tmp_name']) ? $_FILES['banner'] : '', $_POST['description'], $_POST['esrb'], $_POST['publisher'], $_POST['genre'], /*$_POST['platform'],*/ $_POST['state']);

        }

        if($_POST["method"] == "searchGame"){
            $_POST = $val->validateForm($_POST);
            (new GameController())->searchGame($_POST["param"],true);
        }

        if ($_POST["method"] == "getAllGamesPublic") {
            //obtenemos el registro
            (new GameController())->getAllGamesPublic(true);
        }
    }
}
catch (\Exception $error) {
    //Helper\Component::showMessage(Helper\Component::$ERROR, $error->getMessage());
}