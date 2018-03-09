<?php
/**
 * Created by PhpStorm.
 * User: ara
 * Date: 3/9/18
 * Time: 11:52 a.m.
 */

namespace Http\Models;
require ("../../../vendor/autoload.php");
use Http\Models as Model;

class Action
{
    private $id;
    private $name;
    private $state=1;


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

    public function getActions(){
        $query ="SELECT * FROM actions";
        $params = array(null);
        return Model\Connection::select($query,$params);
    }

    public function insertAction(){
        $query ="INSERT INTO actions (name,state) VALUES(?,?)";
        $params= array($this->getName(),$this->getState());
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function updateAction(){
        $query ="UPDATE actions SET name=?,state=? WHERE id=?";
        $params= array($this->getName(),$this->getState(),$this->getId());
        return Model\Connection::insertOrUpdate($query,$params);
    }

}