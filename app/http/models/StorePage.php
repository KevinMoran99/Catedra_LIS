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
use DateTime;

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
        return number_format($this->price - ($this->price * ($this->discount/100)),2);
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

    public function getDiscountGames()
    {
        $query ="SELECT name, discount, release_date FROM `store_pages` INNER JOIN games on store_pages.game_id=games.id where discount>0";
        $params = array(null);
        //Array de objetos devueltos
        $result = [];
        //Recorriendo resultados
        foreach(Model\Connection::select($query,$params) as $line) {
            //Padres
            $pGame = new Game();
            $pStorePage= new StorePage();
            $pGame->setName($line['name']);
            $pStorePage->setDiscount($line['discount']);
            $pStorePage->setReleaseDate($line['release_date']);
            $pStorePage->setGame($pGame);
            array_push($result,$pStorePage);
            
        }
        return $result;
    }

    public function getTop10Games()
    {
        $query="SELECT SUM(recommended), games.name FROM store_pages INNER JOIN games on store_pages.game_id=games.id INNER JOIN bill_items on store_pages.id=bill_items.store_page_id INNER JOIN ratings on bill_items.id=ratings.bill_item_id GROUP BY games.name ORDER BY SUM(recommended) DESC LIMIT 10";
        $params = array(null);
        //Arrays de datos devueltos
        $games = [];
         //Recorriendo resultados
         foreach(Model\Connection::select($query,$params) as $line) {
            array_push($games, array($line["name"],$line["SUM(recommended)"]));
        }
        $result = array(
            $games,
        );
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

    public function getLineChartInfo($year, $game_id) {
        $query ="SELECT sp.release_date, 
                COUNT(CASE WHEN MONTH(b.bill_date) = '1' THEN 1 END) AS jan, 
                COUNT(CASE WHEN MONTH(b.bill_date) = '2' THEN 1 END) AS feb,  
                COUNT(CASE WHEN MONTH(b.bill_date) = '3' THEN 1 END) AS mar,  
                COUNT(CASE WHEN MONTH(b.bill_date) = '4' THEN 1 END) AS apr,  
                COUNT(CASE WHEN MONTH(b.bill_date) = '5' THEN 1 END) AS may,  
                COUNT(CASE WHEN MONTH(b.bill_date) = '6' THEN 1 END) AS jun,  
                COUNT(CASE WHEN MONTH(b.bill_date) = '7' THEN 1 END) AS jul,  
                COUNT(CASE WHEN MONTH(b.bill_date) = '8' THEN 1 END) AS aug,  
                COUNT(CASE WHEN MONTH(b.bill_date) = '9' THEN 1 END) AS sep,  
                COUNT(CASE WHEN MONTH(b.bill_date) = '10' THEN 1 END) AS oct,  
                COUNT(CASE WHEN MONTH(b.bill_date) = '11' THEN 1 END) AS nov,  
                COUNT(CASE WHEN MONTH(b.bill_date) = '12' THEN 1 END) AS dece 
                FROM store_pages sp LEFT JOIN bill_items bi ON sp.id = bi.store_page_id 
                LEFT JOIN bills b ON bi.bill_id = b.id AND YEAR(b.bill_date) = ? 
                WHERE sp.game_id = ? GROUP BY sp.release_date";
        $params = array($year, $game_id);
        //Arrays de datos devueltos
        $result = [];
        $jan = 0; $feb = 0; $mar = 0; $apr = 0; $may = 0; $jun = 0; $jul = 0; $aug = 0; $sep = 0; $oct = 0; $nov = 0; $dec = 0;
        //Recorriendo resultados
        foreach(Model\Connection::select($query,$params) as $line) {
            $page = array(
                "release_date" => DateTime::createFromFormat('Y-m-d', $line["release_date"])->format('d/m/Y'),
                "jan" => $line["jan"],
                "feb" => $line["feb"],
                "mar" => $line["mar"],
                "apr" => $line["apr"],
                "may" => $line["may"],
                "jun" => $line["jun"],
                "jul" => $line["jul"],
                "aug" => $line["aug"],
                "sep" => $line["sep"],
                "oct" => $line["oct"],
                "nov" => $line["nov"],
                "dec" => $line["dece"]
            );

            array_push($result, $page);

            //Actualizando valores totales
            $jan += $line["jan"];
            $feb += $line["feb"];
            $mar += $line["mar"];
            $apr += $line["apr"];
            $may += $line["may"];
            $jun += $line["jun"];
            $jul += $line["jul"];
            $aug += $line["aug"];
            $sep += $line["sep"];
            $oct += $line["oct"];
            $nov += $line["nov"];
            $dec += $line["dece"];
        }

        $page = array(
            "release_date" => "Total",
            "jan" => $jan,
            "feb" => $feb,
            "mar" => $mar,
            "apr" => $apr,
            "may" => $may,
            "jun" => $jun,
            "jul" => $jul,
            "aug" => $aug,
            "sep" => $sep,
            "oct" => $oct,
            "nov" => $nov,
            "dec" => $dec
        );

        array_push($result, $page);

        return $result;
    }

    public function getRadarChartInfo($game_id) {
        $query ="SELECT sp.release_date, sp.price, sp.discount, COUNT(bi.id) AS sold, SUM(r.recommended) AS recommended, COUNT(r.id) AS reviews FROM store_pages sp 
        INNER JOIN games g ON sp.game_id = g.id LEFT JOIN bill_items bi ON sp.id = bi.store_page_id LEFT JOIN ratings r ON bi.id = r.bill_item_id 
        WHERE g.id = ? GROUP BY sp.release_date, sp.price, sp.discount";
        $params = array($game_id);
        //Arrays de datos devueltos
        $result = [];
        //Recorriendo resultados
        foreach(Model\Connection::select($query,$params) as $line) {
            $page = array(
                "date" => DateTime::createFromFormat('Y-m-d', $line["release_date"])->format('d/m/Y'),
                "price" => $line["price"],
                "discount" => $line["discount"],
                "sold" => $line["sold"],
                "recommended" => $line["recommended"] != null ? $line["recommended"] : 0,
                "reviews" => $line["reviews"]
            );

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