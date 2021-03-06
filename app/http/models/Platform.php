<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 9/3/2018
 * Time: 10:55 PM
 */

namespace Http\Models;
//require ("../../../vendor/autoload.php");
use Http\Models as Model;
use Http\Models\Interfaces as Interfaces;

class Platform implements Interfaces\ModelInterface, \JsonSerializable
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

    public function getAll($active = false){
        if ($active)
            $query ="SELECT * FROM platforms WHERE state = 1";
        else
            $query ="SELECT * FROM platforms";
        $params = array(null);
        //Array de objetos devueltos
        $result = [];
        //Recorriendo resultados
        foreach(Model\Connection::select($query,$params) as $line) {
            $platform = new Platform();
            $platform->init($line["id"], $line["name"], $line["state"]);
            array_push($result, $platform);
        }
        return $result;
}

    public function getById() {
        $query ="SELECT * FROM platforms WHERE id = ?";
        $params = array($this->getId());
        $platform = Model\Connection::selectOne($query,$params);
        $this->setId($platform['id']);
        $this->setName($platform['name']);
        $this->setState($platform['state']);
}

    public function insert(){
    $query ="INSERT INTO platforms (name,state) VALUES(?,?)";
    $params= array($this->getName(),$this->getState());
    return Model\Connection::insertOrUpdate($query,$params);
}

    public function update(){
    $query ="UPDATE platforms SET name=?,state=? WHERE id=?";
    $params= array($this->getName(),$this->getState(),$this->getId());
    return Model\Connection::insertOrUpdate($query,$params);
}

    public function search($param) {
        $query = "SELECT * FROM platforms WHERE name LIKE CONCAT('%',?,'%') " .
            "OR state = (CASE WHEN 'activo' LIKE CONCAT('%',?,'%') THEN 1 WHEN 'inactivo' LIKE CONCAT('%',?,'%') THEN 0 END)";
        $params = array($param, $param, $param);
        //Array de objetos devueltos
        $result = [];
        //Recorriendo resultados
        foreach(Model\Connection::select($query,$params) as $line) {
            $platform = new Platform();
            $platform->init($line["id"], $line["name"], $line["state"]);
            array_push($result, $platform);
        }
        return $result;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'state' => $this->getState()
        ];
    }
}