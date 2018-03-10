<?php
/**
 * Created by PhpStorm.
 * User: ara
 * Date: 3/9/18
 * Time: 11:52 a.m.
 */

namespace Http\Models;
//include_once ("../../../vendor/autoload.php");

use Http\Models as Model;
use Http\Models\Interfaces as Interfaces;

class Action implements Interfaces\ModelInterface
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
        $query ="SELECT * FROM actions";
        $params = array(null);
        return Model\Connection::select($query,$params);
    }

    public function getById() {
        $query ="SELECT * FROM actions WHERE id = ?";
        $params = array($this->getId());
        return Model\Connection::selectOne($query,$params);
    }

    public function insert(){
        $query ="INSERT INTO actions (name,state) VALUES(?,?)";
        $params= array($this->getName(),$this->getState());
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function update(){
        $query ="UPDATE actions SET name=?,state=? WHERE id=?";
        $params= array($this->getName(),$this->getState(),$this->getId());
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function search($param) {
        $query = "SET @param = CONCAT('%',?,'%'); " .
                 "SELECT * FROM actions WHERE name LIKE @param " .
                 "OR state = (CASE WHEN 'activo' LIKE @param THEN 1 WHEN 'inactivo' LIKE @param THEN 0 END)";
        $params = array($param);
        return Model\Connection::select($query, $params);
    }

}