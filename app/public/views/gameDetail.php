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
        echo '
        <div class="gameBackground"></div>
            <div class="col s12 m6 l4">
                <div class="row">
                    <img class="center" class="col push-s2" src="'.substr($detail->getGame()->getCover(),3).'" id="gameCover" />
                </div>
                <div class="row">
                    <div class="center col s12">
                        <div class="row">
                            <strong class="col s6">
                                <p class="right text">Clasificacion</p>
                            </strong>
                            <p class="text">'.$detail->getGame()->getEsrb()->getName().'</p>
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
                <div class="col s12 center">
                    <i class="medium material-icons rate-star tooltipped" id="malo" data-tooltip="Malo" data-position="bottom" data-delay="50">star</i>
                    <i class="medium material-icons rate-star tooltipped" id="bueno" data-tooltip="Bueno" data-position="bottom" data-delay="50">star</i>
                    <i class="medium material-icons rate-star tooltipped" id="muy-bueno" data-tooltip="Muy bueno" data-position="bottom" data-delay="50">star</i>
                    <i class="medium material-icons rate-star tooltipped" id="excelente" data-tooltip="Excelente" data-position="bottom" data-delay="50">star</i>
                </div>
                <a class="col s12 center text">Ver todos los rating</a>
                <div class="row">
                    <button class="btn col s12 white black-text">$0.00</button>
                    <button class="btn col s12 blue">Al carrito</button>
                </div>
            </div>
        </div>
        
        <!--resto de informacion-->
        <h5 class="center blue white-text info">Requisitos del sistema</h5>
        <p class="game-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean auctor gravida tristique. Vestibulum est dolor, vestibulum eget vulputate consectetur, vehicula sed est. Fusce efficitur, nunc in pharetra faucibus, leo diam venenatis nunc, a </p>'; ?>
        <script src="js/gameDetail.js"/>
