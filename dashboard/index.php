<!DOCTYPE html>
<html>
    <head>
        <title>Listado de juegos</title>

        <?php include 'templates/styles.html';?>
    </head>
    <body>
        
        <!--menu-->
        <?php include 'templates/sidenav.html';?>
        
        <div class="wrapper">
            Como aquí se haría el mantenimiento de los juegos, se me ocurre que sea la misma vista de 
            la búsqueda de juegos que está en el sitio público, pero modeada para las funciones de 
            administrador. Al hacer click en un juego, que igualmente se abra la misma vista que se 
            abriría al seleccionar un juego en el sitio público, mostrando ratings, comentarios, etc,
            pero con los respectivos controles para editarlo, ponerlo en oferta, etc.
        </div>
        
    </body>
    <?php include 'templates/scripts.html';?>
    <script src="js/index.js"></script>
</html>