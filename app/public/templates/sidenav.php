<!--menu en desktop-->
<!--<div class="navbar-fixed">
    <nav>
        <div class="nav-wrapper">
            <a href="index.php" class="brand-logo">Sttom xD</a>
            <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a class="dropdown-trigger" href="#!" data-target="drpGames1">Juegos<i class="material-icons left">keyboard_arrow_down</i></a></li>
                <li><a href="support.php">Soporte Técnico</a></li>
                <li><a href="about.php">Quiénes somos</a></li>
                <li class="noLogin"><a class="modal-trigger" href="#modalSignIn">Iniciar sesión</a></li>
                <li class="userLogged"><a class="dropdown-trigger" href="#!" data-target="drpAccount1">Cuenta<i class="material-icons left">keyboard_arrow_down</i></a></li>
                <li class="userLogged"><a class="modal-trigger" href="#modalCart"><i class="material-icons">shopping_cart</i></a></li>
            </ul>
        </div>
    </nav>
</div>-->
<div id="menu-button" class="fixed-action-btn">
    <a href="#" data-target="menu" class="sidenav-trigger"><i class="material-icons">menu</i></a>
</div>

<div class="navbar-fixed">
    <nav class="center-align">
        <h5 id="nav-title">Sttom xD</h5>
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




<!-- menu -->
<ul id="menu" class="sidenav">
    <li>
        <div id="menu-logo" class="row">
            <div class="col s6 offset-s3"><img class="responsive-img" src="../web/img/logo.png"> </div>
            <div class="col s12"><h4 class="center-align">Sttom xD</h4></div>
        </div>
    </li>
    <div id="menu-items">
    <li class="menu-item center-align selected-item"><a href="#" onclick="location.reload();">Tienda</a></li>
    <li id="menu-games" class="menu-item center-align menu-trigger"><a class="dropdown-trigger" href="#!" data-target="drpGames1">Juegos<i class="material-icons right">keyboard_arrow_right</i></a></li>
    <li id="menu-support" class="menu-item center-align"><a href="#!" onclick="attach('support',1)">Soporte Técnico</a></li>
    <li id="menu-about" class="menu-item center-align"><a href="#!" onclick="attach('about',1)">Quiénes somos</a></li>
    <li id="menu-cart" class="menu-item center-align"><!--<a class="modal-trigger" href="#modalCart">--><a href="#!" onclick="attach('cart',1)">
        <div class="row">
            <div class="col s3"><i class="material-icons">shopping_cart</i></div><div class="col s6">Carrito</div>
        </div>
    </a></li>
    </div>
    <footer class="page-footer white">
        <?php
            //Autenticacion
            include_once ("../../vendor/autoload.php");
            if (!session_id()) session_start();
            if (!isset($_SESSION['user'])) {
                ?>
                <div id="menu-login" class="container">
                    <div class="center-align row">
                        <div id="login-collection" class="collection col s10 offset-s1">
                            <a href="#modalSignIn" class="collection-item active modal-trigger indigo lighten-2">Iniciar
                                sesión</a>
                            <a href="#modalSignUp" class="collection-item modal-trigger indigo-text lighten-2">Registrarse</a>
                        </div>
                    </div>
                </div>
                <?php
            }
            else {
                ?>
                <li id="menu-user" class="center-align"><a class="dropdown-trigger" href="#!"
                                                           data-target="drpAccount"><i class="material-icons left">account_circle</i>Mi
                        perfil<i class="material-icons right">keyboard_arrow_right</i></a></li>
                <?php

                //Si es un admin, se redirige a dashboard
                if ($_SESSION['user']->getUserType()->getId() == 1) {
                    header("Location:../dashboard/index.php");
                    die();
                }
            }

            //Variable del carrito
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
        ?>
        <div class="footer-copyright">
            <div class="container center-align  black-text">
                © 2018 Copyright
            </div>
        </div>
    </footer>
</ul>

