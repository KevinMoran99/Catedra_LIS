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
                $user = $_SESSION["user"];
                if ($user->getType() == 1)
                    Helper\Component::showMessage(3, "admin");
                else
                    Helper\Component::showMessage(3, "cliente");
            }
            else
                Helper\Component::showMessage(3, "La contraseña especificada es incorrecta.");
        }
        else
            Helper\Component::showMessage(3, "No existe ningún usuario con el alias o email especificado.");

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
    }
    catch (\Exception $error) {
        Helper\Component::showMessage(2, $error->getMessage());
    }
}