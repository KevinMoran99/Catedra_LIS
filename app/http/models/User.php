<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 9/3/2018
 * Time: 10:57 PM
 */

namespace Http\Models;
require ("../../../vendor/autoload.php");
use Http\Models as Model;
use Http\Models\Interfaces as Interfaces;

class User implements Interfaces\ModelInterface
{
    private $id;
    private $alias;
    private $email;
    private $pass;
    private $userType;
    private $state;

    /**
     * User constructor.
     * @param $id
     * @param $alias
     * @param $email
     * @param $pass
     * @param $userType
     * @param $state
     */
    public function init($id, $alias, $email, $pass, $userType, $state)
    {
        $this->id = $id;
        $this->alias = $alias;
        $this->email = $email;
        $this->pass = $pass;
        $this->userType = $userType;
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
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param mixed $alias
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * @param mixed $pass
     */
    public function setPass($pass)
    {
        $this->pass = $pass;
    }

    /**
     * @return mixed
     */
    public function getUserType()
    {
        return $this->userType;
    }

    /**
     * @param mixed $userType
     */
    public function setUserType($userType)
    {
        $this->userType = $userType;
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
        $query ="SELECT * FROM users";
        $params = array(null);
        return Model\Connection::select($query,$params);
    }
    /*
     * User constructor.
     * @param $id
     * @param $alias
     * @param $email
     * @param $pass
     * @param $userType
     * @param $state
     */
    public function getById()
    {
        $query ="SELECT * FROM users WHERE id = ?";
        $params = array($this->getId());
        $user = Model\Connection::selectOne($query,$params);
        $this->setId($user['id']);
        $this->setAlias($user['alias']);
        $this->setEmail($user['email']);
        $this->setPass($user['pass']);
            $parent = new UserType();
            $parent->setId($user['user_type_id']);
            $parent->getById();
        $this->setUserType($parent);
        $this->setState($user['state']);
    }

    public function insert()
    {
        $query ="INSERT INTO users (alias, email, pass, user_type_id, state) VALUES(?,?,?,?,?)";
        $params= array($this->getAlias(),$this->getEmail(),$this->getPass(),$this->getUserType(),$this->getState());
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function update()
    {
        $query ="UPDATE users SET alias=?,email=?,pass=?,user_type_id=?,state=? WHERE id=?";
        $params= array($this->getAlias(),$this->getEmail(),$this->getPass(),$this->getUserType(),$this->getState(),$this->getId());
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function search($param)
    {
        $query = "SET @param = CONCAT('%','','%');" .
                 "SELECT u.*, t.name FROM users u INNER JOIN user_types t ON u.user_type_id = t.id " .
                 "WHERE u.alias LIKE @param OR u.email LIKE @param OR t.name LIKE @param " .
                 "OR u.state = (CASE WHEN 'activo' LIKE @param THEN 1 WHEN 'inactivo' LIKE @param THEN 0 END)";
        $params = array($param);
        return Model\Connection::select($query, $params);
    }
}