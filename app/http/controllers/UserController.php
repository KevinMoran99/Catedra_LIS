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

    public function logout() {
        session_start();
        session_destroy();
    }
}

//script ejecutado al llamar al controlador con ajax
if(isset($_POST["method"])){
    include_once ("../../../vendor/autoload.php");
    try {
        if ($_POST["method"] == "login") {
            $data = $_POST["input"];
            $params = array();
            parse_str($data, $params);
            (new UserController())->login($params['name'], $params['pass']);
        }
        else if ($_POST["method"] == "logout") {
            (new UserController())->logout();
        }
    }
    catch (\Exception $error) {
        Helper\Component::showMessage(2, $error->getMessage());
    }
}