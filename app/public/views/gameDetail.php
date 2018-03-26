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
    $detail = $page->getPage($id, false);
    $rating = new Control\RatingController();
    $ratings = $rating->getRatingsByPage($id, false);
    $bill = new Control\BillController();
    $bills = $bill->getAllBills();
    $spec = new Control\PageSpecController();
    $specs = $spec->getSpecsByPage($id, false);
    //PRIMERA SECCION
    echo '
        <div class="gameBackground"></div>
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
        </div>
        <h5 class="center blue-text info">Reviews de usuarios</h5>
        <div class="row">';
    //FIN TERCERA SECCION
    //CUARTA SECCION

    foreach ($ratings as $row) {
        $recommended = $row->getRecommended() ? "Recomendado" : "No recomendado";
        $color = $row->getRecommended() ? "green" : "red";
        echo '
            <div class="card col l6 m6 s12">
                <div class="row ' . $color . '">
                        <h5 class="white-text review-container">' . $row->getBillItem()->getBill()->getUser()->getAlias() . ': ' . $recommended . '</h5>
                </div>
                <p class="review-container">' . $row->getDescription() . '</p>
            </div>
            ';
    }
    //FIN CUARTA SECCION
    echo '</div>';
    //SEXTA SECCION
    $buyed = false;
    foreach ($bills as $bill) {
        for ($i = 0; $i < sizeof($bill->getItems()); $i++) {
            if ($bill->getItems()[$i]->getStorePage()->getId() == $id) {
                $buyed = true;
            }
        }

    }

    if ($buyed) {
        echo '<div class="fixed-action-btn horizontal click-to-toggle">
                        <a href="#nuevaReview" class="btn-floating btn-large light-blue darken-2 waves-effect waves-light modal-trigger" data-position="left" data-delay="50">
                            <i class="material-icons">add</i>
                        </a>
                    </div>';
    }//FIN SEXTA SECCION
    ; ?>

    <script>
        var gameId = "<?php echo $id; ?>";
    </script>

    <script src="js/gameDetail.js"></script>
