<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 9/3/2018
 * Time: 11:51 PM
 */

namespace Http\Models;
//require ("../../../vendor/autoload.php");
use Http\Models as Model;
use Http\Models\Interfaces as Interfaces;

class Game implements Interfaces\ModelInterface
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

    private $pictures;

    private $banner;


    //Parámetros de tipo de búsqueda
    public static $ESRB = 1;
    public static $PUBLISHER = 2;
    public static $GENRE = 3;
    public static $PLATFORM = 4;

    /**
     * Game constructor.
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
    public function init($id, $name, $cover,$banner, $description, $esrb, $publisher, $genre, $platform, $state)
    {
        $this->id = $id;
        $this->name = $name;
        $this->cover = $cover;
        $this->banner=$banner;
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
    public function getBanner()
    {
        return $this->banner;
    }

    /**
     * @param mixed $banner
     */
    public function setBanner($banner)
    {
        $this->banner = $banner;
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

    /**
     * @return mixed
     */
    public function getPictures()
    {
        return $this->pictures;
    }

    /**
     * @param mixed $pictures
     */
    public function setPictures($pictures)
    {
        $this->pictures = $pictures;
    }



    public function getAll($active = false){
        if ($active)
            $query ="SELECT * FROM games WHERE state = 1";
        else
            $query ="SELECT * FROM games";
        $params = array(null);
        //Array de objetos devueltos
        $result = [];
        //Recorriendo resultados
        foreach(Model\Connection::select($query,$params) as $line) {
            //Padres
            $pEsrb = (new Esrb());
            $pEsrb->setId($line["esrb_id"]);
            $pEsrb->getById();
            $pPublisher = new Publisher();
            $pPublisher->setId($line["publisher_id"]);
            $pPublisher->getById();
            $pGenre = new Genre();
            $pGenre->setId($line["genre_id"]);
            $pGenre->getById();
            $pPlatform = new Platform();
            $pPlatform->setId($line["platform_id"]);
            $pPlatform->getById();

            //Registro
            $game = (new Game());
            $game->init($line["id"], $line["name"], $line["cover"],$line['banner'], $line["description"], $pEsrb, $pPublisher, $pGenre, $pPlatform, $line["state"]);

            //Hijos
           /* $cPictures = (new Picture())->getByGame($game);

            $game->setPictures($cPictures);*/

            array_push($result, $game);
        }
        return $result;
    }

    public function getAllPublic(){
        $query ="SELECT * FROM games WHERE state = 1 ORDER BY id desc";
        $params = array(null);
        //Array de objetos devueltos
        $result = [];
        //Recorriendo resultados
        foreach(Model\Connection::select($query,$params) as $line) {
            //Padres
            $pEsrb = (new Esrb());
            $pEsrb->setId($line["esrb_id"]);
            $pEsrb->getById();
            $pPublisher = new Publisher();
            $pPublisher->setId($line["publisher_id"]);
            $pPublisher->getById();
            $pGenre = new Genre();
            $pGenre->setId($line["genre_id"]);
            $pGenre->getById();
            $pPlatform = new Platform();
            $pPlatform->setId($line["platform_id"]);
            $pPlatform->getById();

            //Registro
            $game = (new Game());
            $game->init($line["id"], $line["name"], $line["cover"], $line['banner'],$line["description"], $pEsrb, $pPublisher, $pGenre, $pPlatform, $line["state"]);

            //Hijos
            //$cPictures = (new Picture())->getByGame($game);

            //$game->setPictures($cPictures);

            array_push($result, $game);
        }
        return $result;
    }

    public function getById()
    {
        $query ="SELECT * FROM games WHERE id = ?";
        $params = array($this->getId());
        $game = Model\Connection::selectOne($query,$params);
        $this->setId($game['id']);
        $this->setName($game['name']);
        $this->setCover($game['cover']);
        $this->setBanner($game['banner']);
        $this->setDescription($game['description']);
            $pEsrb = new Esrb();
            $pEsrb->setId($game["esrb_id"]);
            $pEsrb->getById();
        $this->setEsrb($pEsrb);
            $pPublisher = new Publisher();
            $pPublisher->setId($game["publisher_id"]);
            $pPublisher->getById();
        $this->setPublisher($pPublisher);
            $pGenre = new Genre();
            $pGenre->setId($game["genre_id"]);
            $pGenre->getById();
        $this->setGenre($pGenre);
            $pPlatform = new Platform();
            $pPlatform->setId($game["platform_id"]);
            $pPlatform->getById();
        $this->setPlatform($pPlatform);
        $this->setState($game['state']);
           // $cPictures = (new Picture())->getByGame($this);
        //$this->setPictures($cPictures);
    }

    public function insert()
    {
        $query ="INSERT INTO games (name, cover, banner, description, esrb_id, publisher_id, genre_id, platform_id, state) VALUES(?,?,?,?,?,?,?,?,?)";
        $params= array($this->getName(),$this->getCover(),$this->getBanner(),$this->getDescription(),$this->getEsrb()->getId(),$this->getPublisher()->getId(),
                        $this->getGenre()->getId(),$this->getPlatform()->getId(),$this->getState());
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function update()
    {
        $query ="UPDATE games SET name=?,cover=?,banner=?,description=?,esrb_id=?,publisher_id=?,genre_id=?,platform_id=?,state=? WHERE id=?";
        $params= array($this->getName(),$this->getCover(),$this->getBanner(),$this->getDescription(),$this->getEsrb()->getId(),$this->getPublisher()->getId(),
                        $this->getGenre()->getId(),$this->getPlatform()->getId(),$this->getState(),$this->getId());
        return Model\Connection::insertOrUpdate($query,$params);
    }


    public function search($param, $field = false)
    {
        //Búsqueda maestra
        if (!$field) {
            $query = "SELECT g.*  FROM games g INNER JOIN esrbs e ON g.esrb_id = e.id 
                      INNER JOIN publishers pu ON g.publisher_id = pu.id INNER JOIN genres ge ON g.genre_id = ge.id 
                      INNER JOIN platforms pl ON g.platform_id = pl.id
                      WHERE g.name LIKE CONCAT('%',?,'%') OR g.description LIKE CONCAT('%',?,'%') 
                      OR e.name LIKE CONCAT('%',?,'%') OR pu.name LIKE CONCAT('%',?,'%') 
                      OR ge.name LIKE CONCAT('%',?,'%') OR pl.name LIKE CONCAT('%',?,'%')
                      OR g.state = (CASE WHEN 'activo' LIKE CONCAT('%',?,'%') THEN 1 WHEN 'inactivo' LIKE CONCAT('%',?,'%') THEN 0 END)";
            $params = array($param, $param, $param, $param, $param, $param, $param, $param);
        }
        //Buscar por clasificacion
        else if ($field == Game::$ESRB) {
            $query = "SELECT *  FROM games WHERE esrb_id = ?";
            $params = array($param);
        }
        //Buscar por publicador
        else if ($field == Game::$PUBLISHER) {
            $query = "SELECT *  FROM games WHERE publisher_id = ?";
            $params = array($param);
        }
        //Buscar por genero
        else if ($field == Game::$GENRE) {
            $query = "SELECT *  FROM games WHERE genre_id = ?";
            $params = array($param);
        }
        //Buscar por plataforma
        else if ($field == Game::$PLATFORM) {
            $query = "SELECT *  FROM games WHERE platform_id = ?";
            $params = array($param);
        }
        //Array de objetos devueltos
        $result = [];
        //Recorriendo resultados
        foreach(Model\Connection::select($query,$params) as $line) {
            //Padres
            $pEsrb = (new Esrb());
            $pEsrb->setId($line["esrb_id"]);
            $pEsrb->getById();
            $pPublisher = new Publisher();
            $pPublisher->setId($line["publisher_id"]);
            $pPublisher->getById();
            $pGenre = new Genre();
            $pGenre->setId($line["genre_id"]);
            $pGenre->getById();
            $pPlatform = new Platform();
            $pPlatform->setId($line["platform_id"]);
            $pPlatform->getById();

            //Registro
            $game = (new Game());
            $game->init($line["id"], $line["name"], $line["cover"],$line['banner'] ,$line["description"], $pEsrb, $pPublisher, $pGenre, $pPlatform, $line["state"]);

            //Hijos
            /*$cPictures = (new Picture())->getByGame($game);

            $game->setPictures($cPictures);*/

            array_push($result, $game);
        }
        return $result;

    }

}