
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
        <?php
            $url = "attach('gameDetail');";
            for($i = 0; $i<=10; $i++){
                echo '<div class="col s6 m3 l3">
                        <a class="modal-trigger" href="#nuevoJuego">
                            <div class="card">
                                <div class="card-image">
                                    <img src="../web/img/example.png">
                                    <span class="card-title">Nombre Juego</span>
                                </div>
                            </div>
                        </a>
                    </div>';
            } ?>
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
                <form id="frmRegJg">
                    <div class="file-field input-field">
                        <div class="btn">
                            <span>Imagen</span>
                            <input type="file">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>
                    <div class="input-field">
                        <input id="registerUser" type="text" required>
                        <label for="registerUser">Nombre de juego</label>
                    </div>
                    <div class="input-field">
                        <textarea class="materialize-textarea" id="registerUser" type="text" required></textarea>
                        <label for="registerUser">Descripcion</label>
                    </div>
                    <div class="input-field">
                        <select class="form-select">
                        <option value="" disabled selected>Clasificacion</option>
                        </select>
                    </div>
                    <div class="input-field">
                        <select class="form-select">
                        <option value="" disabled selected>Genero</option>
                        </select>
                    </div>
                    <div class="input-field">
                        <select class="form-select">
                        <option value="" disabled selected>Plataforma</option>
                        </select>
                    </div>
                    <div class="input-field">
                        <select class="form-select">
                        <option value="" disabled selected>Publicador</option>
                        </select>
                    </div>
                    <div class="input-field">
                        <input id="registerUser" type="text" required>
                        <label for="registerUser">Precio</label>
                    </div>
                    <div class="input-field">
                        <input id="registerUser" type="text" required>
                        <label for="registerUser">Descuento</label>
                    </div>

                    <div class="row">
                        <h6 class="center">Seleccione el estado del juego:</h6>
                        <div class="input-field col s6 push-s1">
                            <div class="col s12 m6 push-m5">
                                <p>
                                    <label>
                                <input name="state" type="radio" checked />
                                <span>Activo</span>
                            </label>
                                </p>
                            </div>
                            <div class="col s12 m6 push-m4">
                                <p>
                                    <label>
                                <input name="state" type="radio" checked />
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

<script src="js/user.js"></script>
<script src="js/select.js"></script>
<script src="js/main.js"></script>