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
use Http\Helpers as Helper;
use Http\Models\Interfaces as Interfaces;

class User implements Interfaces\ModelInterface, \JsonSerializable
{
    private $id;
    private $alias;
    private $email;
    private $pass;
    private $userType;
    private $state;
    private $passDate; //No es incluido en método init
    private $loginCode; //No es incluido en método init

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

    /**
     * @return mixed
     */
    public function getPassDate()
    {
        return $this->passDate;
    }

    /**
     * @param mixed $passDate
     */
    public function setPassDate($passDate)
    {
        $this->passDate = $passDate;
    }

    /**
     * @return mixed
     */
    public function getLoginCode()
    {
        return $this->loginCode;
    }

    /**
     * @param mixed $loginCode
     */
    public function setLoginCode($loginCode)
    {
        $this->loginCode = $loginCode;
    }


    public function getAll($active = false){
        if ($active)
            $query ="SELECT * FROM users WHERE state = 1";
        else
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

    public function getAllInactive(){

        $query ="SELECT * FROM users WHERE state = 0 AND user_type_id = 2";
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
        $query ="INSERT INTO users (alias, email, pass, user_type_id, state, pass_date) VALUES(?,?,?,?,?,CURDATE())";
        $params= array($this->getAlias(),$this->getEmail(),$this->getPass(),$this->getUserType()->getId(),$this->getState());
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function update($passChanged = false)
    {
        //Si la contraseña fue cambiada, hay que actualizar la fecha de modificación de la misma
        if ($passChanged) {
            $query ="UPDATE users SET alias=?,email=?,pass=?,user_type_id=?,state=?,pass_date=DATE_ADD(CURDATE(), INTERVAL 1 DAY) WHERE id=?";
        }
        else {
            $query ="UPDATE users SET alias=?,email=?,pass=?,user_type_id=?,state=? WHERE id=?";
        }
        
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

    //Verifica si existe un usuario [con estado activo] con el email especificado
    public function checkEmail () {
        $query ="SELECT * FROM users WHERE email = ? AND state = 1";
        $params = array($this->getEmail());
        $user = Model\Connection::selectOne($query,$params);
        if ($user)
            return true;
        else
            return false;
    }

    //Verifica que la contraseña sea valida y luego envia el codigo de seguridad al correo del usuario
    public function loginStep1 () {
        //Obteniendo contraseña para comparar
        $query ="SELECT * FROM users WHERE (alias = ? OR email = ?) AND state = 1";
        $params = array($this->getAlias(), $this->getAlias());
        $user = Model\Connection::selectOne($query,$params);

        //Comparando con la contraseña proporcionada
        if (password_verify($this->getPass(), $user['pass'])) {

            //Si las contraseñas concuerdan, se envia el codigo de confirmacion al email
            $hash = Helper\Encryptor::generateConfirmHash();

            //Encriptando hash
            $encHash = Helper\Encryptor::encrypt($hash);

            //Guardando hash
            $query ="UPDATE users SET login_code = ? WHERE id = ?";
            $params = array($encHash, $user['id']);

            $confirm = Model\Connection::insertOrUpdate($query,$params);
            
            //Estableciendole el email para usarlo en el mensaje y en el segundo paso
            $this->setEmail($user['email']);
            
            //Retorna el hash para ser enviado por correo desde el controlador
            return $hash;
        }
        else
            return false;
    }

    //Verifica que el hash de confirmacion de login sea valido, y luego hace el login
    public function loginStep2 () {
        //Obteniendo contraseña para comparar
        $query ="SELECT * FROM users WHERE (alias = ? OR email = ?) AND state = 1";
        $params = array($this->getAlias(), $this->getAlias());
        $user = Model\Connection::selectOne($query,$params);

        //Comparando con el hash proporcionado
        if (password_verify($this->getLoginCode(), $user['login_code'])) {
            //Si los hash concuerdan, se hace el login
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

    //Verifica si la contraseña del usuario ya expiró
    public function passIsExpired()
    {
        $query ="SELECT * FROM users WHERE id = ? AND DATE_ADD(pass_date, INTERVAL 90 DAY) <= CURDATE()";
        $params = array($this->getId());
        $passExpired = Model\Connection::selectOne($query,$params);
        if($passExpired) {
            return true;
        }
        else {
            return false;
        }
    }

    //Cambia la contraseña del email dado
    public function resetPass()
    {
        $query ="UPDATE users SET pass=?,pass_date=DATE_ADD(CURDATE(), INTERVAL 1 DAY) WHERE email=?";
        
        $params= array($this->getPass(),$this->getEmail());
        return Model\Connection::insertOrUpdate($query,$params);
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'alias' => $this->getAlias(),
            'email' => $this->getEmail(),
            'userType' => [
                'id' => $this->getUserType()->getId(),
                'name' => $this->getUserType()->getName(),
                'games' => $this->getUserType()->getGames(),
                'users' => $this->getUserType()->getUsers(),
                'support' => $this->getUserType()->getSupport(),
                'stadistics' => $this->getUserType()->getStadistics(),
                'reviews' => $this->getUserType()->getReviews(),
                'esrbs' => $this->getUserType()->getEsrbs(),
                'publishers' => $this->getUserType()->getPublishers(),
                'genres' => $this->getUserType()->getGenres(),
                'specs' => $this->getUserType()->getSpecs(),
                'typeSpecs' => $this->getUserType()->getTypeSpecs()
            ],
            'state' => $this->getState()
        ];
    }
}