<!--Dropdowns-->
<!--Juegos  -->
<ul id="drpGames1" class="dropdown-content">
    <li id="game-all" class="item-game"><a href="#!" onclick="attach('games',1)">Todos</a></li>
    <li id="game-offer" class="item-game"><a href="#!" onclick="attach('games',1)">Ofertas</a></li>
    <!--<li id="game-platform" class="item-game"><a href="#!" onclick="attach('games',1)">Por plataforma</a></li>-->
    <li id="game-publisher" class="item-game"><a href="#!" onclick="attach('games',1)">Por publicador</a></li>
    <li id="game-genre" class="item-game"><a href="#!" onclick="attach('games',1)">Por género</a></li>
    <li id="game-rating" class="item-game"><a href="#!" onclick="attach('games',1)">Por rating</a></li>
    <li id="game-esrb" class="item-game"><a href="#!" onclick="attach('games',1)">Por clasificación</a></li>
    <li id="game-date" class="item-game"><a href="#!" onclick="attach('games',1)">Por lanzamiento</a>
    <!--<li class="item-game"><a href="#!" onclick="attach('games')">Ofertas</a></li>
    <li class="menu-trigger"><a class="dropdown-trigger" href="#!" data-target="drpGames2">Buscar por<i class="material-icons right">keyboard_arrow_right</i></a></li>-->
</ul>
<!--<ul id="drpGames2" class="dropdown-content">
    <li class="item-game"><a href="#!" onclick="attach('games')">Todos</a></li>
    <li class="item-game"><a href="#!" onclick="attach('games')">Plataforma</a></li>
    <li class="item-game"><a href="#!" onclick="attach('games')">Desarrollador</a></li>
    <li class="item-game"><a href="#!" onclick="attach('games')">Género</a></li>
    <li class="item-game"><a href="#!" onclick="attach('games')">Rating</a></li>
    <li class="item-game"><a href="#!" onclick="attach('games')">Clasificación</a></li>
    <li class="item-game"><a href="#!" onclick="attach('games')">Fecha de lanzamiento</a></li>
</ul>-->
<ul id="drpAccount" class="dropdown-content">
    <li><a id="modalUserTrigger" class="modal-trigger" href="#modalUser">Editar información</a></li>
    <li><a id="modalBillsTrigger" class="modal-trigger" href="#modalBills">Ver mis facturas</a></li>
    <li><a id="logout" href="#">Cerrar sesión</a></li>
</ul>



<!--Modal de inicio de sesión-->
<div id="modalSignIn" class="modal">
    <div class="modal-content">
        <div class="modal-header row white-text valign-wrapper">
            <div class="col m2 s3">
                <img class="responsive-img" src="../web/img/logo.png"> 
            </div>
            <div class="col m10 s9">
                <h3 class="">Inicio de sesión</h3>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m8 offset-m2 center-align">
                <form id="frmSignIn">
                    <div class="input-field">
                        <input id="signInUser" name="alias" type="text" required>
                        <label for="signInUser">Nombre de usuario</label>
                    </div>
                    <div class="input-field">
                        <input id="signInPass" name="pass" type="password" required>
                        <label for="signInPass">Contraseña</label>
                    </div>
                    <div class="row">
                        <button type="submit" class="modal-submit btn waves-effect right">Ingresar</button>
                        <button class="btn waves-effect right modal-close">Cancelar</button>
                    </div>
                </form>
                <a href="#modalSignUp" class="modal-close modal-trigger">¿No tienes una cuenta?</a>
            </div>
        </div>
    </div>
</div>

