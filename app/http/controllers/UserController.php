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

    //Devuelve true si hay al menos un usuario registrado
    public function hasUsers($ajax = false) {
        //creamos un nuevo objeto
        $user = new Model\User();
        //retornamos todos los datos
        $users = $user->getAll(true);

        //Evaluando
        if (sizeof($users) == 0) {
            if ($ajax) {
                echo 'false';
            }
            else {
                return false;
            }
        }
        else {
            if ($ajax) {
                echo 'true';
            }
            else {
                return true;
            }
        }
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
        //Si un no admin intenta crear a un admin
        session_start();
        if ($_SESSION["user"]->getUserType()->getId() != 1 && $userType == 1) {
            $validateError = "No puede crear a usuarios administradores";
            $flag = true;
        }
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
        $user->setId($id);
        $user->getById();
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
        //Si un no admin intenta modificar a un admin
        if ($_SESSION["user"]->getUserType()->getId() != 1 && $user->getUserType()->getId() == 1) {
            $validateError = "No puede modificar a usuarios administradores";
            $flag = true;
        }
        //Otras validaciones
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

    private $MAX_TRIES = 3;
    //Llamado al fallar el login. Incrementa el contador de fallos, y si este llega a 3, banea la ip actual
    private function loginError() {
        session_start();
        if(!isset($_SESSION['times_failed'])) {
            $_SESSION['times_failed'] = 1;
        }
        else {
            $_SESSION['times_failed']++;
        }

        if($_SESSION['times_failed'] >= $this->MAX_TRIES) {
            //Si la cantidad de intentos fallidos maxima es alcanzada, la ip es baneada
            Model\Ban::ban();
            return "Has superado el número máximo de intentos de inicio de sesión.";
        }
        else {
            return "";
        }
    }

    //METODO DE INICIO DE SESION PASO 1
    public function loginStep1($name, $pass) {
        //$name puede ser el alias o el email
        $user = new Model\User();
        $user->setAlias($name);
        $user->setPass($pass);
        if(!(Model\Ban::isBanned()))
        {
            if ($user->checkName()) {
                $hash = $user->loginStep1();
                if (!is_bool($hash)) {
                    //Reiniciando intentos fallidos
                    if(isset($_SESSION['times_failed'])) {
                        $_SESSION['times_failed'] = 0;
                    }

                    //Enviando hash por correo
                    $response = Helper\Mailer::sendMail($user->getEmail(), $hash, Helper\Mailer::$CONFIRMHASH);

                    if (is_bool($response)) {
                        Helper\Component::showMessage(Helper\Component::$SUCCESS, "Código de confirmación enviado");
                    } else {
                        Helper\Component::showMessage(Helper\Component::$WARNING, $response);
                    }
                }
                else {
                    $ban = $this->loginError();
                    Helper\Component::showMessage(3, "La contraseña especificada es incorrecta. " . $ban);
                }
            }
            else {
                $ban = $this->loginError();
                Helper\Component::showMessage(3, "No existe ningún usuario con el alias o email especificado. " . $ban);
            }
        }
        else {
            $this->loginError();
            Helper\Component::showMessage(3, "Has superado el número máximo de intentos de inicio de sesión.");
        }


    }

    //METODO DE INICIO DE SESION PASO 2
    public function loginStep2($name, $hash) {
        //$name puede ser el alias o el email
        $user = new Model\User();
        $user->setAlias($name);
        $user->setLoginCode($hash);
        if ($user->checkName()) {
            if ($user->loginStep2()) {
                //Inicializando variables de sesion
                session_start();
                $_SESSION['logged_in'] = true;
                $_SESSION['last_activity'] = time();
                $_SESSION['expire_time'] = 300;
                if ($user->getUserType()->getId() == 2) {
                    $_SESSION["userC"] = $user;
                    Helper\Component::showMessage(1, "cliente");
                }else {
                    $_SESSION["user"] = $user;
                    Helper\Component::showMessage(1, "admin");
                }
            }
            else
                Helper\Component::showMessage(3, "El código de confirmación especificado es incorrecto.");
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
                //Obteniendo usuario recien creado y guardandolo en variable de sesion
                $user->getByEmail();
                session_start();
                $_SESSION['logged_in'] = true;
                $_SESSION['last_activity'] = time();
                $_SESSION['expire_time'] = 300;
                $_SESSION["userC"] = $user;
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

    //Método de registro de primer usuario
    public function firstSignUp($alias, $email, $pass, $passConfirm) {
        //creamos objetos de validacion y user
        $validator = new Helper\Validator();
        $user = new Model\User();
        //variables de validacion
        $flag = false;
        $validateError = "";
        //si no se cumplen las validaciones, setear le flag a true y agregar mensaje de error
        if ($this->hasUsers()) {
            $validateError = "La primera cuenta ya ha sido creada";
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
            $type->setId(1);
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
                //Obteniendo usuario recien creado y guardandolo en variable de sesion
                $user->getByEmail();
                session_start();
                $_SESSION['logged_in'] = true;
                $_SESSION['last_activity'] = time();
                $_SESSION['expire_time'] = 300;
                $_SESSION["user"] = $user;
                ob_end_clean();
                Helper\Component::showMessage(Helper\Component::$SUCCESS, "PRIMERA CUENTA CREADA - ¡Bienvenido a Sttom xD!");
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

    public function resetPass($email) {
        //Validando que no este baneado
        if(!Model\Ban::isBanned())
        {
            //creamos objetos de validacion y user
            $validator = new Helper\Validator();
            $user = new Model\User();
            $user->setEmail($email);
            //variables de validacion
            $flag = false;
            $validateError = "";
            //si no se cumplen las validaciones, setear le flag a true y agregar mensaje de error
            if (!$validator->validateEmail($email)) {
                $validateError = "El email ingresado es inválido";
                $flag = true;
            }
            else if (!$user->checkEmail()) {
                $validateError = "No existe ninguna cuenta vinculada al email ingresado";
                $flag = true;
            }

            //si el flag sigue siendo falso en este punto, agrega un nuevo registro
            if (!$flag) {
                
                //Generando contraseña aleatoria
                $pass = Helper\Encryptor::generatePassword();

                //Enviando contraseña por correo
                $response = Helper\Mailer::sendMail($email, $pass, Helper\Mailer::$RESETPASS);

                if (is_bool($response)) {

                    //Encriptando contraseña
                    $encPass = Helper\Encryptor::encrypt($pass);
                    //llenamos el objeto con los datos proporcionados
                    $user->setPass($encPass);
                    //Guardando contraseña
                    $response = $user->resetPass();

                    if (is_bool($response)) {
                        Helper\Component::showMessage(Helper\Component::$SUCCESS, "El mensaje de reestablecimiento de contraseña ha sido enviado a la cuenta de correo electrónico proporcionada");
                    } else {
                        Helper\Component::showMessage(Helper\Component::$WARNING, $response);
                    }
                    
                } else {
                    Helper\Component::showMessage(Helper\Component::$WARNING, $response);
                }
            } else {
                //si el flag es verdadero, muestra el mensaje de error de validacion
                Helper\Component::showMessage(Helper\Component::$ERROR, $validateError);
            }
        }
        else {
            Helper\Component::showMessage(3, "Has superado el número máximo de intentos de inicio de sesión.");
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

        else if ($_POST["method"] == "loginStep1") {
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
                (new UserController())->loginStep1($_POST['alias'], $_POST['pass']);
            }else{
                Helper\Component::showMessage(Helper\Component::$WARNING, "Captcha incorrecto");
            }

        }

        else if ($_POST["method"] == "loginStep2") {
            $_POST = $val->validateForm($_POST);
            (new UserController())->loginStep2($_POST['alias'], $_POST['hash']);
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

        else if ($_POST["method"] == "firstSignUp") {
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
                (new UserController())->firstSignUp($_POST['alias'], $_POST['email'], $_POST['pass'], $_POST['passConfirm']);
            }else{
                Helper\Component::showMessage(Helper\Component::$WARNING, "Captcha incorrecto");
            }
        }
        
        else if ($_POST["method"] == "hasUsers") {
            (new UserController())->hasUsers(true);
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

        else if ($_POST["method"] == "resetPass") {
            $_POST = $val->validateForm($_POST);
            (new UserController())->resetPass($_POST['email']);
        }
    }
    catch (\Exception $error) {
        Helper\Component::showMessage(2, $error->getMessage());
    }
}