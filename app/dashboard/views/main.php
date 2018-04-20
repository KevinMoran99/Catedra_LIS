<?php
//declarando namespace a utilizar
use Http\Controllers as Control;
use Http\Helpers as Helper;

?>
<!--vista principal-->

<!--navbar
<div class="navbar-fixed">
    <nav>
        <h5 id="nav-title">Todos los juegos:</h5>
        <div id="filter-container" class="input-field">
            <select id="game-filter">
                <option value="" disabled selected>Todos</option>
                <option value="1">Option 1</option>
                <option value="2">Option 2</option>
                <option value="3">Option 3</option>
            </select>
        </div>
    </nav>
</div>
-->
<div class="navbar-fixed">
    <nav>
        <h5 id="nav-title">Todos los juegos:</h5>
        <div id="filter-container" class="input-field">
            <div class="row search-box">
                <!--Añadir filtro para especificaciones-->
                <div>

                </div>
            </div>
        </div>
    </nav>
</div>

<div class="wrapper">
    <div class="row search-box">
        <!--Añadir filtro para generos-->
        <div class="col s12 m6 offset-m3">
            <div class="card-search-box hoverable white">
                <div>
                    <input id="game-search" type="text" class="validate filtro" name="filtro"
                           placeholder="Buscar por cualquier parametro">

                </div>
            </div>
        <div class="row">
            <div class="col s6">
            <button class="btn light-blue darken-2" id="revert">Revertir</button>
            </div>
            <div class="col s6">
            <form method="post" target="_blank" action="views/pdf/DiscountGames.php">
                <button class="btn green darken-2 right" id="revert">Reporte Descuentos</button>
            </form>
            </div>
        </div>
    </div>
</div>

    <div id="allGames" class="row">
        <!--INICIO DEL PAGINATE -->

        <?php
        //mostrando los datos solicitados en base al paginate
        $current_page = $page;
        $games = new Control\GameController();
        $paginate = new Helper\Paginate($games->getAllGames(), $current_page);
        foreach ($paginate->getData() as $row) {

            echo '<div class="col s6 m3 l3 game">
        <a class="modal-trigger edit" href="#actualizarJuego">
            <div class="card">
                <div class="card-image">
                    <img src="' . substr($row->getCover(), 3) . '">
                    <span class="card-title">' . $row->getName() . '</span>
                    <span id="gameId" class="id" style="visibility: hidden; display:none;">' . $row->getId() . '</span>
                </div>
            </div>
        </a>
    </div>';
        }
        ?>
    </div>
    <br>
    <div id="gameLinks">
        <!--INICIO DE ENLACES DE PAGINATE-->
        <?php
        //generando los links de paginacion
        echo "<div class='row'>";
        for ($i = 1; $i <= $paginate->linksNumber(); $i++) {
            echo "<a class='col s1 red-text' onclick=\"attach('main' ,$i)\">$i</a>";
        }
        echo "</div>"
        ?>
    </div>
    <div class="fixed-action-btn">
        <a class="btn-floating btn-large waves-effect waves-light red modal-trigger" href="#nuevoJuego">
            <i class="material-icons">add</i>
        </a>
    </div>
</div>

