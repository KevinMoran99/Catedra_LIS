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

    /**
     * BillItem constructor.
     * @param $id
     * @param $bill
     * @param $storePage
     * @param $gameKey
     */
    public function init($id, $bill, $storePage, $gameKey)
    {
        $this->id = $id;
        $this->bill = $bill;
        $this->storePage = $storePage;
        $this->gameKey = $gameKey;
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
            $item->init($line["id"], $pBill, $pPage, $line["game_key"]);
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

        $this->init($item["id"], $pBill, $pPage, $item["game_key"]);
    }

    public function getByBill(Bill $bill) {
        $query = "SELECT * FROM bill_items WHERE bill_id = ?";
        $params = array($bill->getId());
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
            $item->init($line["id"], $pBill, $pPage, $line["game_key"]);
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

        $query ="INSERT INTO bill_items (bill_id, store_page_id, game_key) VALUES(?,?,?)";
        $params= array($this->getBill()->getId(),$this->getStorePage()->getId(), $key);
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
                'id' => $this->getId(),
                'user' => [
                    'id' => $this->getUser()->getId(),
                    'alias' => $this->getUser()->getAlias(),
                    'email' => $this->getUser()->getEmail(),
                    'userType' => [
                        'id' => $this->getUser()->getUserType()->getId(),
                        'name' => $this->getUser()->getUserType()->getName()
                    ]
                ],
                'bill_date' => $this->getBillDate()->format('Y-m-d')
            ],
            'storePage' => [
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
                'release_date' => $this->getReleaseDate()->format('Y-m-d'),
            ],
            'gameKey' => $this->getGameKey()
        ];
    }
}