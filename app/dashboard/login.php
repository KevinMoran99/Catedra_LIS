<!DOCTYPE html>
<html>
    <head>
        <title>Listado de juegos</title>

        <?php include 'templates/styles.html';?>
        <link rel="stylesheet" href="css/login.css">
    </head>
    <body>
        
    <div class="row valign-wrapper">
        <div class="col s12 m4 offset-m4 center-align">
            <div class="card">
                <div class="card-content">
                    <form id="frmSignIn" autocomplete="off">
                        <h3>Iniciar sesión</h3>
                        <div class="input-field">
                            <input id="signInUser" name="alias" type="text" required>
                            <label for="signInUser">Nombre de usuario</label>
                        </div>
                        <div class="input-field">
                            <input id="signInPass" name="pass" type="password" required>
                            <label for="signInPass">Contraseña</label>
                        </div>
                        <div class="g-recaptcha" data-sitekey="6Lf2ClUUAAAAAA3EZ2c9eC9U_1PwaPkbC4LDWt9T"></div>
                        <div class="row">
                            <button class="btn-flat waves-effect waves-green">Iniciar sesión</button>
                        </div>
                        <div class="row">
                            <a href="#modalPassLost" class="modal-close modal-trigger">Perdí mi contraseña</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--Modal de confirmación de cuenta-->
    <div id="modalConfirmLogin" class="modal">
        <div class="modal-content">
            <div class="modal-header row white-text valign-wrapper">
                <div class="col m2 s3">
                    <img class="responsive-img" src="../web/img/logo.png"> 
                </div>
                <div class="col m10 s9">
                <h3 class="">Confirmación de cuenta</h3>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m8 offset-m2 center-align">
                    <form id="frmConfirmLogin" autocomplete="off">
                        <p>Hemos enviado un código de verificación a su cuenta de correo electrónico. Por favor, copie este mensaje aquí para continuar:</p>
                        <div class="input-field">
                            <input id="confirmHash" name="confirmHash" type="text" required>
                            <label for="confirmHash">Código</label>
                        </div>
                        <div class="row">
                            <button type="submit" class="modal-submit btn waves-effect right">Continuar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--Modal de recuperación de contraseña-->
    <div id="modalPassLost" class="modal">
        <div class="modal-content">
            <div class="modal-header row white-text valign-wrapper">
                <div class="col m2 s3">
                    <img class="responsive-img" src="../web/img/logo.png"> 
                </div>
                <div class="col m10 s9">
                <h3 class="">Recuperación de contraseña</h3>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m8 offset-m2 center-align">
                    <form id="frmPassLost" autocomplete="off">
                        <div class="input-field">
                            <input id="passLostEmail" name="email" type="email" required>
                            <label for="passLostEmail">Correo electrónico</label>
                        </div>
                        <div class="row">
                            <button type="submit" class="modal-submit btn waves-effect right">Enviar mensaje de recuperación</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
        
    </body>
    <?php include 'templates/scripts.html';?>

    <script src="js/login.js"></script>
</html>