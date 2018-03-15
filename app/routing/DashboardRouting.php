<?php
/**
 * Created by PhpStorm.
 * User: oscar
 * Date: 11/03/2018
 * Time: 8:36
 */
include_once ("../../vendor/autoload.php");
$control =$_POST['control'];
/*enviando la vista dependiendo de la ruta solicitada*/
switch ($control){
    case "main":
        $page = $_POST["current"];
        include("../dashboard/views/main.php");
        break;
    case "esrb":
        $page = $_POST["current"];
        include("../dashboard/views/esrb.php");
        break;
    case "genre":
        $page = $_POST["current"];
        include("../dashboard/views/genre.php");
        break;
    case "platform":
        $page = $_POST["current"];
        include("../dashboard/views/platform.php");
        break;
    case "publisher":
        $page = $_POST["current"];
        include("../dashboard/views/publisher.php");
        break;
    case "stadistics":
        $page = $_POST["current"];
        include("../dashboard/views/stadistics.php");
        break;
    case "support":
        $page = $_POST["current"];
        include("../dashboard/views/support.php");
        break;
    case "user":
        include("../dashboard/views/user.php");
        break;
    case "spec":
        $page = $_POST["current"];
        include("../dashboard/views/spec.php");
        break;
    case "typeSpec":
        $page = $_POST["current"];
        include("../dashboard/views/typeSpec.php");
        break;
}