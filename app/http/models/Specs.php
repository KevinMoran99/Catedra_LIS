<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 9/3/2018
 * Time: 11:38 PM
 */

namespace Http\Models;
require ("../../../vendor/autoload.php");
use Http\Models as Model;
use Http\Models\Interfaces as Interfaces;

class Specs implements Interfaces\ModelInterface
{
    private $id;
    private $name;
    private $typeSpec;
    private $state=1;

    /**
     * Specs constructor.
     * @param $id
     * @param $name
     * @param $typeSpec
     * @param int $state
     */
    public function __construct($id, $name, $typeSpec, $state)
    {
        $this->id = $id;
        $this->name = $name;
        $this->typeSpec = $typeSpec;
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
    public function getTypeSpec()
    {
        return $this->typeSpec;
    }

    /**
     * @param mixed $typeSpec
     */
    public function setTypeSpec($typeSpec)
    {
        $this->typeSpec = $typeSpec;
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
        $query ="SELECT * FROM specs";
        $params = array(null);
        return Model\Connection::select($query,$params);
    }

    public function getById() {
        $query ="SELECT * FROM specs WHERE id = ?";
        $params = array($this->getId());
        return Model\Connection::selectOne($query,$params);
    }

    public function insert(){
        $query ="INSERT INTO specs (name,type_spec_id,state) VALUES(?,?,?)";
        $params= array($this->getName(),$this->getTypeSpec(),$this->getState());
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function update(){
        $query ="UPDATE specs SET name=?,type_spec_id=?,state=? WHERE id=?";
        $params= array($this->getName(),$this->getTypeSpec(),$this->getState(),$this->getId());
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function search($param) {
        $query = "SET @param = CONCAT('%',?,'%'); " .
                 "SELECT s.*, t.name FROM specs s INNER JOIN type_specs t ON s.type_spec_id = t.id " .
				 "WHERE s.name LIKE @param OR t.name LIKE @param " .
                 "OR s.state = (CASE WHEN 'activo' LIKE @param THEN 1 WHEN 'inactivo' LIKE @param THEN 0 END)";
        $params = array($param);
        return Model\Connection::select($query, $params);
    }
}