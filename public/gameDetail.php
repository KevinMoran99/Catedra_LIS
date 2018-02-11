<!DOCTYPE html>
<html>
    <head>
        <title>Juego chulo</title>

        <?php include 'templates/styles.html';?>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        
        <!--menu-->
        <?php include 'templates/navbar.html';?>
        
        <div class="row">
            <div class="col m10 offset-m1">
                <div id="main" class="row">
                    <div class="col s12 l7">
                        <a href="#"><img class="responsive-img" src="https://picsum.photos/600/400"></a>
                    </div>
                    <div class="col s12 l3">
                        Info del juego o no se
                    </div>
                </div>
                
                
                
                <div class="row">
                    <div class="input-field col s12">
                        <input id="comment" type="text">
                        <label for="comment">Hacer comentario</label>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12">
                        <div class="card horizontal">
                            Comentarios
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <div class="card horizontal">
                            Comentarios
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <div class="card horizontal">
                            Comentarios
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </body>
    <?php include 'templates/scripts.html';?>
    <script src="js/index.js"></script>
</html>