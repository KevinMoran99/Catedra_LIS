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
        <?php include 'templates/sidenav.php';?>
        
        <div id="container">
            <div class="row">
                <h4 class="col s6 push-s3">Bienvenido a Sttom</h4>
            </div>
            <div class="row">
                <p class="col s6 push-s3 blue-text">Elija una de las opciones del menu disponibles para continuar</p>
            </div>
        </div>
        
        
    </body>
    <!--script necesarios-->
    <?php include 'templates/scripts.html';?>
</html>