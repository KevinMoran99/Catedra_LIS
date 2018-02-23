<?php
    $control =$_POST['control'];

    switch ($control){
        case "main":
          include("../views/main.php");
        break;
        case "games":
          include("../views/games.php");
        break;
        case "about":
            include("../views/about.php");
        break;
        case "gameDetail":
            include("../views/gameDetail.php");
        break;
        case "support":
            include("../views/support.php");
        break;
        case "cart":
            include("../views/cart.php");
        break;
        case "rating":
            include("../views/rating.php");
        break;
    }
?>