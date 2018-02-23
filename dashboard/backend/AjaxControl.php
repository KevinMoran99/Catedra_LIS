<?php
    $control =$_POST['control'];
    /*enviando la vista dependiendo de la ruta solicitada*/
    switch ($control){
        case "main":
          include("../views/main.php");
        break;
        case "esrb":
          include("../views/esrb.php");
        break;
        case "genre":
            include("../views/genre.php");
        break;
        case "platform":
            include("../views/platform.php");
        break;
        case "publisher":
            include("../views/publisher.php");
        break;
        case "stadistics":
            include("../views/stadistics.php");
        break;
        case "support":
            include("../views/support.php");
        break;
        case "user":
            include("../views/user.php");
        break;
        case "spec":
            include("../views/spec.php");
        break;
        case "typeSpec":
            include("../views/typeSpec.php");
        break;
    }
?>