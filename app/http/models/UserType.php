<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 9/3/2018
 * Time: 8:37 PM
 */

namespace Http\Models;
//require ("../../../vendor/autoload.php");
use Http\Models as Model;
use Http\Models\Interfaces as Interfaces;


class UserType implements Interfaces\ModelInterface
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


    //Query methods

    public function getAll() {
        $query ="SELECT * FROM user_types";
        $params = array(null);
        return Model\Connection::select($query,$params);
    }

    public function getById() {
        $query ="SELECT * FROM user_types WHERE id = ?";
        $params = array($this->getId());
        $userType = Model\Connection::selectOne($query,$params);
        $this->setId($userType['id']);
        $this->setName($userType['name']);
        $this->setState($userType['state']);
    }

    public function insert(){
        $query ="INSERT INTO user_types (name,state) VALUES(?,?)";
        $params= array($this->getName(),$this->getState());
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function update(){
        $query ="UPDATE user_types SET name=?,state=? WHERE id=?";
        $params= array($this->getName(),$this->getState(),$this->getId());
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function search($param) {
        $query = "SET @param = CONCAT('%',?,'%'); " .
            "SELECT * FROM user_types WHERE name LIKE @param " .
            "OR state = (CASE WHEN 'activo' LIKE @param THEN 1 WHEN 'inactivo' LIKE @param THEN 0 END)";
        $params = array($param);
        return Model\Connection::select($query, $params);
    }
}