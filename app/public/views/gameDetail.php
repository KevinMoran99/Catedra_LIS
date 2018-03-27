<?php
//declarando namespace a utilizar
use Http\Controllers as Control;

?>
<link rel="stylesheet" href="css/gameDetail.css">
<!--vista de detalle de juegos -->

<!--header con todos los datos-->
<div class="row" id="gameDetailHeader">
    <?php
    //iniciando sesion para utilizar posteriormente
    session_start();
    //variables principales
    $page = new Control\StorePageController();
    $detail = $page->getPage($id, false);
    $rating = new Control\RatingController();
    $ratings = $rating->getRatingsByPage($id, false);
    $bill = new Control\BillController();
    $spec = new Control\PageSpecController();
    $specs = $spec->getSpecsByPage($id, false);
    $ratingId = 0;
    //PRIMERA SECCION
    echo '
        <div class="gameBackground"></div>
            <p id="dominantColor">' . implode(',', $detail->getDominantColor()) . '</p>
            <div class="col s12 m6 l4">
                <div class="row">
                    <img class="center" class="col push-s2" src="' . substr($detail->getGame()->getCover(), 3) . '" id="gameCover" />
                </div>
                <div class="row">
                    <div class="center col s12">
                        <div class="row">
                            <p class="text">Clasificacion</p>
                           
                            <h5 class="text">' . $detail->getGame()->getEsrb()->getName() . '</h5>
                            <p id="banner">' . substr($detail->getGame()->getBanner(), 3) . '</p>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="col s12 m6 l4 game-description">
        
                <div class="info">
                    <h5 class="text">Descripcion</h5>
                    <p class="text">' . $detail->getGame()->getDescription() . '
                    </p>
                    <h5 class="text">Disponible para: </h5>
                    <ul class="text">';
    //FIN PRIMERA SECCION

    //SEGUNDA SECCION
    if (is_string($specs)) {
        echo '<p class="text">' . $specs . '</p>';
    } else {
        foreach ($specs as $spec) {
            echo '
                                <li class="text">' . $spec->getSpec()->getTypeSpec()->getName() . ': ' . $spec->getSpec()->getName() . '</li>
                            ';
        }
    }
    //FIN SEGUNDA SECCION
    //TERCERA SECCION
    echo '</ul>
                </div>
        
            </div>
        
            <div class="col s12 m6 l4">
                <h5 class="col s12 center text">Rating promedio</h5>
                <div class="col s12 center">
                   <h5 class="text">' . $rating->getFavorableByPage($detail->getId()) . '</h5>
                </div>
                
                <div class="row">
                    
                    <button class="btn col s12 white black-text">' . $detail->getFinalPrice() . '$</button>
                    <button id="cartButton" class="btn col s12 blue">Al carrito</button>
                </div>
            </div>
        </div> ';
    //FIN TERCERA SECCION
    //CUARTA SECCION
    if (sizeof($ratings) == 0) {
        echo '<h5 class="center-align text">Vaya parece que no hay reviews disponibles :(</h5>
                <p class="center-align text">Vuelve mas tarde o crea una tu mismo si posees el juego</p>';
    }
    if (isset($_SESSION['user'])) {
        $bills = $bill->getBillsByUser($_SESSION['user']->getId(), false);
    }
    foreach ($ratings as $row) {
        print $row->getId();
        $recommended = $row->getRecommended() ? "Recomendado" : "No recomendado";
        $color = $row->getRecommended() ? "green" : "red";
        if (isset($_SESSION['user'])) {
            if ($row->getBillItem()->getBill()->getUser()->getId() == $_SESSION['user']->getId()) {
                $ratingId = $row->getId();
            }
        }
        echo '
            <div class="card review-card col l6 m6 s12">
            <div>'.$row->getId().'</div>
                <div class="row ' . $color . '">
                        <h5 class="text review-container">' . $row->getBillItem()->getBill()->getUser()->getAlias() . ': ' . $recommended . '</h5>
                </div>
                <p class="review-container">' . $row->getDescription() . '</p>
            </div>
            ';
    }
    //FIN CUARTA SECCION
    echo '</div>';
    //SEXTA SECCION
    if (isset($_SESSION['user'])) {
        $buyed = false;
        $billItem = 0;
        foreach ($bills as $bill) {
            for ($i = 0; $i < sizeof($bill->getItems()); $i++) {
                if ($bill->getItems()[$i]->getStorePage()->getId() == $id) {
                    $buyed = true;
                    $billItem = $bill->getItems()[$i]->getId();
                }
            }

        }

        if ($buyed) {
            echo '<div class="fixed-action-btn horizontal click-to-toggle">
                        <a href="#review-modal" class="btn-floating btn-large light-blue darken-2 waves-effect waves-light modal-trigger" data-position="left" data-delay="50">
                            <i class="material-icons">add</i>
                        </a>
                    </div>';
        }//FIN SEXTA SECCION
        ;
    }
    $descripcionRating = "";
    $selected = '';
    if ($ratingId != 0) {
        $myRating = $rating->getRating($ratingId, false);
        $descripcionRating = $myRating->getDescription();
        if (!$myRating->getRecommended()) {
            $selected = 'checked';
        }
    }
    echo '
    <div id="review-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header row blue white-text">
                <div class="col m10 s9">
                    <h3 class="">Mi review</h3>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m8 offset-m2 center-align">
                <input id="myReviewId" type="hidden" name="id" value="'.$ratingId.'">
                    <form id="frmReview">
                        <input type="hidden" name="bill_item_id" value="'.$billItem.'">
                        <div class="input-field">
                            <textarea id="review-description" name="description" class="materialize-textarea">' . $descripcionRating . '</textarea>
                            <label for="textarea1" class="active">Descripcion</label>
                        </div>

                        <div class="row">
                            <h6 class="center">Recomendaria este juego:</h6>
                            <div class="input-field col s6 push-s1">
                                <div class="col s12 m6 push-m5">
                                    <p>
                                        <label>
                                            <input name="recommended" value="1" type="radio" checked />
                                            <span class="green-text">Si</span>
                                        </label>
                                    </p>
                                </div>
                                <div class="col s12 m6 push-m4">
                                    <p>
                                        <label>
                                            <input name="recommended" value="0" type="radio" ' . $selected . '/>
                                            <span class="red-text">No</span>
                                        </label>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <button type="submit" class="modal-submit btn waves-effect right">Enviar</button>
                            <button type="reset" class="btn waves-effect right modal-close">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>';
    ?>
    <script>
        var gameId = "<?php echo $id; ?>";
    </script>

    <script src="js/gameDetail.js"></script>
