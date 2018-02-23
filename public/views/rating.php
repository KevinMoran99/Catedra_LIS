<link rel="stylesheet" href="css/gameDetail.css">
<!--vista de rating -->
<!--header-->
<div class="row" id="gameDetailHeader">
    <div class="gameBackground"></div>
    <div class="col s12 m6 l4">

        <div class="row">
            <img class="center" class="col push-s2" src="../web/img/example2.png" id="gameCover" />
        </div>
        <div class="row">
            <h5 class="col s12 center">Rating promedio</h5>
            <div class="col s12 center">
                <i class="medium material-icons rate-star tooltipped" id="malo" data-tooltip="Malo" data-position="bottom" data-delay="50">star</i>
                <i class="medium material-icons rate-star tooltipped" id="bueno" data-tooltip="Bueno" data-position="bottom" data-delay="50">star</i>
                <i class="medium material-icons rate-star tooltipped" id="muy-bueno" data-tooltip="Muy bueno" data-position="bottom" data-delay="50">star</i>
                <i class="medium material-icons rate-star tooltipped" id="excelente" data-tooltip="Excelente" data-position="bottom" data-delay="50">star</i>
            </div>
        </div>
    </div>

    <div class="col s12 m12 l8">
        <div class="info card">
            <h5>Filtrar por rating</h5>
            <div class="input-field col s12 white-text">
                <select id="select-rating">
                    <option value="1">Excelente</option>
                    <option value="2">Bueno</option>
                    <option value="3">Malo</option>
                </select>
            </div>
            <h5>Filtrar por fecha</h5>
            <div class="row">
                <div class="col s6">
                    <input type="text" class="datepicker">
                    <label>Desde</label>
                </div>
                <div class="col s6">
                    <input type="text" class="datepicker">
                    <label>Hasta</label>
                </div>
            </div>
        </div>
        <a class="btn-floating btn-large waves-effect waves-light right red tooltipped modal-trigger" data-position="bottom" data-delay="50" data-tooltip="Agregar review" href="#modalRating"><i class="material-icons">add</i></a>
    </div>

</div>

<!-- generando varios datos-->
<?php 
    for($i=0;$i<3;$i++){
        echo ('
        <div class="row blue ">
        <h5 class="left col s6 white-text info">Requisitos del sistema</h5>
        <div class="col  right">
                <i class="medium material-icons rate-star tooltipped" id="malo" data-tooltip="Malo" data-position="bottom" data-delay="50">star</i>
                <i class="medium material-icons rate-star tooltipped" id="bueno" data-tooltip="Bueno" data-position="bottom" data-delay="50">star</i>
                <i class="medium material-icons rate-star tooltipped" id="muy-bueno" data-tooltip="Muy bueno" data-position="bottom" data-delay="50">star</i>
                <i class="medium material-icons rate-star tooltipped" id="excelente" data-tooltip="Excelente" data-position="bottom" data-delay="50">star</i>
            </div>
        </div>
        <p class="game-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean auctor gravida tristique. Vestibulum est dolor, vestibulum eget vulputate consectetur, vehicula sed est. Fusce efficitur, nunc in pharetra faucibus, leo diam venenatis nunc, a </p>');
    }
?>

<!--Modal de rating-->
<div id="modalRating" class="modal">
    <div class="modal-content">
        <div class="modal-header row white-text valign-wrapper">
            <div class="col m2 s3">
                <img class="responsive-img" src="../web/img/logo.png">
            </div>
            <div class="col m10 s9">
                <h4 class="">Crear nuevo rating para este juego</h4>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m8 offset-m2 center-align">
                <form id="frmRating">
                    <div class="row">
                        <p class="col s3">Tu review</p>
                        <div class="col s9">
                            <i class="medium material-icons rate-star tooltipped" id="malo" data-tooltip="Malo" data-position="bottom" data-delay="50">star</i>
                            <i class="medium material-icons rate-star tooltipped" id="bueno" data-tooltip="Bueno" data-position="bottom" data-delay="50">star</i>
                            <i class="medium material-icons rate-star tooltipped" id="muy-bueno" data-tooltip="Muy bueno" data-position="bottom" data-delay="50">star</i>
                            <i class="medium material-icons rate-star tooltipped" id="excelente" data-tooltip="Excelente" data-position="bottom" data-delay="50">star</i>
                        </div>
                    </div>
                    <div class="row">
                        <p class="col s3">Comentario</p>
                        <div class="col s9">
                            <textarea class="materialize-textarea"></textarea>
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Cancelar</a>
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Enviar</a>
    </div>
</div>


<script src="js/rating.js"></script>