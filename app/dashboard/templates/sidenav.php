<!--vista del sidenav-->
<ul id="menu" class="sidenav sidenav-fixed back-img">
    <li>
        <div id="menu-logo" class="row">
            <div class="col s3"><img class="responsive-img" src="../web/img/logo.png"> </div>
            <div class="col s9">
                <h5 class="center-align">Sttom Admin Mode xd</h5>
            </div>
        </div>
    </li>
    <?php
        $user = $_SESSION['user'];
        $type = $user->getUserType();

        if($type->getGames()){
            echo '<li id="menu-games" class="menu-item selected-item"><a class="waves-effect" href="#!" onclick="attach(\'main\',1)"><i class="material-icons tooltipped" data-position="right" data-delay="50" data-tooltip="Juegos">games</i>Juegos</a></li>';
        }
        if($type->getUsers()){
            echo '<li class="menu-item"><a class="waves-effect" href="#!" onclick="attach(\'user\',1)"><i class="material-icons tooltipped" data-position="right" data-delay="50" data-tooltip="Usuarios">account_box</i>Usuarios</a></li>';
        }
        if($type->getSupport()){
            echo '<li class="menu-item"><a class="waves-effect" href="#!" onclick="attach(\'support\',1)"><i class="material-icons tooltipped" data-position="right" data-delay="50" data-tooltip="Soporte Técnico">build</i>Soporte Técnico</a></li>';
        }
        if($type->getStadistics()){
            echo '<li class="menu-item"><a class="waves-effect" href="#!" onclick="attach(\'stadistics\',1)"><i class="material-icons tooltipped" data-position="right" data-delay="50" data-tooltip="Estadísticas">call_made</i>Estadísticas</a></li>';
        }
        if($type->getReviews()){
            echo '<li class="menu-item"><a class="waves-effect" href="#!" onclick="attach(\'review\',1)"><i class="material-icons tooltipped" data-position="right" data-delay="50" data-tooltip="Moderar Reviews">rate_review</i>Moderar reviews</a></li>';
        }
        echo '<li>
                <div class="divider"></div>
              </li>';
        if($type->getEsrbs()){
            echo '<li class="menu-item"><a class="waves-effect" href="#!" onclick="attach(\'esrb\',1)"><i class="material-icons tooltipped" data-position="right" data-delay="50" data-tooltip="Clasificaciones ESRB">brightness_auto</i>Clasificaciones ESRB</a></li>';
        }
        if($type->getPublishers()){
            echo '<li class="menu-item"><a class="waves-effect" href="#!" onclick="attach(\'publisher\',1)"><i class="material-icons tooltipped" data-position="right" data-delay="50" data-tooltip="Publicadores">business_center</i>Publicadores</a></li>';
        }
        if($type->getGenres()){
            echo '<li class="menu-item"><a class="waves-effect" href="#!" onclick="attach(\'genre\',1)"><i class="material-icons tooltipped" data-position="right" data-delay="50" data-tooltip="Géneros">extension</i>Géneros</a></li>';
        }
        if($type->getSpecs()){
            echo '<li class="menu-item"><a class="waves-effect" href="#!" onclick="attach(\'spec\',1)"><i class="material-icons tooltipped" data-position="right" data-delay="50" data-tooltip="Géneros">settings</i>Especificaciones</a></li>';
        }
        if($type->getTypeSpecs()){
            echo '<li class="menu-item"><a class="waves-effect" href="#!" onclick="attach(\'typeSpec\',1)"><i class="material-icons tooltipped" data-position="right" data-delay="50" data-tooltip="Plataformas">settings_applications</i>Tipos de especificaciones</a></li>';
        }
    ?>

    <!--<li id="menu-games" class="menu-item menu-trigger selected-item"><a class="waves-effect dropdown-trigger" href="#!" data-target="drpGames1"><i class="material-icons tooltipped" data-position="right" data-delay="50" data-tooltip="Juegos">games</i>Juegos<i class="material-icons right">keyboard_arrow_right</i></a></li>-->


    <!--<li class="menu-item"><a class="waves-effect" href="#!" onclick="attach('platform',1)"><i class="material-icons tooltipped" data-position="right" data-delay="50" data-tooltip="Plataformas">desktop_windows</i>Plataformas</a></li>-->
    <li>
        <div class="divider"></div>
    </li>
    <li><a id="logout" class="waves-effect" href="#"><i class="material-icons tooltipped" data-position="right" data-delay="50" data-tooltip="Cerrar sesión">cancel</i>Cerrar sesión</a></li>
</ul>

<!--Dropdowns-->
<!--Juegos  -->
<ul id="drpGames1" class="dropdown-content">
    <li id="game-all" class="item-game"><a href="#!" onclick="attach('main',1)">Todos</a></li>
    <li id="game-offer" class="item-game hide"><a href="#!" onclick="attach('main',1)">Ofertas</a></li>
    <li id="game-platform" class="item-game"><a href="#!" onclick="attach('main',1)">Por plataforma</a></li>
    <li id="game-publisher" class="item-game"><a href="#!" onclick="attach('main',1)">Por publicador</a></li>
    <li id="game-genre" class="item-game"><a href="#!" onclick="attach('main',1)">Por género</a></li>
    <li id="game-rating" class="item-game hide"><a href="#!" onclick="attach('main',1)">Por rating</a></li>
    <li id="game-esrb" class="item-game"><a href="#!" onclick="attach('main',1)">Por clasificación</a></li>
    <li id="game-date" class="item-game hide"><a href="#!" onclick="attach('main',1)">Por lanzamiento</a>
        <!--<li class="item-game"><a href="#!" onclick="attach('games')">Ofertas</a></li>
    <li class="menu-trigger"><a class="dropdown-trigger" href="#!" data-target="drpGames2">Buscar por<i class="material-icons right">keyboard_arrow_right</i></a></li>-->
</ul>



<!--Modal de actualización de contraseña expirada-->
<div id="modalPassExpired" class="modal">
    <div class="modal-content">
        <div class="modal-header row blue white-text center-align">
            <div class="col m10 s9">
                <h5 class="">Hace 3 meses que no cambias tu contraseña. Por favor, crea una nueva para continuar:</h5>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m8 offset-m2 center-align">
                <form id="frmExpired" autocomplete="off">
                    <div class="input-field">
                        <input id="expiredPass" name="pass" type="password" required />
                        <label for="expiredPass">Contraseña</label>
                    </div>
                    <div class="input-field">
                        <input id="expiredConfirm" name="passConfirm" type="password" required />
                        <label for="expiredConfirm">Repetir contraseña</label>
                    </div>
                    <div class="row">
                        <button type="submit" class="modal-submit btn waves-effect right">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>