<!--Modal de registro-->
<div id="modalSignUp" class="modal">
    <div class="modal-content">
        <div class="modal-header row white-text valign-wrapper">
            <div class="col m2 s3">
                <img class="responsive-img" src="../web/img/logo.png"> 
            </div>
            <div class="col m10 s9">
                <h3 class="">Regístrate</h3>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m8 offset-m2 center-align">
                <form id="frmSignUp">
                    <div class="input-field">
                        <input id="signUpEmail" name="email" type="email" required>
                        <label for="signUpEmail">Correo electrónico</label>
                    </div>
                    <div class="input-field">
                        <input id="signUpUser" name="alias" type="text" required>
                        <label for="signUpUser">Nombre de usuario</label>
                    </div>
                    <div class="input-field">
                        <input id="signUpPass" name="pass" type="password" required>
                        <label for="signUpPass">Contraseña</label>
                    </div>
                    <div class="input-field">
                        <input id="signUpConfirm" name="passConfirm" type="password" required>
                        <label for="signUpConfirm">Repetir contraseña</label>
                    </div>
                    <label>
                        <input type="checkbox" id="signUpTerms" name="terms" required/>
                        <span>Acepto los términos y condiciones</span>
                    </label>
                    <div class="input-field">
                        <a href="#modalTerms" class="modal-trigger">Ver términos y condiciones</a>
                    </div>
                    <div class="row">
                        <button type="submit" class="modal-submit btn waves-effect right">Registrar</button>
                        <button class="btn waves-effect right modal-close">Cancelar</button>
                    </div>
                </form>
                <a href="#modalSignIn" class="modal-close modal-trigger">¿Ya tienes una cuenta?</a>
            </div>
        </div>
    </div>
</div>

