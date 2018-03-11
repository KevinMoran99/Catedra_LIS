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

class StorePages implements Interfaces\ModelInterface
{
    private $id;
    private $game;
    private $releaseDate;
    private $visible;
    private $price;
    private $discount;

    /**
     * StorePages constructor.
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




    public function getAll(){
        $query ="SELECT * FROM store_pages";
        $params = array(null);
        return Model\Connection::select($query,$params);
    }

    public function getById() {
        $query ="SELECT * FROM store_pages WHERE id = ?";
        $params = array($this->getId());
        return Model\Connection::selectOne($query,$params);
    }

    public function insert(){
        $query ="INSERT INTO store_pages (game_id,release_date,visible,price,discount) VALUES(?,?,?,?,?)";
        $params= array($this->getGame(),$this->getReleaseDate(),$this->getVisible(),$this->getPrice(),$this->getDiscount());
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function update(){
        $query ="UPDATE store_pages SET game_id=?,release_date=?,visible=?,price=?,discount=? WHERE id=?";
        $params= array($this->getGame(),$this->getReleaseDate(),$this->getVisible(),$this->getPrice(),$this->getDiscount(),$this->getId());
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function search($param) {
        // TODO: Implement search() method.
    }

}