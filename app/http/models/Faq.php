<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 10/3/2018
 * Time: 12:09 AM
 */

namespace Http\Models;
//require ("../../../vendor/autoload.php");
use Http\Models as Model;
use Http\Models\Interfaces as Interfaces;

class Faq implements Interfaces\ModelInterface, \JsonSerializable
{
    private $id;
    private $title;
    private $description;
    private $user;
    private $state;

    /**
     * Faq constructor.
     * @param $id
     * @param $title
     * @param $description
     * @param $user
     * @param $state
     */
    public function init($id, $title, $description, $user, $state)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->user = $user;
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
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
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




    public function getAll($active = false){
        if ($active)
            $query ="SELECT * FROM faqs WHERE state = 1";
        else
            $query ="SELECT * FROM faqs";
        $params = array(null);
        //Array de objetos devueltos
        $result = [];
        //Recorriendo resultados
        foreach(Model\Connection::select($query,$params) as $line) {
            //Padres
            $pUser = new User();
            $pUser->setId($line["user_id"]);
            $pUser->getById();

            $faq = new Faq();
            $faq->init($line["id"], $line["title"], $line["description"], $pUser, $line["state"]);
            array_push($result, $faq);
        }
        return $result;
    }

    public function getById() {
        $query ="SELECT * FROM faqs WHERE id = ?";
        $params = array($this->getId());
        $faq = Model\Connection::selectOne($query,$params);
        $this->setId($faq['id']);
        $this->setTitle($faq['title']);
        $this->setDescription($faq['description']);
            $pUser = new User();
            $pUser->setId($faq["user_id"]);
            $pUser->getById();
        $this->setUser($pUser);
        $this->setState($faq["state"]);
    }

    public function insert(){
        $query ="INSERT INTO faqs (title,description,user_id,state) VALUES(?,?,?,?)";
        $params= array($this->getTitle(),$this->getDescription(),$this->getUser()->getId(),$this->getState());
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function update(){
        $query ="UPDATE faqs SET title=?,description=?,state=? WHERE id=?";
        $params= array($this->getTitle(),$this->getDescription(),$this->getState(),$this->getId());
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function search($param) {
        $query = "SELECT * FROM faqs WHERE title LIKE CONCAT('%',?,'%') OR description LIKE CONCAT('%',?,'%') " .
                 "OR state = (CASE WHEN 'activo' LIKE CONCAT('%',?,'%') THEN 1 WHEN 'inactivo' LIKE CONCAT('%',?,'%') THEN 0 END)";
        $params = array($param,$param,$param,$param);
        //Array de objetos devueltos
        $result = [];
        //Recorriendo resultados
        foreach(Model\Connection::select($query,$params) as $line) {
            //Padres
            $pUser = new User();
            $pUser->setId($line["user_id"]);
            $pUser->getById();

            $faq = new Faq();
            $faq->init($line["id"], $line["title"], $line["description"], $pUser, $line["state"]);
            array_push($result, $faq);
        }
        return $result;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'state' => $this->getState()
        ];
    }
}