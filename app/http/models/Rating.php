<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 24/3/2018
 * Time: 6:45 PM
 */

namespace Http\Models;
use Http\Models as Model;
use Http\Helpers as Helper;
use Http\Models\Interfaces as Interfaces;


class Rating implements Interfaces\ModelInterface, \JsonSerializable
{
    private $id;
    private $billItem;
    private $recommended;
    private $description;
    private $reviewDate;
    private $visible;

    /**
     * Rating constructor.
     * @param $id
     * @param $billItem
     * @param $recommended
     * @param $description
     * @param $reviewDate
     * @param $visible
     */
    public function init($id, $billItem, $recommended, $description, $reviewDate, $visible)
    {
        $this->id = $id;
        $this->billItem = $billItem;
        $this->recommended = $recommended;
        $this->description = $description;
        $this->reviewDate = $reviewDate;
        $this->visible = $visible;
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
    public function getBillItem()
    {
        return $this->billItem;
    }

    /**
     * @param mixed $billItem
     */
    public function setBillItem($billItem)
    {
        $this->billItem = $billItem;
    }

    /**
     * @return mixed
     */
    public function getRecommended()
    {
        return $this->recommended;
    }

    /**
     * @param mixed $recommended
     */
    public function setRecommended($recommended)
    {
        $this->recommended = $recommended;
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
    public function getReviewDate()
    {
        return $this->reviewDate;
    }

    /**
     * @param mixed $reviewDate
     */
    public function setReviewDate($reviewDate)
    {
        $this->reviewDate = $reviewDate;
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



    public function getAll($active = false)
    {
        if ($active) {
            $query = "SELECT * FROM ratings WHERE visible = 1";
        }
        else {
            $query = "SELECT * FROM ratings";
        }
        $params = array(null);
        //Array de objetos devueltos
        $result = [];
        //Recorriendo resultados
        foreach(Model\Connection::select($query,$params) as $line) {
            //Padres
            $pItem = new BillItem();
            $pItem->setId($line['bill_item_id']);
            $pItem->getById();

            //Registro
            $rating = new Rating();
            $rating->init($line["id"], $pItem, $line["recommended"], $line["description"], new \DateTime($line["review_date"]), $line["visible"]);
            array_push($result, $rating);
        }
        return $result;
    }

    public function getById()
    {
        $query ="SELECT * FROM ratings WHERE id = ?";
        $params = array($this->getId());
        $rating = Model\Connection::selectOne($query,$params);
        //Padres
        $pItem = new BillItem();
        $pItem->setId($rating['bill_item_id']);
        $pItem->getById();
        $this->init($rating["id"], $pItem, $rating["recommended"], $rating["description"], new \DateTime($rating["review_date"]), $rating["visible"]);
    }

    public function getByPage(StorePage $page, $active = false)
    {
        if ($active) {
            $query = "SELECT r.* FROM ratings r INNER JOIN bill_items bi ON r.bill_item_id = bi.id WHERE bi.store_page_id = ? AND visible = 1";
        }
        else {
            $query = "SELECT r.* FROM ratings r INNER JOIN bill_items bi ON r.bill_item_id = bi.id WHERE bi.store_page_id = ?";
        }
        $params = array($page->getId());
        //Array de objetos devueltos
        $result = [];
        //Recorriendo resultados
        foreach(Model\Connection::select($query,$params) as $line) {
            //Padres
            $pItem = new BillItem();
            $pItem->setId($line['bill_item_id']);
            $pItem->getById();

            //Registro
            $rating = new Rating();
            $rating->init($line["id"], $pItem, $line["recommended"], $line["description"], new \DateTime($line["review_date"]), $line["visible"]);
            array_push($result, $rating);
        }
        return $result;
    }

    public function insert()
    {
        $query ="INSERT INTO ratings (bill_item_id, recommended, description, review_date, visible) VALUES(?,?,?,?,?)";
        $params= array($this->getBillItem()->getId(),$this->getRecommended(),$this->getDescription(),$this->getReviewDate()->format('Y-m-d'),1);
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function update()
    {
        $query ="UPDATE ratings SET recommended = ?, description = ?, review_date = ?, visible = ? WHERE id = ?";
        $params= array($this->getRecommended(),$this->getDescription(),$this->getReviewDate()->format('Y-m-d'),$this->getVisible(), $this->getId());
        return Model\Connection::insertOrUpdate($query,$params);
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
            'billItem' => [
                'id' => $this->getBillItem()->getId(),
                'bill' => [
                    'id' => $this->getBillItem()->getBill()->getId(),
                    'user' => [
                        'id' => $this->getBillItem()->getBill()->getUser()->getId(),
                        'alias' => $this->getBillItem()->getBill()->getUser()->getAlias(),
                        'email' => $this->getBillItem()->getBill()->getUser()->getEmail(),
                        'userType' => [
                            'id' => $this->getBillItem()->getBill()->getUser()->getUserType()->getId(),
                            'name' => $this->getBillItem()->getBill()->getUser()->getUserType()->getName()
                        ]
                    ],
                    'bill_date' => $this->getBillItem()->getBill()->getBillDate()->format('Y-m-d')
                ],
                'storePage' => [
                    'id' => $this->getBillItem()->getStorePage()->getId(),
                    'game' => [
                        'id' => $this->getBillItem()->getStorePage()->getGame()->getId(),
                        'name' => $this->getBillItem()->getStorePage()->getGame()->getName(),
                        'cover' => $this->getBillItem()->getStorePage()->getGame()->getCover(),
                        'banner'=>$this->getBillItem()->getStorePage()->getGame()->getBanner(),
                        'description' => $this->getBillItem()->getStorePage()->getGame()->getDescription(),
                        'esrb' => [
                            'id' => $this->getBillItem()->getStorePage()->getGame()->getEsrb()->getId(),
                            'name' => $this->getBillItem()->getStorePage()->getGame()->getEsrb()->getName(),
                        ],
                        'publisher' => [
                            'id' => $this->getBillItem()->getStorePage()->getGame()->getPublisher()->getId(),
                            'name' => $this->getBillItem()->getStorePage()->getGame()->getPublisher()->getName(),
                        ],
                        'genre' => [
                            'id' => $this->getBillItem()->getStorePage()->getGame()->getGenre()->getId(),
                            'name' => $this->getBillItem()->getStorePage()->getGame()->getGenre()->getName(),
                        ],
                    ],
                    'release_date' => $this->getBillItem()->getStorePage()->getReleaseDate()->format('Y-m-d'),
                ],
                'gameKey' => $this->getBillItem()->getGameKey(),
                'price' => $this->getBillItem()->getPrice(),
                'discount' => $this->getBillItem()->getDiscount()
            ],

            'recommended' => $this->getRecommended(),
            'description' => $this->getDescription(),
            'reviewDate' => $this->getReviewDate()->format('Y-m-d'),
            'visible' => $this->getVisible()
        ];
    }

}