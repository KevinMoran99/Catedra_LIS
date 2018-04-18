<?php
/**
 * Created by PhpStorm.
 * User: oscar
 * Date: 11/03/2018
 * Time: 8:37
 */
include_once ("../../vendor/autoload.php");

$control =$_POST['control'];
//retornamos la vista seleccionada
switch ($control){
    case "main":
        $page = $_POST["current"];
        include("../public/views/main.php");
        break;
    case "games":
        $page = $_POST["current"];
        if (isset($_POST["searchType"])) {
            $searchType = $_POST["searchType"];
            $param = $_POST["param"];
        }
        include("../public/views/games.php");
        break;
    case "about":
        $page = $_POST["current"];
        include("../public/views/about.php");
        break;
    case "gameDetail":
        $id = $_POST["id"];
        include("../public/views/gameDetail.php");
        break;
    case "support":
        $page = $_POST["current"];
        include("../public/views/support.php");
        break;
    case "cart":
        $page = $_POST["current"];
        include("../public/views/cart.php");
        break;
    case "rating":

        include("../public/views/rating.php");
        break;
}

