<!DOCTYPE html>
<html>
    <head>
        <title>Listado de juegos</title>
        <!--estilos necesarios-->
        <?php include 'templates/styles.html';?>
    </head>
    <body>

        <!--Autenticación-->
        <?php
            include_once ("../../vendor/autoload.php");
            if (!session_id()) {
                session_start();
            }
            if (!isset($_SESSION['user'])){
                header("Location:login.php");
                die();
            }
            if ($_SESSION['user']->getUserType()->getId() != 1) {
                header("Location:login.php");
                die();
            }
        ?>

        <!--menu-->
        <?php include 'templates/sidenav.html';?>
        
        <div id="container">
        </div>
        
        
    </body>
    <!--script necesarios-->
    <?php include 'templates/scripts.html';?>
</html>