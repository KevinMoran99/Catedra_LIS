<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 11/3/2018
 * Time: 3:22 PM
 */

namespace Http\Controllers;
use Http\Models as Model;
use Http\Helpers as Helper;
use function PHPSTORM_META\type;

class UserController
{
    //OBTENER TODOS LOS REGISTROS
    public function getAllUsers()
    {
        //creamos un nuevo objeto
        $user = new Model\User();
        //retornamos todos los datos
        return $user->getAll();
    }

    //Obtener todos los registros activos
    public function getAllActiveUsers()
    {
        //creamos un nuevo objeto
        $user = new Model\User();
        //retornamos todos los datos
        return $user->getAll(true);
    }

    public function getAllInactiveUsers(){
        $user = new Model\User();
        return $user->getAllInactive();
    }

    //AGREGAR REGISTRO
    public function addUser($alias, $email, $pass, $passConfirm, $userType, $state)
    {
        //creamos objetos de validacion y user
        $validator = new Helper\Validator();
        $user = new Model\User();
        //variables de validacion
        $flag = false;
        $validateError = "";
        //si no se cumplen las validaciones, setear le flag a true y agregar mensaje de error
        if (is_null($userType)) {
            $validateError = "Por favor elija un tipo de usuario";
            $flag = true;
        }
        if (!($pass == $passConfirm)) {
            $validateError = "Las contraseñas ingresadas no coinciden";
            $flag = true;
        }
        if (!$validator->validatePassword($pass)) {
            $validateError = "La contraseña debe tener al menos 8 caracteres de longitud y contener al menos un caracter alfanumérico y un caracter especial";
            $flag = true;
        }
        if (!$validator->validateEmail($email)) {
            $validateError = "El email ingresado es inválido";
            $flag = true;
        }
        if (!$validator->validateAlphanumeric($alias, 3, 50)) {
            $validateError = "Solo se permiten numeros, letras y signos de puntuación en el nombre de usuario";
            $flag = true;
        }
        //Verificando que el alias y la contraseña sean diferentes
        if ($pass == $alias) {
            $validateError = "El alias y la contraseña deben ser diferentes";
            $flag = true;
        }

        //si el flag sigue siendo falso en este punto, agrega un nuevo registro
        if (!$flag) {
            //Encriptando contraseña
            $pass = Helper\Encryptor::encrypt($pass);

            //Obteniendo padre del user
            $type = new Model\UserType();
            $type->setId($userType);
            $type->getById();

            //llenamos el objeto con los datos proporcionados
            $user->setAlias($alias);
            $user->setEmail($email);
            $user->setPass($pass);
            $user->setUserType($type);
            $user->setState($state);

            $response = $user->insert(); //Si se hace el insert retornará true. Si no, retornará el código de la excepción mysql
            if (is_bool($response)) {
                Helper\Component::showMessage(Helper\Component::$SUCCESS, "Usuario añadido");
            } else {
                Helper\Component::showMessage(Helper\Component::$WARNING, $response);
            }
        } else {
            //si el flag es verdadero, muestra el mensaje de error de validacion
            Helper\Component::showMessage(Helper\Component::$ERROR, $validateError);
        }
    }

    //OBTENER REGISTRO
    public function getUser($id, $ajax){
        //nuevo objeto de tipo de specs
        $user = new Model\User();
        //llenamos el objeto con los datos proporcionados
        $user->setId($id);
        $user->getById();
        //si es una request ajax retorna un json con los datos
        if($ajax) {
            echo json_encode($user);
        }else{
            //si no es ajax, retorna un objeto
            return $user;
        }
    }