<!--Modal de registro-->
<div id="modalTerms" class="modal">
    <div class="modal-content">
        <div class="modal-header row white-text valign-wrapper">
            <div class="col m2 s3">
                <img class="responsive-img" src="../web/img/logo.png"> 
            </div>
            <div class="col m10 s9">
                <h3 class="">Términos y condiciones</h3>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m8 offset-m2 justify-align">
                <ol id="terms"> 
                    <li>El presente Aviso Legal (en adelante, el "Aviso Legal") establece los Términos y Condiciones 
                        respecto al uso de las páginas de Internet, (las "Páginas") que STTOM pone a disposición de 
                        usted.
                    </li> 
                    <li>
                        Las publicaciones digitales de STTOM tienen por objeto facilitar a sus Clientes y al público en 
                        general, el acceso a los servicios y productos STTOM, así como a la información relativa a 
                        dichos servicios, productos, equipos, tarifas, promociones, y cualquier otra información 
                        relacionada (En adelante los "Servicios y Productos").
                    </li> 
                    <li>La utilización de las páginas le atribuye a Ud. la condición de usuario de las Páginas (en 
                        adelante, el "Usuario") e implica la aceptación plena y sin reservas de todas y cada una de las 
                        disposiciones incluidas en este Aviso Legal en la versión publicada por STTOM en el momento 
                        mismo en que el usuario acceda a las páginas. En consecuencia, el usuario debe leer el presente 
                        Aviso Legal en cada una de las ocasiones en que utilice las páginas, ya que puede sufrir 
                        modificaciones.
                    </li> 
                    <li>La utilización de las páginas se encuentra sometida, además de este Aviso Legal, a todos los 
                        avisos, reglamentos de uso e instrucciones, que sean puestos en conocimiento del Usuario por 
                        STTOM a través de las páginas. 
                    </li> 
                    <li>
                        STTOM se reserva el derecho a modificar el Aviso Legal en cualquier tiempo y sin previa 
                        notificación. Dichas modificaciones serán efectivas a partir del momento en que queden disponibles 
                        al público en las páginas. El usuario se considera enterado y obligado por los cambios al Aviso Legal
                        desde el momento en que ingrese a las páginas. El uso o acceso a las páginas por parte del usuario 
                        constituirá la aceptación y acuerdo a los cambios del Aviso Legal.
                    </li> 
                    <li>STTOM procurará que la información contenida en sus páginas sea correcta y esté actualizada al 
                        momento de ser incluida en las mismas. Sin embargo, es posible que existan errores o imprecisiones 
                        involuntarias. 
                    </li> 
                    <li>
                        STTOM podrá en cualquier momento negar, suspender o dar por terminado el acceso o el uso del 
                        usuario a las páginas, a cualquier Servicio y Producto, o cualquier parte de los mismos, a sola 
                        discreción de STTOM, sin necesidad de previo aviso, sin limitación alguna, y por cualquier razón. 
                    </li> 
                    <li>
                        Para conveniencia del Usuario, las páginas pueden proporcionar enlaces ("Links") a otros sitios o 
                        páginas de Internet de terceros, cuyo contenido o información no es revisado por STTOM. Salvo 
                        cuando se establezca expresamente lo contrario, cualquier página o sitio enlazado con nuestras 
                        páginas es independiente de STTOM, por lo que STTOM no tiene control sobre tales productos, 
                        servicios, materiales o cualquier otra información contenida en o disponible a través de las Páginas 
                        o sitios de dichos terceros, ni se entenderá que STTOM recomienda dichos productos o servicios de 
                        terceros que tengan un Link a nuestras Páginas. El acceso a cualquier página o sitio enlazado a 
                        nuestras páginas es bajo riesgo del usuario.
                    </li> 
                    <li>
                        Algunos Servicios y Productos puestos a disposición del Usuario a través de las páginas podrán requerir
                        de claves o contraseñas ("Passwords"), a fin de verificar la identidad del usuario. El usuario está de 
                        acuerdo en que cualquier operación correctamente identificada con dichos Passwords será consideradas 
                        como válidamente realizadas por el usuario. Por lo anterior, el usuario será el único responsable de 
                        mantener la confidencialidad de dichos Passwords, sin importar si éstos fueron proporcionados por 
                        STTOM o seleccionados por el usuario directamente.
                    </li> 
                    <li>
                        STTOM es titular de todos los derechos sobre el software de las publicaciones digitales, así como de 
                        los derechos de propiedad industrial e intelectual referidos a los contenidos que en ellas se incluyan, 
                        a excepción de los derechos sobre productos y servicios que no son propiedad de STTOM, cuyas marcas 
                        están registradas a favor de sus respectivos titulares, y como tal son reconocidas por STTOM. Ningún 
                        material de las publicaciones digitales podrá ser reproducido, copiado modificado, distribuido, 
                        transmitido, vendido, utilizado o publicado por el usuario sin el previo consentimiento por escrito de 
                        STTOM. 
                    </li> 
                    <li>
                        STTOM respetará escrupulosamente la confidencialidad de los datos de carácter personal aportados por 
                        los visitantes a las publicaciones digitales, mediante la observancia de su Aviso de Privacidad y de la 
                        normatividad aplicable vigente, de tal manera que STTOM no entregará información personal del usuario 
                        a terceros, a menos que sea requerido para entregar un producto o prestar un servicio solicitado por el 
                        usuario. Ver Aviso de Privacidad.
                    </li> 
                    <li>
                        Cualquier información enviada por los usuarios y que sea recibida en las páginas, tal como comentarios, 
                        sugerencias o ideas, se considerará cedida a STTOM a título gratuito, y el usuario que la envíe acepta 
                        implícitamente que no tiene carácter de confidencial. Le sugerimos que NO ENVÍE información que no pueda 
                        ser tratada de esta forma. STTOM tendrá el derecho de utilizar cualquier información enviada para los 
                        fines que juzgue convenientes.
                    </li> 
                    <li>
                        Queda terminantemente prohibido el mal uso y el uso no autorizado de las páginas, incluyendo sin limitar, 
                        el acceso no autorizado a los sistemas de STTOM, el mal uso de claves o contraseñas ("Passwords"), o de 
                        cualquier información contenida en las Páginas. STTOM se reserva el derecho de suspender o negar el 
                        acceso a sus páginas a las personas que hagan un mal uso de la información o de los Servicios y Productos 
                        contenidos en las mismas; sin perjuicio del derecho de STTOM del ejercicio de las acciones civiles, 
                        administrativas o penales a que hubiere lugar, de conformidad con las leyes de la materia. 
                    </li> 
                </ol>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
        <a id="termsAgree" href="#!" class="modal-close waves-effect waves-green btn-flat">Aceptar términos y condiciones</a>
    </div>
