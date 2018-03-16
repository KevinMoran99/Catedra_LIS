<?php
//declarando namespace a utilizar
use Http\Controllers as Control;
use Http\Helpers as Helper;
?>
<!--vista principal-->

<!--navbar-->
<div class="navbar-fixed">
    <nav>
        <h5 id="nav-title">Todos los juegos:</h5>
        <div id="filter-container" class="input-field">
            <select id="filter" class="js-example-basic-single">
                <option value="" disabled selected>Todos</option>
                <option value="1">Option 1</option>
                <option value="2">Option 2</option>
                <option value="3">Option 3</option>
            </select>
        </div>
    </nav>
</div>

<div class="wrapper">

    <div class="row">
    <!--INICIO DEL PAGINATE -->
    <?php
    //mostrando los datos solicitados en base al paginate
    $current_page = $page;
    $games = new Control\GameController();
    $paginate = new Helper\Paginate($games->getAllGames(),$current_page);
    foreach ($paginate->getData() as $row){
        
        echo '<div class="col s6 m3 l3">
        <a class="modal-trigger" href="#actualizarJuego">
            <div class="card">
                <div class="card-image">
                    <img src="../web/img/example.png">
                    <span class="card-title">'.$row->getName().'</span>
                    <span class="id" style="visibility: hidden; display:none;">'.$row->getId().'</span>
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
        for($i=1;$i<=$paginate->linksNumber();$i++){
            echo"<a class='col s1 red-text' onclick=\"attach('main' ,$i)\">$i</a>";
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
            <div class="col s12 m8 offset-m2 center-align">
                <form id="frmRegJg" enctype="multipart/form-data">
                <input type="hidden" name="id" id="specId">
                    <div class="file-field input-field">
                        <div class="btn">
                            <span>Caratula</span>
                            <input name="cover" id="image"  type="file">
                        </div>
                        <div class="file-path-wrapper">
                            <input name="cover" class="file-path validate" type="text">
                        </div>
                    </div>
                    <div class="input-field">
                        <input name="name" id="gameName" type="text" required>
                        <label for="registerUser">Nombre de juego</label>
                    </div>
                    <div class="input-field">
                        <textarea name="description" class="materialize-textarea" id="registerUser" type="text" required></textarea>
                        <label for="registerUser">Descripcion</label>
                    </div>
                    <div class="input-field">
                        <select name="esrb" id="EsrbSelect" class="form-select" name="selectEsrb" required>
                        <option value="" disabled="disabled" selected="true">Clasificacion</option>
                        <?php
                                $esrbs = new Control\EsrbController();
                                foreach ($esrbs->getAllEsrb() as $esrb) {
                                    echo "<option value=".$esrb->getId().">".$esrb->getName()."</option>";
                                }
                                ?>
                        </select>
                    </div>
                    <div  class="input-field">
                        <select name="genre" id="genreSelect" class="form-select" name="selectGnr" required>
                        <option value="" disabled="disabled" selected="true">Genero</option>
                        <?php
                                $genres = new Control\GenreController();
                                foreach ($genres->getAllGenres() as $genre) {
                                    echo "<option value=".$genre->getId().">".$genre->getName()."</option>";
                                }
                                ?>
                        </select>
                    </div>
                    <div class="input-field">
                        <select name="platform" id="platformSelect" class="form-select" name="selectPltf" required>
                        <option value="" disabled="disabled" selected="true">Plataforma</option>
                        <?php
                                $platforms = new Control\PlatformController();
                                foreach ($platforms->getAllPlatforms() as $platform) {
                                    echo "<option value=".$platform->getId().">".$platform->getName()."</option>";
                                }
                                ?>
                        </select>
                    </div>
                    <div class="input-field">
                        <select name="publisher" id="publisherSelect" class="form-select" name="selectPbls" required>
                        <option value="" disabled="disabled" selected="true">Publicador</option>
                        <?php
                                $publishers = new Control\PublisherController();
                                foreach ($publishers->getAllPublishers() as $publisher) {
                                    echo "<option value=".$publisher->getId().">".$publisher->getName()."</option>";
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
                                <input name="state" type="radio" checked value="1" />
                                <span>Activo</span>
                            </label>
                                </p>
                            </div>
                            <div class="col s12 m6 push-m4">
                                <p>
                                    <label>
                                <input name="state" type="radio" checked values="0" />
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
            <div class="col s12 m8 offset-m2 center-align">
                <form id="frmActJg" enctype="multipart/form-data">
                    <div class="file-field input-field">
                        <div class="btn">
                            <span>Caratula</span>
                            <input type="file">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>
                    <div class="input-field">
                        <input id="gameName" type="text" required>
                        <label for="registerUser">Nombre de juego</label>
                    </div>
                    <div class="input-field">
                        <textarea class="materialize-textarea" id="registerUser" type="text" required></textarea>
                        <label for="registerUser">Descripcion</label>
                    </div>
                    <div class="input-field">
                        <select id="EsrbSelect" class="form-select" name="selectEsrb" required>
                        <option value="" disabled="disabled" selected="true">Clasificacion</option>
                        <?php
                                $esrbs = new Control\EsrbController();
                                foreach ($esrbs->getAllEsrb() as $esrb) {
                                    echo "<option value=".$esrb->getId().">".$esrb->getName()."</option>";
                                }
                                ?>
                        </select>
                    </div>
                    <div  class="input-field">
                        <select id="genreSelect" class="form-select" name="selectGnr" required>
                        <option value="" disabled="disabled" selected="true">Genero</option>
                        <?php
                                $genres = new Control\GenreController();
                                foreach ($genres->getAllGenres() as $genre) {
                                    echo "<option value=".$genre->getId().">".$genre->getName()."</option>";
                                }
                                ?>
                        </select>
                    </div>
                    <div class="input-field">
                        <select id="platformSelect" class="form-select" name="selectPltf" required>
                        <option value="" disabled="disabled" selected="true">Plataforma</option>
                        <?php
                                $platforms = new Control\PlatformController();
                                foreach ($platforms->getAllPlatforms() as $platform) {
                                    echo "<option value=".$platform->getId().">".$platform->getName()."</option>";
                                }
                                ?>
                        </select>
                    </div>
                    <div class="input-field">
                        <select id="publisherSelect" class="form-select" name="selectPbls" required>
                        <option value="" disabled="disabled" selected="true">Publicador</option>
                        <?php
                                $publishers = new Control\PublisherController();
                                foreach ($publishers->getAllPublishers() as $publisher) {
                                    echo "<option value=".$publisher->getId().">".$publisher->getName()."</option>";
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
                                <input name="state" type="radio" checked value="1" />
                                <span>Activo</span>
                            </label>
                                </p>
                            </div>
                            <div class="col s12 m6 push-m4">
                                <p>
                                    <label>
                                <input name="state" type="radio" checked values="0" />
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

<script src="js/select.js"></script>
<script src="js/main.js"></script>