    //ACTUALIZAR REGISTRO
    public function updateUser($id,$alias, $email, $pass, $passConfirm, $userType, $state){
        //objetos de validacion y tipo de user
        $validator = new Helper\Validator();
        $user = new Model\User();
        //variables de validacion
        $flag = false;
        $validateError="";

        //si no se cumplen las validaciones, setear le flag a true y agregar mensaje de error
        session_start();
        //Restriccion de revocacion de permisos al propio usuario
        if ($_SESSION["user"]->getId() == $id) {
            if ($_SESSION["user"]->getState() != $state) {
                $validateError = "No puede cambiar su propio estado";
                $flag = true;
            }
            if ($_SESSION["user"]->getUserType()->getId() != $userType) {
                $validateError = "No puede cambiar su propio tipo de usuario";
                $flag = true;
            }
        }
        //Si se especificó una nueva contraseña
        if (!empty($pass)) {
            if (!($pass == $passConfirm)) {
                $validateError = "Las contraseñas ingresadas no coinciden";
                $flag = true;
            }
            if (!$validator->validatePassword($pass)) {
                $validateError = "La contraseña debe tener al menos 8 caracteres de longitud y contener al menos un caracter alfanumérico y un caracter especial";
                $flag = true;
            }

            //Verificando que la nueva contraseña sea diferente a la anterior
            $user->setId($id);
            $user->getById();
            if (password_verify($pass, $user->getPass())) {
                $validateError = "La nueva contraseña debe ser diferente a la anterior";
                $flag = true;
            }
            //Verificando que el alias y la contraseña sean diferentes
            if ($pass == $alias) {
                $validateError = "El alias y la contraseña deben ser diferentes";
                $flag = true;
            }


        }
        if (is_null($userType)) {
            $validateError = "Por favor elija un tipo de usuario";
            $flag = true;
        }
        if (!$validator->validateEmail($email)) {
            $validateError = "El email ingresado es inválido";
            $flag = true;
        }
        if (!$validator->validateAlphanumeric($alias, 3, 50)) {
            $validateError = "Solo se permiten numeros, letras y signos de puntuación en el nombre de usuario";
            $flag = true;
        }

        //si en este punto el flag es falso, actualizar el registro
        if(!$flag){
            //Obteniendo padre del user
            $type = new Model\UserType();
            $type->setId($userType);
            $type->getById();

            $user->setId($id);
            $user->getById(); // Para obtener la contraseña en caso de que no sea cambiada
            $user->setAlias($alias);
            $user->setEmail($email);

            $passChanged = false;
            if (!empty($pass)) {
                //Encriptando contraseña
                $pass = Helper\Encryptor::encrypt($pass);
                $user->setPass($pass);
                $passChanged = true;
            }
            $user->setUserType($type);
            $user->setState($state);
            $response = $user->update($passChanged);
            if (is_bool($response)) {
                Helper\Component::showMessage(Helper\Component::$SUCCESS, "Usuario actualizado");
            }else {
                Helper\Component::showMessage(Helper\Component::$WARNING, $response);
            }
        }else{
            //si el flag es verdadero, enviar mensaje de error
            Helper\Component::showMessage(Helper\Component::$ERROR, $validateError);
        }
    }