</div>

<!--Modal de edición de información de usuario-->
<div id="modalUser" class="modal">
    <div class="modal-content">
        <div class="modal-header row white-text valign-wrapper">
            <div class="col m2 s3">
                <img class="responsive-img" src="../web/img/logo.png"> 
            </div>
            <div class="col m10 s9">
                <h3 class="">Editar información</h3>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m8 offset-m2 center-align">
                <form id="frmUser">
                    <div class="input-field">
                        <input id="userName" name="alias" type="text"  minlength="1" maxlength="50" pattern="^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\.]{1,50}$" title="Solo se permiten numeros y letras" required>
                        <label id="userNameLabel" for="userName">Nombre de usuario</label>
                    </div>
                    <div class="input-field">
                        <input id="userPass" name="pass" min="6" max="50" type="password">
                        <label for="userPass">Contraseña</label>
                    </div>
                    <div class="input-field">
                        <input id="userConfirm" name="passConfirm" min="6" max="50" type="password">
                        <label for="userConfirm">Repetir contraseña</label>
                    </div>
                    <div class="row">
                        <button type="submit" class="modal-submit btn waves-effect right">Guardar cambios</button>
                        <button type="reset" class="btn waves-effect right modal-close">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!--Modal de facturas del usuario-->
<div id="modalBills" class="modal modal-fixed-footer">
    <div class="modal-content">
        <div class="modal-header row white-text valign-wrapper">
            <div class="col m2 s3">
                <img class="responsive-img" src="../web/img/logo.png">
            </div>
            <div class="col m10 s9">
                <h3 class="">Mis facturas</h3>
            </div>
        </div>
        <div class="row">
            <div id="billList" class="collection col s12">

            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Cerrar</a>
    </div>
</div>


<!--Modal de items de facturas del usuario-->
<div id="modalBillItems" class="modal modal-fixed-footer">
    <div class="modal-content">
        <div class="modal-header row white-text valign-wrapper">
            <div class="col m2 s3">
                <img class="responsive-img" src="../web/img/logo.png">
            </div>
            <div class="col m10 s9">
                <h3 id="billItemHeader"></h3>
            </div>
        </div>
        <div class="row">
            <div id="billItemList" class="collection col s12">

            </div>
            <div class="col s12 right-align">
                <h4>Total: $0.00</h4>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Cerrar</a>
    </div>
</div>

<script>
    //Guardando alias de usuario en variable js
    var alias = "<?php
        if (isset($_SESSION['user'])) {
            echo $_SESSION['user']->getAlias();
        }
        else {
            echo '';
        }
        ?>";
</script>


<!--Modal de carrito-->
<!--<div id="modalCart" class="modal">
    <div class="modal-content">
        <div class="row">
            <div class="col s12 m10 offset-m1 center-align">
                <i class="material-icons large">shopping_cart</i>
                <h3>Carrito</h3>
                <div>
                    <div class="chip large-chip valign-wrapper">
                        <img class="responsive-img" src="https://picsum.photos/320/240">
                        <i class="close material-icons">close</i><br>
                        <div>The Legend of Zelda: PC Edition</div>
                        <div class="chip green white-text right">$19.99</div>
                    </div>
                    <div class="chip large-chip valign-wrapper">
                        <img class="responsive-img" src="https://picsum.photos/320/240">
                        <i class="close material-icons">close</i><br>
                        <div>Super Mario Bros for PC</div>
                        <div class="chip green white-text right">$9.99</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 right"><h4 class="right">Total: $100.00</h4></div>
                    <div class="col s12 center"><a class="waves-effect waves-light btn">Realizar transacción</a></div>
                </div>
            </div>
        </div>
    </div>
</div>-->

