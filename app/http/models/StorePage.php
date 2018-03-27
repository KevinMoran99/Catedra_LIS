<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 10/3/2018
 * Time: 12:04 AM
 */

namespace Http\Models;
//require ("../../../vendor/autoload.php");
use Http\Models as Model;
use Http\Models\Interfaces as Interfaces;

class StorePage implements Interfaces\ModelInterface, \JsonSerializable
{
    private $id;
    private $game;
    private $releaseDate;
    private $visible;
    private $price;
    private $discount;
    private $dominantColor;

    /**
     * StorePage constructor.
     * @param $id
     * @param $game
     * @param $releaseDate
     * @param $visible
     * @param $price
     * @param $discount
     */
    public function init($id, $game, $releaseDate, $visible, $price, $discount)
    {
        $this->id = $id;
        $this->game = $game;
        $this->releaseDate = $releaseDate;
        $this->visible = $visible;
        $this->price = $price;
        $this->discount = $discount;
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
    public function getGame()
    {
        return $this->game;
    }

    /**
     * @param mixed $game
     */
    public function setGame($game)
    {
        $this->game = $game;
    }

    /**
     * @return mixed
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * @param mixed $releaseDate
     */
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;
    }

    /**
     * @return mixed
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * @param mixed $visible
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param mixed $discount
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
    }

    public function getFinalPrice()
    {
        return $this->price - ($this->price * ($this->discount/100));
    }

    /**
     * @return mixed
     */
    public function getDominantColor()
    {
        return $this->dominantColor;
    }

    /**
     * @param mixed $dominantColor
     */
    public function setDominantColor($dominantColor)
    {
        $this->dominantColor = $dominantColor;
    }




    public function getAll($active = false){
        if ($active)
            $query ="SELECT * FROM store_pages WHERE visible = 1 ORDER BY id DESC";
        else
            $query ="SELECT * FROM store_pages ORDER BY id DESC";
        $params = array(null);
        //Array de objetos devueltos
        $result = [];
        //Recorriendo resultados
        foreach(Model\Connection::select($query,$params) as $line) {
            //Padres
            $pGame = (new Game());
            $pGame->setId($line["game_id"]);
            $pGame->getById();

            //Registro
            $page = (new StorePage());
            $page->init($line["id"], $pGame, new \DateTime($line["release_date"]),$line['visible'], $line["price"], $line["discount"]);

            array_push($result, $page);
        }
        return $result;
    }

    public function getTop3($active = false){
        if ($active)
            $query ="SELECT * FROM store_pages WHERE visible = 1 ORDER BY id DESC LIMIT 3";
        else
            $query ="SELECT * FROM store_pages ORDER BY id DESC LIMIT 3";
        $params = array(null);
        //Array de objetos devueltos
        $result = [];
        //Recorriendo resultados
        foreach(Model\Connection::select($query,$params) as $line) {
            //Padres
            $pGame = (new Game());
            $pGame->setId($line["game_id"]);
            $pGame->getById();

            //Registro
            $page = (new StorePage());
            $page->init($line["id"], $pGame, new \DateTime($line["release_date"]),$line['visible'], $line["price"], $line["discount"]);

            array_push($result, $page);
        }
        return $result;
    }

    public function getById() {
        $query ="SELECT * FROM store_pages WHERE id = ?";
        $params = array($this->getId());
        $page = Model\Connection::selectOne($query,$params);
        $this->setId($page['id']);
        $pGame = new Game();
        $pGame->setId($page['game_id']);
        $pGame->getById();
        $this->setGame($pGame);
        $this->setReleaseDate(new \DateTime($page["release_date"]));
        $this->setVisible($page['visible']);
        $this->setPrice($page['price']);
        $this->setDiscount($page['discount']);
    }

    public function getByGame(Game $pGame, $active = false){
        if ($active)
            $query ="SELECT * FROM store_pages WHERE game_id = ? AND visible = 1";
        else
            $query ="SELECT * FROM store_pages WHERE game_id = ?";
        $params = array($pGame->getId());
        //Array de objetos devueltos
        $result = [];
        //Recorriendo resultados
        foreach(Model\Connection::select($query,$params) as $line) {
            //Padres
            $pGame = (new Game());
            $pGame->setId($line["game_id"]);
            $pGame->getById();

            //Registro
            $page = (new StorePage());
            $page->init($line["id"], $pGame, new \DateTime($line["release_date"]),$line['visible'], $line["price"], $line["discount"]);

            array_push($result, $page);
        }
        return $result;
    }

