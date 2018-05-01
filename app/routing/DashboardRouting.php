<?php
/**
 * Created by PhpStorm.
 * User: oscar
 * Date: 11/03/2018
 * Time: 8:36
 */
include_once ("../../vendor/autoload.php");
$control =$_POST['control'];
$page = 1;
/*enviando la vista dependiendo de la ruta solicitada*/
session_start();
if($_SESSION['last_activity'] < time()-$_SESSION['expire_time'] ) {
    session_abort();
    $controller = new \Http\Controllers\UserController();
    $controller->logout();
    die();
} else{ //if we haven't expired:
    $_SESSION['last_activity'] = time(); //this was the moment of last activity.
    switch ($control){
        case "main":
            $ajax='true';
            $page = $_POST["current"];
            include("../dashboard/views/main.php");
            break;
        case "esrb":
            $ajax='true';
            $page = $_POST["current"];
            include("../dashboard/views/esrb.php");
            break;
        case "genre":
            $ajax='true';
            $page = $_POST["current"];
            include("../dashboard/views/genre.php");
            break;
        case "platform":
            $ajax='true';
            $page = $_POST["current"];
            include("../dashboard/views/platform.php");
            break;
        case "publisher":
            $ajax='true';
            $page = $_POST["current"];
            include("../dashboard/views/publisher.php");
            break;
        case "stadistics":
            $ajax='true';
            $page = $_POST["current"];
            include("../dashboard/views/stadistics.php");
            break;
        case "support":
            $ajax='true';
            $page = $_POST["current"];
            include("../dashboard/views/support.php");
            break;
        case "user":
            $ajax='true';
            $page = $_POST["current"];
            include("../dashboard/views/user.php");
            break;
        case "spec":
            $ajax='true';
            $page = $_POST["current"];
            include("../dashboard/views/spec.php");
            break;
        case "typeSpec":
            $ajax='true';
            $page = $_POST["current"];
            include("../dashboard/views/typeSpec.php");
            break;
        case "review":
            $ajax='true';
            $page = $_POST["current"];
            include("../dashboard/views/review.php");
            break;
            case "userType":
            $ajax='true';
            $page = $_POST["current"];
            include("../dashboard/views/userType.php");
            break;
    }
}
