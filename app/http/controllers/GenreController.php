<?php
/**
 * Created by PhpStorm.
 * User: oscar
 * Date: 11/03/2018
 * Time: 7:06
 */

namespace Http\Controllers;


use Http\Models as Model;
class GenreController
{
    public function getAllGenres(){
        $genres = new Model\Genre();
        return $genres->getAll();
    }

    public function  addGenre($name,$state){
        $genre = new Model\Genre();
        $genre->setName($name);
        $genre->setState($state);
        return $genre->insert();
    }

    public function getGenre($id, $ajax){
        $genre = new Model\Genre();
        $genre->setId($id);
        $genre->getById();
        if($ajax) {
            $json = json_encode(array(
                'id' => $genre->getId(),
                'name' => $genre->getName(),
                'state' => $genre->getState()
            ));
            echo $json;
        }else{
            return $genre;
        }
    }
}
if(isset($_POST["method"])){
    include_once ("../../../vendor/autoload.php");
    if($_POST["method"] == "addGenre"){
        $data = $_POST["genre"];
        $params = array();
        parse_str($data, $params);
        (new GenreController())->addGenre($params['name'],$params['state']);
    }

    if($_POST["method"]=="getGenre"){
        $id = $_POST["id"];
        (new GenreController())->getGenre($id, true);
    }
}