    public function insert(){
        $query ="INSERT INTO store_pages (game_id,release_date,visible,price,discount) VALUES(?,?,?,?,?)";
        $params= array($this->getGame()->getId(),$this->getReleaseDate()->format('Y-m-d'),$this->getVisible(),$this->getPrice(),$this->getDiscount());
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function update(){
        $query ="UPDATE store_pages SET release_date=?,visible=?,price=?,discount=? WHERE id=?";
        $params= array($this->getReleaseDate()->format('Y-m-d'),$this->getVisible(),$this->getPrice(),$this->getDiscount(),$this->getId());
        return Model\Connection::insertOrUpdate($query,$params);
    }


    //Parámetros de tipo de búsqueda
    public static $GAME = 0;
    public static $PUBLISHER = 1;
    public static $GENRE = 2;
    public static $ESRB = 3;
    public static $SELLER = 4;
    public static $RATING = 5;
    public static $DATE = 6;
    public static $OFFER = 7;

    public function search($param, $type = false) {
        //Búsqueda por nombre
        if ($type == StorePage::$GAME) {
            $query = "SELECT * FROM store_pages WHERE game_id = ? AND visible = 1";
            $params = array($param);
        }
        //Buscar por publicador
        else if ($type == StorePage::$PUBLISHER) {
            $query = "SELECT * FROM store_pages sp INNER JOIN games g ON sp.game_id = g.id WHERE publisher_id = ? AND visible = 1";
            $params = array($param);
        }
        //Buscar por genero
        else if ($type == StorePage::$GENRE) {
            $query = "SELECT * FROM store_pages sp INNER JOIN games g ON sp.game_id = g.id WHERE genre_id = ? AND visible = 1";
            $params = array($param);
        }
        //Buscar por clasificacion
        else if ($type == StorePage::$ESRB) {
            $query = "SELECT * FROM store_pages sp INNER JOIN games g ON sp.game_id = g.id WHERE esrb_id = ? AND visible = 1";
            $params = array($param);
        }
        //Buscar más vendidos
        else if ($type == StorePage::$SELLER) {
            $query = "SELECT sp.*, bi.cnt FROM store_pages sp LEFT JOIN (SELECT store_page_id, COUNT(*) as cnt 
                      FROM bill_items GROUP BY store_page_id ) bi ON sp.id = bi.store_page_id WHERE sp.visible = 1 ORDER BY bi.cnt DESC";
            $params = array(null);
        }
        //Buscar más recomendados
        else if ($type == StorePage::$RATING) {
            $query = "SELECT sp.*, rec.cnt * 100 / tot.cnt as percent FROM store_pages sp 
                      LEFT JOIN (SELECT bi.store_page_id, COUNT(*) cnt FROM ratings r INNER JOIN bill_items bi ON r.bill_item_id = bi.id 
                      WHERE recommended = 1 GROUP BY store_page_id) rec ON sp.id = rec.store_page_id
                      LEFT JOIN (SELECT bi.store_page_id, COUNT(*) cnt FROM ratings r INNER JOIN bill_items bi ON r.bill_item_id = bi.id 
                      GROUP BY store_page_id) tot ON sp.id = tot.store_page_id WHERE sp.visible = 1 ORDER BY percent DESC";
            $params = array(null);
        }
        //Buscar más recientes
        else if ($type == StorePage::$DATE) {
            $query = "SELECT * FROM store_pages WHERE visible = 1 ORDER BY release_date DESC";
            $params = array(null);
        }
        //Buscar en descuento
        else if ($type == StorePage::$OFFER) {
            $query = "SELECT * FROM store_pages WHERE visible = 1 ORDER BY discount DESC";
            $params = array(null);
        }
        //Array de objetos devueltos
        $result = [];
        //Recorriendo resultados
        foreach(Model\Connection::select($query,$params) as $line) {
            //Padres
            $pGame = (new Game());
            $pGame->setId($line["game_id"]);
            $pGame->getById();

            //Registro
            $page = (new StorePage());
            $page->init($line["id"], $pGame, new \DateTime($line["release_date"]),$line['visible'], $line["price"], $line["discount"]);

            array_push($result, $page);
        }
        return $result;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'game' => [
                'id' => $this->getGame()->getId(),
                'name' => $this->getGame()->getName(),
                'cover' => $this->getGame()->getCover(),
                'banner'=>$this->getGame()->getBanner(),
                'description' => $this->getGame()->getDescription(),
                'esrb' => [
                    'id' => $this->getGame()->getEsrb()->getId(),
                    'name' => $this->getGame()->getEsrb()->getName(),
                ],
                'publisher' => [
                    'id' => $this->getGame()->getPublisher()->getId(),
                    'name' => $this->getGame()->getPublisher()->getName(),
                ],
                'genre' => [
                    'id' => $this->getGame()->getGenre()->getId(),
                    'name' => $this->getGame()->getGenre()->getName(),
                ],
            ],
            'releaseDate' => $this->getReleaseDate()->format('Y-m-d'),
            'visible'=> $this->getVisible(),
            'price' => $this->getPrice(),
            'discount' => $this->getDiscount()
        ];
    }

}