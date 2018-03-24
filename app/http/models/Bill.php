<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 24/3/2018
 * Time: 11:53 AM
 */

namespace Http\Models;
//require ("../../../vendor/autoload.php");
use Http\Models as Model;
use Http\Helpers as Helper;
use Http\Models\Interfaces as Interfaces;

class Bill implements Interfaces\ModelInterface, \JsonSerializable
{
    private $id;
    private $user;
    private $billDate;

    /**
     * Bill constructor.
     * @param $id
     * @param $user
     * @param $billDate
     */
    public function init($id, $user, $billDate)
    {
        $this->id = $id;
        $this->user = $user;
        $this->billDate = $billDate;
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
    public function getBillDate()
    {
        return $this->billDate;
    }

    /**
     * @param mixed $billDate
     */
    public function setBillDate($billDate)
    {
        $this->billDate = $billDate;
    }


    public function getAll($active = false)
    {
        $query = "SELECT * FROM bills";
        $params = array(null);
        //Array de objetos devueltos
        $result = [];
        //Recorriendo resultados
        foreach(Model\Connection::select($query,$params) as $line) {
            //Padres
            $pUser = new User();
            $pUser->setId($line['user_id']);
            $pUser->getById();

            //Registro
            $bill = new Bill();
            $bill->init($line["id"], $pUser, new \DateTime($line["bill_date"]));
            array_push($result, $bill);
        }
        return $result;
    }

    public function getById()
    {
        $query ="SELECT * FROM bills WHERE id = ?";
        $params = array($this->getId());
        $bill = Model\Connection::selectOne($query,$params);
            //Padres
            $pUser = new User();
            $pUser->setId($bill['user_id']);
            $pUser->getById();
        $this->init($bill['id'], $pUser, new \DateTime($bill["bill_date"]));
    }

    public function getByUser (User $user) {
        $query = "SELECT * FROM bills WHERE user_id = ?";
        $params = array($user->getId());
        //Array de objetos devueltos
        $result = [];
        //Recorriendo resultados
        foreach(Model\Connection::select($query,$params) as $line) {
            //Padres
            $pUser = new User();
            $pUser->setId($line['user_id']);
            $pUser->getById();

            //Registro
            $bill = new Bill();
            $bill->init($line["id"], $pUser, new \DateTime($line["bill_date"]));
            array_push($result, $bill);
        }
        return $result;
    }

    public function getLastId() {
        return Model\Connection::getLastRowId();
    }

    public function insert()
    {
        $query ="INSERT INTO bills (user_id, bill_date) VALUES(?,?)";
        $params= array($this->getUser()->getId(),$this->getBillDate()->format('Y-m-d'));
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
            'user' => [
                'id' => $this->getUser()->getId(),
                'alias' => $this->getUser()->getAlias(),
                'email' => $this->getUser()->getEmail(),
                'userType' => [
                    'id' => $this->getUser()->getUserType()->getId(),
                    'name' => $this->getUser()->getUserType()->getName()
                ]
            ],
            'bill_date' => $this->getBillDate()
        ];
    }
}