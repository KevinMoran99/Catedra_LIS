<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 10/3/2018
 * Time: 12:09 AM
 */

namespace Http\Models;
require ("../../../vendor/autoload.php");
use Http\Models as Model;
use Http\Models\Interfaces as Interfaces;

class Faqs implements Interfaces\ModelInterface
{
    private $id;
    private $title;
    private $description;
    private $storePage;
    private $state;

    /**
     * Faqs constructor.
     * @param $id
     * @param $title
     * @param $description
     * @param $storePage
     * @param $state
     */
    public function init($id, $title, $description, $storePage, $state)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->storePage = $storePage;
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getStorePage()
    {
        return $this->storePage;
    }

    /**
     * @param mixed $storePage
     */
    public function setStorePage($storePage)
    {
        $this->storePage = $storePage;
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




    public function getAll(){
        $query ="SELECT * FROM faqs";
        $params = array(null);
        return Model\Connection::select($query,$params);
    }

    public function getById() {
        $query ="SELECT * FROM faqs WHERE id = ?";
        $params = array($this->getId());
        return Model\Connection::selectOne($query,$params);
    }

    public function insert(){
        $query ="INSERT INTO faqs (title,description,store_page_id,state) VALUES(?,?,?,?)";
        $params= array($this->getTitle(),$this->getDescription(),$this->getStorePage(),$this->getState());
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function update(){
        $query ="UPDATE faqs SET title=?,description=?,store_page_id=?,state=? WHERE id=?";
        $params= array($this->getTitle(),$this->getDescription(),$this->getStorePage(),$this->getState(),$this->getId());
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function search($param) {
        $query = "SET @param = CONCAT('%','act','%'); " .
                 "SELECT * FROM faqs WHERE title LIKE @param OR description LIKE @param " .
                 "OR state = (CASE WHEN 'activo' LIKE @param THEN 1 WHEN 'inactivo' LIKE @param THEN 0 END)";
        $params = array($param);
        return Model\Connection::select($query, $params);
    }
}