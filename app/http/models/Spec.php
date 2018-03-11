<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 9/3/2018
 * Time: 11:38 PM
 */

namespace Http\Models;
//require ("../../../vendor/autoload.php");
use Http\Models as Model;
use Http\Models\Interfaces as Interfaces;

class Spec implements Interfaces\ModelInterface
{
    private $id;
    private $name;
    private $typeSpec;
    private $state=1;

    /**
     * Spec constructor.
     * @param $id
     * @param $name
     * @param $typeSpec
     * @param int $state
     */
    public function init($id, $name, $typeSpec, $state)
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
        //Array de objetos devueltos
        $result = [];
        //Recorriendo resultados
        foreach(Model\Connection::select($query,$params) as $line) {
            //padres
            $pTypeSpec = new TypeSpec();
            $pTypeSpec->setId($line["type_spec_id"]);
            $pTypeSpec->getById();

            //registro
            $spec = new Spec();
            $spec->init($line["id"], $line["name"], $pTypeSpec, $line["state"]);
            array_push($result, $spec);
        }
        return $result;
    }

    public function getById() {
        $query ="SELECT * FROM specs WHERE id = ?";
        $params = array($this->getId());
        $spec = Model\Connection::selectOne($query,$params);
        $this->setId($spec['id']);
        $this->setName($spec['name']);
            $pTypeSpec = new TypeSpec();
            $pTypeSpec->setId($spec["type_spec_id"]);
            $pTypeSpec->getById();
        $this->setTypeSpec($pTypeSpec);
        $this->setState($spec['state']);
    }

    public function insert(){
        $query ="INSERT INTO specs (name,type_spec_id,state) VALUES(?,?,?)";
        $params= array($this->getName(),$this->getTypeSpec()->getId(),$this->getState());
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function update(){
        $query ="UPDATE specs SET name=?,type_spec_id=?,state=? WHERE id=?";
        $params= array($this->getName(),$this->getTypeSpec()->getId(),$this->getState(),$this->getId());
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function search($param) {
        $query = "SELECT s.* FROM specs s INNER JOIN type_specs t ON s.type_spec_id = t.id " .
				 "WHERE s.name LIKE CONCAT('%',?,'%') OR t.name LIKE CONCAT('%',?,'%') " .
                 "OR s.state = (CASE WHEN 'activo' LIKE CONCAT('%',?,'%') THEN 1 WHEN 'inactivo' LIKE CONCAT('%',?,'%') THEN 0 END)";
        $params = array($param,$param,$param,$param);
        //Array de objetos devueltos
        $result = [];
        //Recorriendo resultados
        foreach(Model\Connection::select($query,$params) as $line) {
            //padres
            $pTypeSpec = new TypeSpec();
            $pTypeSpec->setId($line["type_spec_id"]);
            $pTypeSpec->getById();

            //registro
            $spec = new Spec();
            $spec->init($line["id"], $line["name"], $pTypeSpec, $line["state"]);
            array_push($result, $spec);
        }
        return $result;
    }
}