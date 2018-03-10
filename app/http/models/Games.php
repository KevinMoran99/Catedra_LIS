<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 9/3/2018
 * Time: 11:51 PM
 */

namespace Http\Models;
require ("../../../vendor/autoload.php");
use Http\Models as Model;
use Http\Models\Interfaces as Interfaces;

class Games implements Interfaces\ModelInterface
{
    private $id;
    private $name;
    private $cover;
    private $description;
    private $esrb;
    private $publisher;
    private $genre;
    private $platform;
    private $state;

    /**
     * Games constructor.
     * @param $id
     * @param $name
     * @param $cover
     * @param $description
     * @param $esrb
     * @param $publisher
     * @param $genre
     * @param $platform
     * @param $state
     */
    public function __construct($id, $name, $cover, $description, $esrb, $publisher, $genre, $platform, $state)
    {
        $this->id = $id;
        $this->name = $name;
        $this->cover = $cover;
        $this->description = $description;
        $this->esrb = $esrb;
        $this->publisher = $publisher;
        $this->genre = $genre;
        $this->platform = $platform;
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
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * @param mixed $cover
     */
    public function setCover($cover)
    {
        $this->cover = $cover;
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
    public function getEsrb()
    {
        return $this->esrb;
    }

    /**
     * @param mixed $esrb
     */
    public function setEsrb($esrb)
    {
        $this->esrb = $esrb;
    }

    /**
     * @return mixed
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * @param mixed $publisher
     */
    public function setPublisher($publisher)
    {
        $this->publisher = $publisher;
    }

    /**
     * @return mixed
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @param mixed $genre
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;
    }

    /**
     * @return mixed
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * @param mixed $platform
     */
    public function setPlatform($platform)
    {
        $this->platform = $platform;
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

    public function getAll()
    {
        $query ="SELECT * FROM games";
        $params = array(null);
        return Model\Connection::select($query,$params);
    }

    public function getById()
    {
        $query ="SELECT * FROM games WHERE id = ?";
        $params = array($this->getId());
        return Model\Connection::selectOne($query,$params);
    }

    public function insert()
    {
        $query ="INSERT INTO games (name, cover, description, esrb_id, publisher_id, genre_id, platform_id, state) VALUES(?,?,?,?,?,?,?,?)";
        $params= array($this->getName(),$this->getCover(),$this->getDescription(),$this->getEsrb(),$this->getPublisher(),$this->getGenre(),$this->getPlatform(),$this->getState());
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function update()
    {
        $query ="UPDATE games SET name=?,cover=?,description=?,esrb_id=?,publisher_id=?,genre_id=?,platform_id=?,state=? WHERE id=?";
        $params= array($this->getName(),$this->getCover(),$this->getDescription(),$this->getEsrb(),$this->getPublisher(),$this->getGenre(),$this->getPlatform(),$this->getState(),$this->getId());
        return Model\Connection::insertOrUpdate($query,$params);
    }


    public function search($param)
    {
        // TODO: Implement search() method.
    }
}