    //Version de updateUser usada para que el cliente edite su perfil
    //Solamente toma en cuenta alias y contraseña
    public function updateProfile($alias, $pass, $passConfirm){

        //Reanudando sesion para accesar variable de sesion
        session_start();

        //objetos de validacion y tipo de user
        $validator = new Helper\Validator();
        $user = $_SESSION['user'];
        //variables de validacion
        $flag = false;
        $validateError="";

        //si no se cumplen las validaciones, setear le flag a true y agregar mensaje de error

        //Si se especificó una nueva contraseña
        if (!empty($pass)) {
            if (!($pass == $passConfirm)) {
                $validateError = "Las contraseñas ingresadas no coinciden";
                $flag = true;
            }
            if (!$validator->validatePassword($pass)) {
                $validateError = "La contraseña debe tener al menos 8 caracteres de longitud y contener al menos un caracter alfanumérico y un caracter especial";
                $flag = true;
            }

            //Verificando que el alias y la contraseña sean diferentes
            if ($pass == $alias) {
                $validateError = "El alias y la contraseña deben ser diferentes";
                $flag = true;
            }

            //Verificando que la nueva contraseña sea diferente a la anterior
            if (password_verify($pass, $user->getPass())) {
                $validateError = "La nueva contraseña debe ser diferente a la anterior";
                $flag = true;
            }
        }
        if (!$validator->validateAlphanumeric($alias, 3, 50)) {
            $validateError = "Solo se permiten numeros, letras y signos de puntuación en el nombre de usuario";
            $flag = true;
        }

        //si en este punto el flag es falso, actualizar el registro
        if(!$flag){
            //Obteniendo padre del user
            $user->setAlias($alias);

            $passChanged = false;
            if (!empty($pass)) {
                //Encriptando contraseña
                $pass = Helper\Encryptor::encrypt($pass);
                $user->setPass($pass);

                $passChanged = true;
            }
            $response = $user->update($passChanged);
            if (is_bool($response)) {
                //Actualizando variable de sesión
                $_SESSION['user'] = $user;
                Helper\Component::showMessage(Helper\Component::$SUCCESS, "Perfil actualizado");
            }else {
                Helper\Component::showMessage(Helper\Component::$WARNING, $response);
            }
        }else{
            //si el flag es verdadero, enviar mensaje de error
            Helper\Component::showMessage(Helper\Component::$ERROR, $validateError);
        }
    }

    public function searchUser($name,$ajax){
        //nuevo objeto de tipo de especificacion
        $user = new Model\User();
        $data = $user->search($name);
        //si es una request ajax retorna un json con los datos
        if($ajax) {
            echo json_encode($data);
        }else{
            //si no es ajax, retorna un objeto
            return $data;
        }
    }

    //METODO DE INICIO DE SESION
    public function login($name, $pass) {
        //$name puede ser el alias o el email
        $user = new Model\User();
        $user->setAlias($name);
        $user->setPass($pass);
        if ($user->checkName()) {
            if ($user->login()) {
                //Inicializando variables de sesion
                session_start();
                $_SESSION["user"] = $user;
                $_SESSION['logged_in'] = true;
                $_SESSION['last_activity'] = time();
                $_SESSION['expire_time'] = 300;
                if ($user->getUserType()->getId() == 1)
                    Helper\Component::showMessage(1, "admin");
                else
                    Helper\Component::showMessage(1, "cliente");
            }
            else
                Helper\Component::showMessage(3, "La contraseña especificada es incorrecta.");
        }
        else
            Helper\Component::showMessage(3, "No existe ningún usuario con el alias o email especificado.");

    }

    //Método de registro de usuario
    public function signUp($alias, $email, $pass, $passConfirm, $terms) {
        //creamos objetos de validacion y user
        $validator = new Helper\Validator();
        $user = new Model\User();
        //variables de validacion
        $flag = false;
        $validateError = "";
        //si no se cumplen las validaciones, setear le flag a true y agregar mensaje de error
        if (!$terms) {
            $validateError = "Para registrarse en Stoam xD, debe aceptar los términos y condiciones";
            $flag = true;
        }
        if (!($pass == $passConfirm)) {
            $validateError = "Las contraseñas ingresadas no coinciden";
            $flag = true;
        }
        if (!$validator->validatePassword($pass)) {
            $validateError = "La contraseña debe tener al menos 8 caracteres de longitud y contener al menos un caracter alfanumérico y un caracter especial";
            $flag = true;
        }
        if (!$validator->validateEmail($email)) {
            $validateError = "El email ingresado es inválido";
            $flag = true;
        }
        if (!$validator->validateAlphanumeric($alias, 3, 50)) {
            $validateError = "Solo se permiten numeros, letras y signos de puntuación en el nombre de usuario";
            $flag = true;
        }
        //Verificando que el alias y la contraseña sean diferentes
        if ($pass == $alias) {
            $validateError = "El alias y la contraseña deben ser diferentes";
            $flag = true;
        }

        //si el flag sigue siendo falso en este punto, agrega un nuevo registro
        if (!$flag) {
            //Encriptando contraseña
            $encPass = Helper\Encryptor::encrypt($pass);

            //Obteniendo padre del user
            $type = new Model\UserType();
            $type->setId(2);
            $type->getById();

            //llenamos el objeto con los datos proporcionados
            $user->setAlias($alias);
            $user->setEmail($email);
            $user->setPass($encPass);
            $user->setUserType($type);
            $user->setState(1);

            $response = $user->insert(); //Si se hace el insert retornará true. Si no, retornará el código de la excepción mysql
            if (is_bool($response)) {
                ob_start();
                $this->login($alias, $pass);
                ob_end_clean();
                Helper\Component::showMessage(Helper\Component::$SUCCESS, "¡BIENVENIDO A BORDO! Gracias por elegir Stoam xD");
            } else {
                Helper\Component::showMessage(Helper\Component::$WARNING, $response);
            }
        } else {
            //si el flag es verdadero, muestra el mensaje de error de validacion
            Helper\Component::showMessage(Helper\Component::$ERROR, $validateError);
        }
    }

