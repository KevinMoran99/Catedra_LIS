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


class UserType implements Interfaces\ModelInterface, \JsonSerializable
{
    private $id;
    private $name;
    private $state=1;
    private $games;
    private $users;
    private $support;
    private $stadistics;
    private $reviews;
    private $esrbs;
    private $publishers;
    private $genres;
    private $specs;
    private $typeSpecs;

    /**
     * Action constructor.
     * @param $id
     * @param $name
     * @param int $state
     */
    public function init($id, $name, $state, $games, $users, $support, $stadistics, 
                        $reviews, $esrbs, $publishers, $genres, $specs, $typeSpecs)
    {
        $this->id = $id;
        $this->name = $name;
        $this->games = $games;
        $this->users = $users;
        $this->support = $support;
        $this->stadistics = $stadistics;
        $this->reviews = $reviews;
        $this->esrbs = $esrbs;
        $this->publishers = $publishers;
        $this->genres = $genres;
        $this->specs = $specs;
        $this->typeSpecs = $typeSpecs;
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

    /**
     * @return mixed
     */
    public function getGames()
    {
        return $this->games;
    }

    /**
     * @param mixed $games
     */
    public function setGames($games)
    {
        $this->games = $games;
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param mixed $users
     */
    public function setUsers($users)
    {
        $this->users = $users;
    }

    /**
     * @return mixed
     */
    public function getSupport()
    {
        return $this->support;
    }

    /**
     * @param mixed $support
     */
    public function setSupport($support)
    {
        $this->support = $support;
    }

    /**
     * @return mixed
     */
    public function getStadistics()
    {
        return $this->stadistics;
    }

    /**
     * @param mixed $stadistics
     */
    public function setStadistics($stadistics)
    {
        $this->stadistics = $stadistics;
    }

    /**
     * @return mixed
     */
    public function getReviews()
    {
        return $this->reviews;
    }

    /**
     * @param mixed $reviews
     */
    public function setReviews($reviews)
    {
        $this->reviews = $reviews;
    }

    /**
     * @return mixed
     */
    public function getEsrbs()
    {
        return $this->esrbs;
    }

    /**
     * @param mixed $esrbs
     */
    public function setEsrbs($esrbs)
    {
        $this->esrbs = $esrbs;
    }

    /**
     * @return mixed
     */
    public function getPublishers()
    {
        return $this->publishers;
    }

    /**
     * @param mixed $publishers
     */
    public function setPublishers($publishers)
    {
        $this->publishers = $publishers;
    }

    /**
     * @return mixed
     */
    public function getGenres()
    {
        return $this->genres;
    }

    /**
     * @param mixed $genres
     */
    public function setGenres($genres)
    {
        $this->genres = $genres;
    }

    /**
     * @return mixed
     */
    public function getSpecs()
    {
        return $this->specs;
    }

    /**
     * @param mixed $specs
     */
    public function setSpecs($specs)
    {
        $this->specs = $specs;
    }

    /**
     * @return mixed
     */
    public function getTypeSpecs()
    {
        return $this->typeSpecs;
    }

    /**
     * @param mixed $typeSpecs
     */
    public function setTypeSpecs($typeSpecs)
    {
        $this->typeSpecs = $typeSpecs;
    }


    //Query methods

    /**
     * @param boolean $active: Si se quieren solamente los registros activos
     * @param boolean $modifiable: Si se quieren solamente los registros modificables (osea todos menos admin y cliente)
     */
    public function getAll($active = false, $modifiable = false){
        $query ="SELECT * FROM user_types WHERE id = id";

        if ($active)
            $query = $query . " AND state = 1";
        if ($modifiable)
            $query = $query . " AND id > 2";

        $params = array(null);
        //Array de objetos devueltos
        $result = [];
        //Recorriendo resultados
        foreach(Model\Connection::select($query,$params) as $line) {
            $userType = new UserType();
            $userType->init(
                $line["id"], 
                $line["name"], 
                $line["state"], 
                $line["games"], 
                $line["users"], 
                $line["support"], 
                $line["stadistics"], 
                $line["reviews"], 
                $line["esrbs"], 
                $line["publishers"], 
                $line["genres"], 
                $line["specs"], 
                $line["type_specs"]
            );
            array_push($result, $userType);
        }
        return $result;
    }

    public function getById() {
        $query ="SELECT * FROM user_types WHERE id = ?";
        $params = array($this->getId());
        $userType = Model\Connection::selectOne($query,$params);
        $this->init(
            $userType["id"], 
            $userType["name"], 
            $userType["state"], 
            $userType["games"], 
            $userType["users"], 
            $userType["support"], 
            $userType["stadistics"], 
            $userType["reviews"], 
            $userType["esrbs"], 
            $userType["publishers"], 
            $userType["genres"], 
            $userType["specs"], 
            $userType["type_specs"]
        );
    }

    public function insert(){
        $query ="INSERT INTO user_types (name,state,games, users, support, stadistics, reviews, esrbs, publishers, genres, specs, type_specs) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
        $params= array(
            $this->getName(),
            $this->getState(),
            $this->getGames(),
            $this->getUsers(),
            $this->getSupport(),
            $this->getStadistics(),
            $this->getReviews(),
            $this->getEsrbs(),
            $this->getPublishers(),
            $this->getGenres(),
            $this->getSpecs(),
            $this->getTypeSpecs()
        );
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function update(){
        $query ="UPDATE user_types SET name=?,state=?,games=?,users=?,support=?,stadistics=?,reviews=?,
        esrbs=?,publishers=?,genres=?,specs=?,type_specs=? WHERE id=?";
        $params= array(
            $this->getName(),
            $this->getState(),
            $this->getGames(),
            $this->getUsers(),
            $this->getSupport(),
            $this->getStadistics(),
            $this->getReviews(),
            $this->getEsrbs(),
            $this->getPublishers(),
            $this->getGenres(),
            $this->getSpecs(),
            $this->getTypeSpecs(),
            $this->getId()
        );
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function search($param) {
        $query = "SELECT * FROM user_types WHERE name LIKE CONCAT('%',?,'%') " .
                 "OR state = (CASE WHEN 'activo' LIKE CONCAT('%',?,'%') THEN 1 WHEN 'inactivo' LIKE CONCAT('%',?,'%') THEN 0 END)
                 AND id > 2";
        $params = array($param,$param,$param);
        //Array de objetos devueltos
        $result = [];
        //Recorriendo resultados
        foreach(Model\Connection::select($query,$params) as $line) {
            $userType = new UserType();
            $userType->init(
                $line["id"], 
                $line["name"], 
                $line["state"], 
                $line["games"], 
                $line["users"], 
                $line["support"], 
                $line["stadistics"], 
                $line["reviews"], 
                $line["esrbs"], 
                $line["publishers"], 
                $line["genres"], 
                $line["specs"], 
                $line["type_specs"]
            );
            array_push($result, $userType);
        }
        return $result;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'state' => $this->getState(),
            'games' => $this->getGames(),
            'users' => $this->getUsers(),
            'support' => $this->getSupport(),
            'stadistics' => $this->getStadistics(),
            'reviews' => $this->getReviews(),
            'esrbs' => $this->getEsrbs(),
            'publishers' => $this->getPublishers(),
            'genres' => $this->getGenres(),
            'specs' => $this->getSpecs(),
            'typeSpecs' => $this->getTypeSpecs()
        ];
    }
}