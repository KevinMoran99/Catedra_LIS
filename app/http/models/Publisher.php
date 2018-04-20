<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 9/3/2018
 * Time: 10:40 PM
 */

namespace Http\Models;
//require ("../../../vendor/autoload.php");
use Http\Models as Model;
use Http\Models\Interfaces as Interfaces;

class Publisher implements Interfaces\ModelInterface, \JsonSerializable
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
            $query ="SELECT * FROM publishers WHERE state = 1";
        else
            $query ="SELECT * FROM publishers";
        $params = array(null);
        //Array de objetos devueltos
        $result = [];
        //Recorriendo resultados
        foreach(Model\Connection::select($query,$params) as $line) {
            $publisher = new Publisher();
            $publisher->init($line["id"], $line["name"], $line["state"]);
            array_push($result, $publisher);
        }
        return $result;
    }

    public function getById() {
        $query ="SELECT * FROM publishers WHERE id = ?";
        $params = array($this->getId());
        $publisher = Model\Connection::selectOne($query,$params);
        $this->setId($publisher['id']);
        $this->setName($publisher['name']);
        $this->setState($publisher['state']);
    }

    public function insert(){
        $query ="INSERT INTO publishers (name,state) VALUES(?,?)";
        $params= array($this->getName(),$this->getState());
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function update(){
        $query ="UPDATE publishers SET name=?,state=? WHERE id=?";
        $params= array($this->getName(),$this->getState(),$this->getId());
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function search($param) {
        $query = "SELECT * FROM publishers WHERE name LIKE CONCAT('%',?,'%') " .
                 "OR state = (CASE WHEN 'activo' LIKE CONCAT('%',?,'%') THEN 1 WHEN 'inactivo' LIKE CONCAT('%',?,'%') THEN 0 END)";
        $params = array($param,$param,$param);
        //Array de objetos devueltos
        $result = [];
        //Recorriendo resultados
        foreach(Model\Connection::select($query,$params) as $line) {
            $publisher = new Publisher();
            $publisher->init($line["id"], $line["name"], $line["state"]);
            array_push($result, $publisher);
        }
        return $result;
    }

    //OJO: Esta función devuelve un array que contiene dos arrays: Uno con los nombres de los publicadores
    //y el otro con la cantidad de juegos vendidos por cada publicador, en orden
    //NO devuelve un array de objetos del tipo Publisher
    public function getChartInfo() {
        $query ="SELECT p.name AS publisher, COUNT(bi.id) AS count FROM publishers p LEFT JOIN games g ON p.id = g.publisher_id 
                LEFT JOIN store_pages sp ON g.id = sp.game_id LEFT JOIN bill_items bi ON sp.id = bi.store_page_id 
                GROUP BY p.name";
        $params = array(null);
        //Arrays de datos devueltos
        $publisher = [];
        $count = [];
        //Recorriendo resultados
        foreach(Model\Connection::select($query,$params) as $line) {
            array_push($publisher, $line["publisher"]);
            array_push($count, $line["count"]);
        }
        $result = array(
            "publisher" => $publisher, 
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