<!--modal agregar nuevo juego-->
<div id="nuevoJuego" class="modal">
    <div class="modal-content">
        <div class="modal-header row blue white-text">
            <div class="col m10 s9">
                <h3 class="">Nuevo juego</h3>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m8 offset-m2">
                <form id="frmRegJg" enctype="multipart/form-data">
                    <div class="file-field input-field">
                        <div class="btn">
                            <span>Caratula</span>
                            <input name="cover" id="image" accept="image/*" type="file">
                        </div>
                        <div class="file-path-wrapper">
                            <input name="cover" class="file-path validate" type="text" required>
                        </div>
                    </div>
                    <div class="file-field input-field">
                        <div class="btn">
                            <span>Banner</span>
                            <input name="banner" id="image2" accept="image/*" type="file">
                        </div>
                        <div class="file-path-wrapper">
                            <input name="banner" class="file-path validate" type="text" required>
                        </div>
                    </div>
                    <div class="input-field">
                        <input name="name" id="gameName" type="text" minlength="3" maxlength="50"
                               pattern="^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\.]{3,50}$" title="Solo se permiten números y letras"
                               required>
                        <label for="gameName">Nombre de juego</label>
                    </div>
                    <div class="input-field">
                        <textarea name="description" class="materialize-textarea" id="registerUser" type="text"
                                  minlength="3" maxlength="500"
                                  pattern="^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\'\.\,\:\;\¿\?\-\!]{3,500}$"
                                  title="Solo se permiten números, letras y signos de puntuación" required></textarea>
                        <label for="registerUser">Descripcion</label>
                    </div>
                    <div class="input-field">
                        <select name="esrb" id="EsrbSelect" class="formSelect" required>
                            <option value="" disabled="disabled" selected="true">Clasificacion</option>
                            <?php
                            $esrbs = new Control\EsrbController();
                            foreach ($esrbs->getAllEsrb() as $esrb) {
                                echo "<option value=" . $esrb->getId() . ">" . $esrb->getName() . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-field">
                        <select name="genre" id="genreSelect" class="formSelect" required>
                            <option value="" disabled="disabled" selected="true">Genero</option>
                            <?php
                            $genres = new Control\GenreController();
                            foreach ($genres->getAllGenres() as $genre) {
                                echo "<option value=" . $genre->getId() . ">" . $genre->getName() . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <!--<div class="input-field">
                        <select name="platform" id="platformSelect" class="formSelect"  required>
                        <option value="" disabled="disabled" selected="true">Plataforma</option>
                        <?php
                    /*$platforms = new Control\PlatformController();
                    foreach ($platforms->getAllPlatforms() as $platform) {
                        echo "<option value=".$platform->getId().">".$platform->getName()."</option>";
                    }*/
                    ?>
                        </select>
                    </div>-->
                    <div class="input-field">
                        <select name="publisher" id="publisherSelect" class="formSelect" required>
                            <option value="" disabled="disabled" selected="true">Publicador</option>
                            <?php
                            $publishers = new Control\PublisherController();
                            foreach ($publishers->getAllPublishers() as $publisher) {
                                echo "<option value=" . $publisher->getId() . ">" . $publisher->getName() . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="row">
                        <h6 class="center">Seleccione el estado del juego:</h6>
                        <div class="input-field col s6 push-s1">
                            <div class="col s12 m6 push-m5">
                                <p>
                                    <label>
                                        <input name="state" type="radio" checked value="1"/>
                                        <span>Activo</span>
                                    </label>
                                </p>
                            </div>
                            <div class="col s12 m6 push-m4">
                                <p>
                                    <label>
                                        <input name="state" type="radio" value="0"/>
                                        <span>Inactivo</span>
                                    </label>
                                </p>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <button type="submit" class="modal-submit btn waves-effect right">Ingresar</button>
                        <button class="btn waves-effect right modal-close">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--Modal de actualizar juego-->
<div id="actualizarJuego" class="modal">
    <div class="modal-content">
        <div class="modal-header row blue white-text">
            <div class="col m10 s9">
                <h3 class="">Actualizar juego</h3>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m8 offset-m2">
                <form id="frmActJg" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="gameId">
                    <div class="file-field input-field">
                        <div class="btn">
                            <span>Caratula</span>
                            <input name="cover" id="image" accept="image/*" type="file">
                        </div>
                        <div class="file-path-wrapper">
                            <input id="gameCoverU" name="cover" accept="image/*" class="file-path validate" type="text">
                        </div>
                    </div>
                    <div class="file-field input-field">
                        <div class="btn">
                            <span>Banner</span>
                            <input name="banner" id="image2" accept="image/*" type="file">
                        </div>
                        <div class="file-path-wrapper">
                            <input id="gameBannerU" name="banner" accept="image/*" class="file-path validate"
                                   type="text">
                        </div>
                    </div>
                    <div class="input-field">
                        <input id="gameNameU" name="name" type="text" minlength="3" maxlength="50"
                               pattern="^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\.]{3,50}$" title="Solo se permiten números y letras"
                               required>
                        <label id="gameNameLabelU" for="gameNameU">Nombre de juego</label>
                    </div>
                    <div class="input-field">
                        <textarea class="materialize-textarea" name="description" id="gameDesc" type="text"
                                  minlength="3" maxlength="500"
                                  pattern="^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\'\.\,\:\;\¿\?\-\!]{3,500}$"
                                  title="Solo se permiten números, letras y signos de puntuación" required></textarea>
                        <label id="gameDescLabelU" for="registerUser">Descripcion</label>
                    </div>
                    <div class="input-field">
                        <select id="EsrbSelectU" name="esrb" class="formSelect" required>
                            <option value="" disabled="disabled" selected="true">Clasificacion</option>
                            <?php
                            $esrbs = new Control\EsrbController();
                            foreach ($esrbs->getAllEsrb() as $esrb) {
                                echo "<option value=" . $esrb->getId() . ">" . $esrb->getName() . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-field">
                        <select id="genreSelectU" name="genre" class="formSelect" required>
                            <option value="" disabled="disabled" selected="true">Genero</option>
                            <?php
                            $genres = new Control\GenreController();
                            foreach ($genres->getAllGenres() as $genre) {
                                echo "<option value=" . $genre->getId() . ">" . $genre->getName() . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <!--<div class="input-field">
                        <select id="platformSelectU" name="platform" class="formSelect" required>
                        <option value="" disabled="disabled" selected="true">Plataforma</option>
                        <?php
                    /*$platforms = new Control\PlatformController();
                    foreach ($platforms->getAllPlatforms() as $platform) {
                        echo "<option value=".$platform->getId().">".$platform->getName()."</option>";
                    }*/
                    ?>
                        </select>
                    </div>-->
                    <div class="input-field">
                        <select id="publisherSelectU" name="publisher" class="formSelect" required>
                            <option value="" disabled="disabled" selected="true">Publicador</option>
                            <?php
                            $publishers = new Control\PublisherController();
                            foreach ($publishers->getAllPublishers() as $publisher) {
                                echo "<option value=" . $publisher->getId() . ">" . $publisher->getName() . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-field">
                        <div class="row">
                            <a class="waves-effect waves-teal btn-flat modal-trigger blue-text center-align" href="#storePageModal">Agregar
                                pagina en la tienda para este juego</a>
                        </div>
                        <div class="row">
                            <a id="modPageButton" class="waves-effect waves-teal btn-flat blue-text center-align modal-trigger"
                               href="#storePageGestModal">Gestionar paginas en la tienda de este juego</a>
                        </div>
                    </div>
                    <div class="row">
                        <h6 class="center">Seleccione el estado del juego:</h6>
                        <div class="input-field col s6 push-s1">
                            <div class="col s12 m6 push-m5">
                                <p>
                                    <label>
                                        <input id="gameStateActU" name="state" type="radio" checked value="1"/>
                                        <span>Activo</span>
                                    </label>
                                </p>
                            </div>
                            <div class="col s12 m6 push-m4">
                                <p>
                                    <label>
                                        <input id="gameStateIncU" name="state" type="radio" checked values="0"/>
                                        <span>Inactivo</span>
                                    </label>
                                </p>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <button type="submit" class="modal-submit btn waves-effect right">Modificar</button>
                        <button class="btn waves-effect right modal-close">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--Modal de agregar storepages-->
<div id="storePageModal" class="modal">
    <div class="modal-content">
        <div class="modal-header row blue white-text">
            <div class="col m10 s9">
                <h3 class="">Agregar Storepage</h3>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m8 offset-m2">
                <form id="frmStrPg">
                    <div class="input-field">
                        <label for="gameDate">Fecha de lanzamiento</label>
                        <input id="gameDate" name="release_date" type="text" class="datepicker">
                    </div>
                    <div class="input-field">
                        <input name="price" id="gamePrice" type="number" step="0.01" pattern="^([0-9]+(\.[0-9]+)?)$"
                               title="Solo se permiten números" required>
                        <label for="gamePrice">Precio</label>
                    </div>
                    <div class="input-field">
                        <input name="discount" id="gameDisc" min="0" type="number" pattern="^[0-9]*$"
                               title="Solo se permiten números" required>
                        <label for="gameDisc">Descuento</label>
                    </div>

                    <div class="row">
                        <h6 class="center">Seleccione visibilidad en la tienda:</h6>
                        <div class="input-field col s6 push-s1">
                            <div class="col s12 m6 push-m5">
                                <p>
                                    <label>
                                        <input name="visible" type="radio" checked value="1"/>
                                        <span>Visible</span>
                                    </label>
                                </p>
                            </div>
                            <div class="col s12 m6 push-m4">
                                <p>
                                    <label>
                                        <input name="visible" type="radio" value="0"/>
                                        <span>Invisible</span>
                                    </label>
                                </p>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <button type="submit" class="modal-submit btn waves-effect right">Añadir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--Modal de modificar storepages-->
<div id="storePageModalU" class="modal">
    <div class="modal-content">
        <div class="modal-header row blue white-text">
            <div class="col m10 s9">
                <h3 class="">Modificar Storepage</h3>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m8 offset-m2">
                <form id="frmStrPgU">
                    <input type="hidden" name="id" id="pageId">
                    <div class="input-field">
                        <label for="gameDateU" class="active">Fecha de lanzamiento</label>
                        <input id="gameDateU" name="release_date" type="text" class="datepicker">
                    </div>
                    <div class="input-field">
                        <input name="price" id="gamePriceU" type="number" step="0.01" pattern="^([0-9]+(\.[0-9]+)?)$"
                               title="Solo se permiten números" required>
                        <label for="gamePriceU" class="active">Precio</label>
                    </div>
                    <div class="input-field">
                        <input name="discount" id="gameDiscU" min="0" type="number" pattern="^[0-9]*$"
                               title="Solo se permiten números" required>
                        <label for="gameDiscU" class="active">Descuento</label>
                    </div>

                    <div class="row">
                        <h6 class="center">Seleccione visibilidad en la tienda:</h6>
                        <div class="input-field col s6 push-s1">
                            <div class="col s12 m6 push-m5">
                                <p>
                                    <label>
                                        <input id="gameVis" name="visible" type="radio" checked value="1"/>
                                        <span>Visible</span>
                                    </label>
                                </p>
                            </div>
                            <div class="col s12 m6 push-m4">
                                <p>
                                    <label>
                                        <input id="gameInv" name="visible" type="radio" value="0"/>
                                        <span>Invisible</span>
                                    </label>
                                </p>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <button type="submit" class="modal-submit btn waves-effect right">Añadir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!--Modal de gestionar paginas en la tienda-->
<div id="storePageGestModal" class="modal">
    <div class="modal-content">
        <div class="modal-header row blue white-text">
            <div class="col m10 s9">
                <h3 class="">Gestionar Storepages</h3>
            </div>
        </div>
        <div class="row">
            <div class="divtab col s12 m10 offset-m1  black-text">
                <div class="tabla z-depth-3">
                    <div class="card white">
                        <div class="card-content">
                            <div class="row">
                                <div class="col s12">
                                    <div class="card-title-inline">
                                        <span class="card-title">Paginas en la tienda</span>
                                    </div>
                                </div>
                            </div>
                            <table class="bordered highlight responsive-table" id="storepages">
                                <thead>
                                <tr class="table-storepages">
                                    <th style="visibility: hidden; display:none;">ID</th>
                                    <th>Fecha de salida</th>
                                    <th>Precio</th>
                                    <th>Descuento</th>
                                    <th>Visible</th>
                                    <th>Editar</th>
                                    <th>Specs</th>
                                    <th>Reviews excluidas</th>

                                </tr>
                                </thead>
                                <tbody id="allStorePages">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--Modal de agregar storepagesSpec-->
<div id="storePageSpecAdd" class="modal">
    <div class="modal-content">
        <div class="modal-header row blue white-text">
            <div class="col m10 s9">
                <h3 class="">Agregar especificacion</h3>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m8 offset-m2">
                <form id="frmStorePageSpecAdd">
                        <div class="input-field">
                            <select id="spec" class="formSelect" name="spec" required>
                                <option value="" selected="true" disabled="disabled">Especificación</option>
                                <?php
                                $specs = new Control\SpecController();
                                foreach ($specs->getAllActiveSpecs() as $spec) {
                                    echo "<option value=".$spec->getId().">".$spec->getName()."</option>";
                                }
                                ?>
                            </select>
                        </div>
                    <div class="row">
                        <button type="submit" class="modal-submit btn waves-effect right">Añadir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="storePageSpecs" class="modal">
    <div class="modal-content">
        <div class="modal-header row blue white-text">
            <div class="col m10 s9">
                <h3 class="">Gestionar Especificacion</h3>
            </div>
        </div>
        <div class="row">
            <div class="divtab col s12 m10 offset-m1  black-text">
                <div class="tabla z-depth-3">
                    <div class="card white">
                        <div class="card-content">
                            <div class="row">
                                <div class="col s12">
                                    <div class="card-title-inline">
                                        <span class="card-title">Especificaciones de la pagina</span>
                                    </div>
                                </div>
                            </div>
                            <table class="bordered highlight responsive-table" id="storepages">
                                <thead>
                                <tr class="table-storepages">
                                    <th style="visibility: hidden; display:none;">ID</th>
                                    <th>Especificacion</th>
                                    <th>Eliminar</th>
                                </tr>
                                </thead>
                                <tbody id="allPageSpecs">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <button href="#storePageSpecAdd" type="submit" class="modal-trigger modal-submit btn waves-effect right">
                Añadir
            </button>
        </div>
    </div>
</div>

<script src="js/pageSpec.js"></script>
<script src="js/storepage.js"></script>
<script src="js/select.js"></script>
<script src="js/main.js"></script>
