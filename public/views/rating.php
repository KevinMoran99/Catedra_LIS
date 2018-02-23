<link rel="stylesheet" href="css/gameDetail.css">
<div class="navbar-fixed">
    <nav class="center-align">
        <h5>Kevin no lo ha jugado</h5>
    </nav>
</div>
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
                <select>
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
        <a class="btn-floating btn-large waves-effect waves-light right red tooltipped" data-position="bottom" data-delay="50" data-tooltip="Agregar review"><i class="material-icons">add</i></a>
    </div>

</div>
<h5 class="center blue white-text info">Requisitos del sistema</h5>
<p class="game-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean auctor gravida tristique. Vestibulum est dolor, vestibulum eget vulputate consectetur, vehicula sed est. Fusce efficitur, nunc in pharetra faucibus, leo diam venenatis nunc, a </p>

<script src="js/rating.js"></script>