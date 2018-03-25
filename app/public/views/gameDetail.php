<?php
//declarando namespace a utilizar
use Http\Controllers as Control;
?>
<link rel="stylesheet" href="css/gameDetail.css">
<!--vista de detalle de juegos -->

<!--header con todos los datos-->
<div class="row" id="gameDetailHeader">

        <?php
        $page = new Control\StorePageController();
        $detail = $page->getPage($id,false);
        $rating = new Control\RatingController();
        echo '
        <div class="gameBackground"></div>
            <div class="col s12 m6 l4">
                <div class="row">
                    <img class="center" class="col push-s2" src="'.substr($detail->getGame()->getCover(),3).'" id="gameCover" />
                </div>
                <div class="row">
                    <div class="center col s12">
                        <div class="row">
                            <p class="text">Clasificacion</p>
                           
                            <h5 class="text">'.$detail->getGame()->getEsrb()->getName().'</h5>
                            <p id="banner">'.substr($detail->getGame()->getBanner(),3).'</p>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="col s12 m6 l4 game-description">
        
                <div class="info">
                    <h5 class="text">Descripcion</h5>
                    <p class="text">'.$detail->getGame()->getDescription().'
                    </p>
                    <h5 class="text">Disponible para: </h5>
                    <ul class="text">
                        <li>*Cualquier cosa que no tenga kevin</li>
                    </ul>
                    <h5></h5>
                </div>
        
        
            </div>
        
            <div class="col s12 m6 l4">
        
                <h5 class="col s12 center text">Rating promedio</h5>
                <div class="col s12 center text">
                    '.$rating->getFavorableByPage($detail->getId()).'
                </div>
                
                <div class="row">
                    
                    <button class="btn col s12 white black-text">'.$detail->getFinalPrice().'$</button>
                    <button id="cartButton" class="btn col s12 blue">Al carrito</button>
                </div>
            </div>
        </div>
        
        <!--resto de informacion-->
        <h5 class="center blue white-text info">Reviews de usuarios</h5>
        <p class="game-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean auctor gravida tristique. Vestibulum est dolor, vestibulum eget vulputate consectetur, vehicula sed est. Fusce efficitur, nunc in pharetra faucibus, leo diam venenatis nunc, a </p>'; ?>

    <script src="js/gameDetail.js">
        var gameId = "<?php echo $id; ?>";
    </script>