    public function logout() {
        session_start();
        session_destroy();
    }

    //Verifica si la contraseña del usuario logeado no ha expirado
    public function checkPasswordDate($ajax = false){

        //Reanudando sesion para accesar variable de sesion
        session_start();

        //user logeado
        $user = $_SESSION['user'];

        if ($ajax) {
            echo $user->passIsExpired();
        }
        else {
            return $user->passIsExpired();
        }
    }

    public function updatePassword($pass, $passConfirm) {
        //Reanudando sesion para accesar variable de sesion
        session_start();

        //objetos de validacion y tipo de user
        $validator = new Helper\Validator();
        $user = $_SESSION['user'];
        //variables de validacion
        $flag = false;
        $validateError="";

        //si no se cumplen las validaciones, setear le flag a true y agregar mensaje de error

        //Si se especificó una nueva contraseña
        if (!($pass == $passConfirm)) {
            $validateError = "Las contraseñas ingresadas no coinciden";
            $flag = true;
        }
        if (!$validator->validatePassword($pass)) {
            $validateError = "La contraseña debe tener al menos 8 caracteres de longitud y contener al menos un caracter alfanumérico y un caracter especial";
            $flag = true;
        }

        //Verificando que el alias y la contraseña sean diferentes
        if ($pass == $user->getAlias()) {
            $validateError = "El alias y la contraseña deben ser diferentes";
            $flag = true;
        }

        //Verificando que la nueva contraseña sea diferente a la anterior
        if (password_verify($pass, $user->getPass())) {
            $validateError = "La nueva contraseña debe ser diferente a la anterior";
            $flag = true;
        }
        
        //si en este punto el flag es falso, actualizar el registro
        if(!$flag){
            
            //Encriptando contraseña
            $pass = Helper\Encryptor::encrypt($pass);
            $user->setPass($pass);
            $response = $user->update(true);

            if (is_bool($response)) {
                //Actualizando variable de sesión
                $_SESSION['user'] = $user;
                Helper\Component::showMessage(Helper\Component::$SUCCESS, "Perfil actualizado");
            }else {
                Helper\Component::showMessage(Helper\Component::$WARNING, $response);
            }
        }else{
            //si el flag es verdadero, enviar mensaje de error
            Helper\Component::showMessage(Helper\Component::$ERROR, $validateError);
        }
    }
}

