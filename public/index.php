<!DOCTYPE html>
<html>

<head>
    <title>Tienda en línea</title>

    <?php include 'templates/styles.html';?>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php //include 'templates/navbar.html';?>
    <div class="carousel carousel-slider center" data-indicators="true">
        <div class="carousel-fixed-item center">
            <a class="btn waves-effect blue grey-text white-text">Ir a la tienda</a>
        </div>
        <div class="carousel-item" href="#one!" id="game1-banner">
            <div class="row">
                <div class="card  col s6 m4 push-s3 push-m4">
                    <h2 id="game1">Nier Automata</h2>
                    <p id="game1-developer">PlatinumGames</p>
                </div>
            </div>
        </div>
        <div class="carousel-item" id="game2-banner" href="#two!">
            <div class="row">
                <div class="card  col s6 m4 push-s3 push-m4">
                    <h2 id="game2">Bioshock Infinite</h2>
                    <p id="game2-developer">Irrational Games</p>
                </div>
            </div>
        </div>
        <div class="carousel-item" href="#three!" id="game3-banner">
            <div class="row">
                <div class="card  col s6 m4 push-s3 push-m4">
                    <h2 id="game3">Child of Light</h2>
                    <p id="game3-developer">Ubisoft</p>
                </div>
            </div>
        </div>
        <div class="carousel-item" href="#four!" id="game4-banner">
            <div class="row">
                <div class="card  col s6 m4 push-s3 push-m4">
                    <h2 id="game4">Darksiders</h2>
                    <p id="game4-developer">Vigil Games</p>
                </div>
            </div>
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