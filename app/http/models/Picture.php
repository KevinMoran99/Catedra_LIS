<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 10/3/2018
 * Time: 12:00 AM
 */

namespace Http\Models;
require ("../../../vendor/autoload.php");
use Http\Models as Model;
use Http\Models\Interfaces as Interfaces;

class Picture implements Interfaces\ModelInterface
{
    private $id;
    private $game;
    private $pictureUrl;
    private $pictureType;

    /**
     * Picture constructor.
     * @param $id
     * @param $game
     * @param $pictureUrl
     * @param $pictureType
     */
    public function init($id, $game, $pictureUrl, $pictureType)
    {
        $this->id = $id;
        $this->game = $game;
        $this->pictureUrl = $pictureUrl;
        $this->pictureType = $pictureType;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * @param mixed $game
     */
    public function setGame($game)
    {
        $this->game = $game;
    }

    /**
     * @return mixed
     */
    public function getPictureUrl()
    {
        return $this->pictureUrl;
    }

    /**
     * @param mixed $pictureUrl
     */
    public function setPictureUrl($pictureUrl)
    {
        $this->pictureUrl = $pictureUrl;
    }

    /**
     * @return mixed
     */
    public function getPictureType()
    {
        return $this->pictureType;
    }

    /**
     * @param mixed $pictureType
     */
    public function setPictureType($pictureType)
    {
        $this->pictureType = $pictureType;
    }


    public function getAll(){
        //Innecesario
        return null;
    }

    public function getById() {
        $query ="SELECT * FROM pictures WHERE id = ?";
        $params = array($this->getId());
        $picture = Model\Connection::selectOne($query,$params);
        $this->setId($picture['id']);
            $pGame = new Game();
            $pGame->setId($picture['game_id']);
            $pGame->getById();
        $this->setGame($pGame);
        $this->setPictureUrl($picture['picture_url']);
        $this->setPictureType($picture['picture_type']);
    }

    public function getByGame($pGame) {
        $query ="SELECT * FROM pictures WHERE game_id = ?";
        $params = array($pGame->getId());
        //Array de objetos devueltos
        $result = [];
        //Recorriendo resultados
        foreach(Model\Connection::select($query,$params) as $line) {
            $action = new Picture();
            $action->init($line["id"], $pGame, $line["picture_url"], $line["picture_type"]);
            array_push($result, $action);
        }
        return $result;
    }

    public function insert(){
        $query ="INSERT INTO pictures (game_id,picture_url,picture_type) VALUES(?,?,?)";
        $params= array($this->getGame(),$this->getPictureUrl(),$this->getPictureType());
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function update(){
        $query ="UPDATE pictures SET game_id=?,picture_url=?,picture_type=? WHERE id=?";
        $params= array($this->getGame(),$this->getPictureUrl(),$this->getPictureType(),$this->getId());
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function search($param) {
        //Innecesario
        return null;
    }
}