//script ejecutado al llamar al controlador con ajax
if(isset($_POST["method"])){
    include_once ("../../../vendor/autoload.php");
    $val = new Helper\Validator();
    try {
        if ($_POST["method"] == "addUser") {
            $_POST = $val->validateForm($_POST);
            //creamos un nuevo registro con los datos del array
            (new UserController())->addUser($_POST['alias'], $_POST['email'], $_POST['pass'], $_POST['passConfirm'], $_POST['userType'], $_POST['state']);
        }

        else if ($_POST["method"] == "getUser") {
            $_POST = $val->validateForm($_POST);
            //obtenemos el registro
            (new UserController())->getUser($_POST["id"], true);
        }

        else if($_POST["method"] == "searchUser"){
            $_POST = $val->validateForm($_POST);
            (new UserController())->searchUser($_POST["param"],true);
        }

        else if($_POST["method"] == "updateUser"){
            $_POST = $val->validateForm($_POST);
            //actualizamos el registro con los datos del array
            (new UserController())->updateUser($_POST['id'],$_POST['alias'], $_POST['email'], $_POST['pass'], $_POST['passConfirm'], $_POST['userType'], $_POST['state']);
        }

        else if($_POST["method"] == "updateProfile"){
            $_POST = $val->validateForm($_POST);
            //actualizamos el registro con los datos del array
            (new UserController())->updateProfile($_POST['alias'], $_POST['pass'], $_POST['passConfirm']);
        }

        else if ($_POST["method"] == "login") {
            $_POST = $val->validateForm($_POST);
            //validando captcha
            $recaptcha = $_POST["g-recaptcha-response"];
            //url de google
            $url = 'https://www.google.com/recaptcha/api/siteverify';
            //datos a enviar (Incluyendo clave de google de captcha)
            $data = array(
                'secret' => '6Lf2ClUUAAAAAHmmt2tBXCMfbiApLghA7FsGsOpk',
                'response' => $recaptcha
            );
            //estableciendo parametros de query
            $options = array(
                'http' => array (
                    'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
                        "User-Agent:MyAgent/1.0\r\n",
                    'method' => 'POST',
                    'content' => http_build_query($data)
                )
            );
            //estableciendo un contexto
            $context  = stream_context_create($options);
            //solicitando la data
            $verify = file_get_contents($url, false, $context);
            //parse a json
            $captcha_success = json_decode($verify);
            //validando
            if ($captcha_success->success) {
                // Human After All
                (new UserController())->login($_POST['alias'], $_POST['pass']);
            }else{
                Helper\Component::showMessage(Helper\Component::$WARNING, "Captcha incorrecto");
            }

        }

        else if ($_POST["method"] == "signUp") {
            $_POST = $val->validateForm($_POST);
            //validando captcha
            $recaptcha = $_POST["g-recaptcha-response"];
            //url de google
            $url = 'https://www.google.com/recaptcha/api/siteverify';
            //datos a enviar (Incluyendo clave de google de captcha)
            $data = array(
                'secret' => '6Lf2ClUUAAAAAHmmt2tBXCMfbiApLghA7FsGsOpk',
                'response' => $recaptcha
            );
            //estableciendo parametros de query
            $options = array(
                'http' => array (
                    'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
                        "User-Agent:MyAgent/1.0\r\n",
                    'method' => 'POST',
                    'content' => http_build_query($data)
                )
            );
            //estableciendo un contexto
            $context  = stream_context_create($options);
            //solicitando la data
            $verify = file_get_contents($url, false, $context);
            //parse a json
            $captcha_success = json_decode($verify);
            //validando
            if ($captcha_success->success) {
                (new UserController())->signUp($_POST['alias'], $_POST['email'], $_POST['pass'], $_POST['passConfirm'], isset($_POST['terms']) ? true : false);
            }else{
                Helper\Component::showMessage(Helper\Component::$WARNING, "Captcha incorrecto");
            }
        }

        else if ($_POST["method"] == "logout") {
            (new UserController())->logout();
        }

        else if ($_POST["method"] == "checkPasswordDate") {
            (new UserController())->checkPasswordDate(true);
        }

        else if ($_POST["method"] == "updatePassword") {
            $_POST = $val->validateForm($_POST);
            (new UserController())->updatePassword($_POST['pass'], $_POST['passConfirm']);
        }
    }
    catch (\Exception $error) {
        Helper\Component::showMessage(2, $error->getMessage());
    }
}