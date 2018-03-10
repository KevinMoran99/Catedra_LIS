<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 9/3/2018
 * Time: 10:42 PM
 */

namespace Http\Models;
require ("../../../vendor/autoload.php");
use Http\Models as Model;
use Http\Models\Interfaces as Interfaces;

class Genre implements Interfaces\ModelInterface
{
    private $id;
    private $name;
    private $state=1;

    /**
     * Action constructor.
     * @param $id
     * @param $name
     * @param int $state
     */
    public function init($id, $name, $state)
    {
        $this->id = $id;
        $this->name = $name;
        $this->state = $state;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    //query methods

    public function getAll(){
        $query ="SELECT * FROM genres";
        $params = array(null);
        //Array de objetos devueltos
        $result = [];
        //Recorriendo resultados
        foreach(Model\Connection::select($query,$params) as $line) {
            $genre = new Action();
            $genre->init($line["id"], $line["name"], $line["state"]);
            array_push($result, $genre);
        }
        return $result;
    }

    public function getById() {
        $query ="SELECT * FROM genres WHERE id = ?";
        $params = array($this->getId());
        $genre = Model\Connection::selectOne($query,$params);
        $this->setId($genre['id']);
        $this->setName($genre['name']);
        $this->setState($genre['state']);
    }

    public function insert(){
        $query ="INSERT INTO genres (name,state) VALUES(?,?)";
        $params= array($this->getName(),$this->getState());
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function update(){
        $query ="UPDATE genres SET name=?,state=? WHERE id=?";
        $params= array($this->getName(),$this->getState(),$this->getId());
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function search($param) {
        $query = "SET @param = CONCAT('%',?,'%'); " .
            "SELECT * FROM genres WHERE name LIKE @param " .
            "OR state = (CASE WHEN 'activo' LIKE @param THEN 1 WHEN 'inactivo' LIKE @param THEN 0 END)";
        $params = array($param);
        return Model\Connection::select($query, $params);
    }
}