<!DOCTYPE html>
<html>
    <head>
        <title>Tienda en línea</title>

        <?php include 'templates/styles.html';?>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        
        <!--menu-->
        <?php include 'templates/navbar.html';?>
        
        <!--Slider principal-->
        <div id="main" class="row">
            <div class="col s12 l7">
                <div class="carousel carousel-slider">
                    <div id="prevButton" class="carousel-fixed-item">
                        <a href="#aaa">
                            <i class="medium material-icons left">keyboard_arrow_left</i>
                        </a>
                    </div>
                    <a class="carousel-item" href="gameDetail.php"><img src="https://picsum.photos/800/500"></a>
                    <a class="carousel-item" href="gameDetail.php"><img src="https://picsum.photos/800/500"></a>
                    <a class="carousel-item" href="gameDetail.php"><img src="https://picsum.photos/800/500"></a>
                    <div id="nextButton" class="carousel-fixed-item">
                        <a href="#www">
                            <i class="medium material-icons right">keyboard_arrow_right</i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col s12 l3">
                Info del juego o no se
            </div>
        </div>
        
        
        <!--Feed-->
        <div class="row">
            <div class="col s12">
                <div class="card horizontal">
                    <div class="card-image">
                        <img src="https://picsum.photos/320/240">
                    </div>
                    <div class="card-stacked">
                        <div class="card-content">
                            <p>Info del jueguito lindo</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <div class="card horizontal">
                    <div class="card-image">
                        <img src="https://picsum.photos/320/240">
                    </div>
                    <div class="card-stacked">
                        <div class="card-content">
                            <p>Info del jueguito lindo</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <div class="card horizontal">
                    <div class="card-image">
                        <img src="https://picsum.photos/320/240">
                    </div>
                    <div class="card-stacked">
                        <div class="card-content">
                            <p>Info del jueguito lindo</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </body>
    <?php include 'templates/scripts.html';?>
    <script src="js/index.js"></script>
</html>