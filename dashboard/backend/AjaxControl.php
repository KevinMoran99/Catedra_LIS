<?php
    $control =$_POST['control'];

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
    }
?>