<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 9/3/2018
 * Time: 10:57 PM
 */

namespace Http\Models;
//require ("../../../vendor/autoload.php");
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
        //Array de objetos devueltos
        $result = [];
        //Recorriendo resultados
        foreach(Model\Connection::select($query,$params) as $line) {
            //Padres
            $pUserType = new UserType();
            $pUserType->setId($line['user_type_id']);
            $pUserType->getById();

            //Registro
            $user = new User();
            $user->init($line["id"], $line["alias"], $line["email"], $line["pass"], $pUserType, $line["state"]);
            array_push($result, $user);
        }
        return $result;
    }

    public function getById()
    {
        $query ="SELECT * FROM users WHERE id = ?";
        $params = array($this->getId());
        $user = Model\Connection::selectOne($query,$params);
        $this->setId($user['id']);
        $this->setAlias($user['alias']);
        $this->setEmail($user['email']);
        $this->setPass($user['pass']);
            $pUserType = new UserType();
            $pUserType->setId($user['user_type_id']);
            $pUserType->getById();
        $this->setUserType($pUserType);
        $this->setState($user['state']);
    }

    public function insert()
    {
        $query ="INSERT INTO users (alias, email, pass, user_type_id, state) VALUES(?,?,?,?,?)";
        $params= array($this->getAlias(),$this->getEmail(),$this->getPass(),$this->getUserType()->getId(),$this->getState());
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function update()
    {
        $query ="UPDATE users SET alias=?,email=?,pass=?,user_type_id=?,state=? WHERE id=?";
        $params= array($this->getAlias(),$this->getEmail(),$this->getPass(),$this->getUserType()->getId(),$this->getState(),$this->getId());
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function search($param)
    {
        $query = "SELECT u.* FROM users u INNER JOIN user_types t ON u.user_type_id = t.id " .
                 "WHERE u.alias LIKE CONCAT('%',?,'%') OR u.email LIKE CONCAT('%',?,'%') OR t.name LIKE CONCAT('%',?,'%') " .
                 "OR u.state = (CASE WHEN 'activo' LIKE CONCAT('%',?,'%') THEN 1 WHEN 'inactivo' LIKE CONCAT('%',?,'%') THEN 0 END)";
        $params = array($param,$param,$param,$param,$param);
        //Array de objetos devueltos
        $result = [];
        //Recorriendo resultados
        foreach(Model\Connection::select($query,$params) as $line) {
            //Padres
            $pUserType = new UserType();
            $pUserType->setId($line['user_type_id']);
            $pUserType->getById();

            //Registro
            $user = new User();
            $user->init($line["id"], $line["alias"], $line["email"], $line["pass"], $pUserType, $line["state"]);
            array_push($result, $user);
        }
        return $result;
    }

    //Verifica si existe un usuario [con estado activo] con el alias o email especificado
    public function checkName () {
        $query ="SELECT * FROM users WHERE (alias = ? OR email = ?) AND state = 1";
        $params = array($this->getAlias(), $this->getAlias());
        $user = Model\Connection::selectOne($query,$params);
        if ($user)
            return true;
        else
            return false;
    }

    //Verifica que la contraseña sea valida y hace login
    public function login () {
        $query ="SELECT * FROM users WHERE (alias = ? OR email = ?) AND pass = ?";
        $params = array($this->getAlias(), $this->getAlias(), $this->getPass());
        $user = Model\Connection::selectOne($query,$params);
        if ($user) {
            $this->setId($user['id']);
            $this->setAlias($user['alias']);
            $this->setEmail($user['email']);
            $this->setPass($user['pass']);
                $pUserType = new UserType();
                $pUserType->setId($user['user_type_id']);
                $pUserType->getById();
            $this->setUserType($pUserType);
            $this->setState($user['state']);

            return true;
        }
        else
            return false;
    }

}