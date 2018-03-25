<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 24/3/2018
 * Time: 2:43 PM
 */

namespace Http\Models;
//require ("../../../vendor/autoload.php");
use Http\Models as Model;
use Http\Helpers as Helper;
use Http\Models\Interfaces as Interfaces;


class BillItem implements Interfaces\ModelInterface, \JsonSerializable
{
    private $id;
    private $bill;
    private $storePage;
    private $gameKey;
    private $price;
    private $discount;

    /**
     * BillItem constructor.
     * @param $id
     * @param $bill
     * @param $storePage
     * @param $gameKey
     * @param $price
     * @param $discount
     */
    public function init($id, $bill, $storePage, $gameKey, $price, $discount)
    {
        $this->id = $id;
        $this->bill = $bill;
        $this->storePage = $storePage;
        $this->gameKey = $gameKey;
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
    public function getBill()
    {
        return $this->bill;
    }

    /**
     * @param mixed $bill
     */
    public function setBill($bill)
    {
        $this->bill = $bill;
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
    public function getGameKey()
    {
        return $this->gameKey;
    }

    /**
     * @param mixed $gameKey
     */
    public function setGameKey($gameKey)
    {
        $this->gameKey = $gameKey;
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



    public function getAll($active = false)
    {
        $query = "SELECT * FROM bill_items";
        $params = array(null);
        //Array de objetos devueltos
        $result = [];
        //Recorriendo resultados
        foreach(Model\Connection::select($query,$params) as $line) {
            //Padres
            $pBill = new Bill();
            $pBill->setId($line['bill_id']);
            $pBill->getById();

            $pPage = new StorePage();
            $pPage->setId($line['store_page_id']);
            $pPage->getById();

            //Registro
            $item = new BillItem();
            $item->init($line["id"], $pBill, $pPage, $line["game_key"], $line["price"], $line["discount"]);
            array_push($result, $item);
        }
        return $result;
    }

    public function getById()
    {
        $query ="SELECT * FROM bill_items WHERE id = ?";
        $params = array($this->getId());
        $item = Model\Connection::selectOne($query,$params);
        //Padres
        $pBill = new Bill();
        $pBill->setId($item['bill_id']);
        $pBill->getById();

        $pPage = new StorePage();
        $pPage->setId($item['store_page_id']);
        $pPage->getById();

        $this->init($item["id"], $pBill, $pPage, $item["game_key"], $item["price"], $item["discount"]);
    }

    public function getByBill(Bill $bill) {
        $query = "SELECT * FROM bill_items WHERE bill_id = ?";
        $params = array($bill->getId());
        //Array de objetos devueltos
        $result = [];
        //Recorriendo resultados
        foreach(Model\Connection::select($query,$params) as $line) {
            //Padres
            $pPage = new StorePage();
            $pPage->setId($line['store_page_id']);
            $pPage->getById();

            //Registro
            $item = new BillItem();
            $item->init($line["id"], $bill, $pPage, $line["game_key"], $line["price"], $line["discount"]);
            array_push($result, $item);
        }
        return $result;
    }

    public function insert()
    {
        //Generando game key y verificando que no se repita
        $key = "";
        do {
            $key = Helper\Component::random_str(20);
            $query ="SELECT * FROM bill_items WHERE game_key = ?";
            $params= array($key);
        } while (!empty(Model\Connection::selectOne($query, $params)));

        $query ="INSERT INTO bill_items (bill_id, store_page_id, game_key, price, discount) VALUES(?,?,?,?,?)";
        $params= array($this->getBill()->getId(),$this->getStorePage()->getId(), $key, $this->getStorePage()->getPrice(), $this->getStorePage()->getDiscount());
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function update()
    {
        //Método innecesario
        return "Método innecesario";
    }

    public function search($param)
    {
        //Método innecesario
        return "Método innecesario";
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'bill' => [
                'id' => $this->getBill()->getId(),
                'user' => [
                    'id' => $this->getBill()->getUser()->getId(),
                    'alias' => $this->getBill()->getUser()->getAlias(),
                    'email' => $this->getBill()->getUser()->getEmail(),
                    'userType' => [
                        'id' => $this->getBill()->getUser()->getUserType()->getId(),
                        'name' => $this->getBill()->getUser()->getUserType()->getName()
                    ]
                ],
                'bill_date' => $this->getBill()->getBillDate()->format('Y-m-d')
            ],
            'storePage' => [
                'id' => $this->getStorePage()->getId(),
                'game' => [
                    'id' => $this->getStorePage()->getGame()->getId(),
                    'name' => $this->getStorePage()->getGame()->getName(),
                    'cover' => $this->getStorePage()->getGame()->getCover(),
                    'banner'=>$this->getStorePage()->getGame()->getBanner(),
                    'description' => $this->getStorePage()->getGame()->getDescription(),
                    'esrb' => [
                        'id' => $this->getStorePage()->getGame()->getEsrb()->getId(),
                        'name' => $this->getStorePage()->getGame()->getEsrb()->getName(),
                    ],
                    'publisher' => [
                        'id' => $this->getStorePage()->getGame()->getPublisher()->getId(),
                        'name' => $this->getStorePage()->getGame()->getPublisher()->getName(),
                    ],
                    'genre' => [
                        'id' => $this->getStorePage()->getGame()->getGenre()->getId(),
                        'name' => $this->getStorePage()->getGame()->getGenre()->getName(),
                    ],
                ],
                'release_date' => $this->getStorePage()->getReleaseDate()->format('Y-m-d'),
            ],
            'gameKey' => $this->getGameKey(),
            'price' => $this->getPrice(),
            'discount' => $this->getDiscount()

        ];
    }
}