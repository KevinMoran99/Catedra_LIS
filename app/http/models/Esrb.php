<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 9/3/2018
 * Time: 10:38 PM
 */

namespace Http\Models;
//require ("../../../vendor/autoload.php");
use Http\Models as Model;
use Http\Models\Interfaces as Interfaces;

class Esrb implements Interfaces\ModelInterface, \JsonSerializable
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
            $query ="SELECT * FROM esrbs WHERE state = 1";
        else
            $query ="SELECT * FROM esrbs";
        $params = array(null);
        //Array de objetos devueltos
        $result = [];
        //Recorriendo resultados
        foreach(Model\Connection::select($query,$params) as $line) {
            $esrb = new Esrb();
            $esrb->init($line["id"], $line["name"], $line["state"]);
            array_push($result, $esrb);
        }
        return $result;
    }

    public function getById() {
        $query ="SELECT * FROM esrbs WHERE id = ?";
        $params = array($this->getId());
        $esrb = Model\Connection::selectOne($query,$params);
        $this->setId($esrb['id']);
        $this->setName($esrb['name']);
        $this->setState($esrb['state']);
    }

    public function insert(){
        $query ="INSERT INTO esrbs (name,state) VALUES(?,?)";
        $params= array($this->getName(),$this->getState());
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function update(){
        $query ="UPDATE esrbs SET name=?,state=? WHERE id=?";
        $params= array($this->getName(),$this->getState(),$this->getId());
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function search($param) {
        $query = "SELECT * FROM esrbs WHERE name LIKE CONCAT('%',?,'%') " .
            "OR state = (CASE WHEN 'activo' LIKE CONCAT('%',?,'%') THEN 1 WHEN 'inactivo' LIKE CONCAT('%',?,'%') THEN 0 END)";
        $params = array($param, $param, $param);
        //Array de objetos devueltos
        $result = [];
        //Recorriendo resultados
        foreach(Model\Connection::select($query,$params) as $line) {
            $esrb = new Esrb();
            $esrb->init($line["id"], $line["name"], $line["state"]);
            array_push($result, $esrb);
        }
        return $result;
    }

    //OJO: Esta función devuelve un array que contiene dos arrays: Uno con los nombres de las clasificaciones
    //y el otro con la cantidad de juegos de cada clasificacion, en orden
    //NO devuelve un array de objetos del tipo Esrb
    public function getChartInfo() {
        $query ="SELECT e.name AS esrb, COUNT(g.id) AS count FROM esrbs e LEFT JOIN games g ON e.id = g.esrb_id GROUP BY e.name";
        $params = array(null);
        //Arrays de datos devueltos
        $esrb = [];
        $count = [];
        //Recorriendo resultados
        foreach(Model\Connection::select($query,$params) as $line) {
            array_push($esrb, $line["esrb"]);
            array_push($count, $line["count"]);
        }
        $result = array(
            "esrb" => $esrb, 
            "count" => $count
        );
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