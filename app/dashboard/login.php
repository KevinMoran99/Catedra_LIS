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
                    <form id="frmSignIn">
                        <h3>Iniciar sesión</h3>
                        <div class="input-field">
                            <input id="signInUser" name="name" type="text" required>
                            <label for="signInUser">Nombre de usuario</label>
                        </div>
                        <div class="input-field">
                            <input id="signInPass" name="pass" type="password" required>
                            <label for="signInPass">Contraseña</label>
                        </div>
                        <button class="btn-flat waves-effect waves-green">Iniciar sesión</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
        
    </body>
    <?php include 'templates/scripts.html';?>

    <script src="js/login.js"></script>
</html>