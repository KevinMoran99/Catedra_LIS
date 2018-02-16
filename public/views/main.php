<!--Banners dinamicos-->
<div class="carousel carousel-slider center" data-indicators="true">
            <div class="carousel-item" href="#one!" id="game1-banner">
                <div class="carousel-fixed-item center white-text carousel-footer">
                    <h2 id="game1">Nier Automata</h2>
                    <p id="game1-developer">PlatinumGames</p>
                    <a class="btn waves-effect blue grey-text white-text">Ir a la tienda</a>
                </div>
            </div>
            <div class="carousel-item" id="game2-banner" href="#two!">
                <div class="carousel-fixed-item center white-text carousel-footer">
                    <h2 id="game2">Bioshock Infinite</h2>
                    <p id="game2-developer">Irrational Games</p>
                    <a class="btn waves-effect blue grey-text white-text">Ir a la tienda</a>
                </div>
            </div>
            <div class="carousel-item" href="#three!" id="game3-banner">
                <div class="carousel-fixed-item  center white-text carousel-footer">
                    <h2 id="game3">Child of Light</h2>
                    <p id="game3-developer">Ubisoft</p>
                    <a class="btn waves-effect blue grey-text white-text">Ir a la tienda</a>
                </div>
            </div>
            <div class="carousel-item" href="#four!" id="game4-banner">
                <div class="carousel-fixed-item center white-text carousel-footer">
                    <h2 id="game4">Darksiders</h2>
                    <p id="game4-developer">Vigil Games</p>
                    <a class="btn waves-effect blue grey-text white-text">Ir a la tienda</a>
                </div>
            </div>
        </div>

        <div class="row">
            <h4 class="left">Explora nuestros juegos</h4>
            <form id="search-game-form" class="right col s2">
                <div class="input-field col s12">
                    <i class="material-icons prefix">search</i>
                    <input id="search-game" type="text" class="validate">
                    <label for="search-game">Buscar</label>
                </div>
            </form>
        </div>
        <!--Feed-->
        <div class="row">
            <?php 
            for($i = 0; $i<=10; $i++){
                echo '<div class="col s6 m3 l3">
                        <div class="card">
                            <div class="card-image">
                                <img src="img/example.png">
                                <span class="card-title">Nombre Juego</span>
                            </div>
                        </div>
                    </div>';
            } ?>

        </div>