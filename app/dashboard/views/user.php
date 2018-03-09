<!--vista de usuarios-->
<div class="wrapper">
    <div class="row search-box">
        <!--Añadir filtro para usuario-->
        <div class="col s12 m6 offset-m3">
            <div class="card-search-box hoverable white">
                <form action="" method="GET" id="form-filtro">
                    <div class="input-field">
                        <input id="icon_prefix" type="text" class="validate filtro" name="filtro" placeholder="Buscar usuario">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--visualizar datos-->
    <div id="tabla-datos">
        <div class="row">
            <div class="divtab col s12 m10 offset-m1  black-text">
                <div class="tabla z-depth-3">
                    <div class="card white">
                        <div class="card-content">
                            <div class="row">
                                <div class="col s12">
                                    <div class="card-title-inline">
                                        <span class="card-title">Gestión de Usuarios</span>
                                    </div>
                                </div>
                            </div>
                            <table class="bordered highlight responsive-table" id="users">
                                <thead>
                                    <tr class="table-users">
                                        <th style="visibility: hidden; display:none;">ID</th>
                                        <th>Nombre de usuario</th>
                                        <th>Correo electronico</th>
                                        <th>Editar</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td style="visibility: hidden; display:none;">1</td>
                                        <td>oscarmendez</td>
                                        <td>someone@example.com</td>
                                        <td>
                                            <a href="#nuevoUsuario" onclick="" class="edit modal-trigger">
                                                <i class="material-icons tooltipped editar" data-position="left" data-delay="50">mode_edit</i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="visibility: hidden; display:none;">2</td>
                                        <td>kevinmoran</td>
                                        <td>someone@example.com</td>
                                        <td>
                                            <a href="#nuevoUsuario" onclick="" class="edit modal-trigger">
                                                <i class="material-icons tooltipped editar" data-position="left" data-delay="50">mode_edit</i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="visibility: hidden; display:none;">3</td>
                                        <td>raulalvarado</td>
                                        <td>someone@example.com</td>
                                        <td>
                                            <a href="#nuevoUsuario" onclick="" class="edit modal-trigger">
                                                <i class="material-icons tooltipped editar" data-position="left" data-delay="50">mode_edit</i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="fixed-action-btn horizontal click-to-toggle">
        <a href="#nuevoUsuario" class="btn-floating btn-large light-blue darken-2 waves-effect waves-light modal-trigger" data-position="left" data-delay="50" data-tooltip="Agregar usuario">
            <i class="material-icons">person_add</i>
        </a>
    </div>
</div>

<!--Modal de agregacion de usuarios-->
<div id="nuevoUsuario" class="modal">
    <div class="modal-content">
        <div class="modal-header row blue white-text">
            <div class="col m10 s9">
                <h3 class="">Nuevo usuario</h3>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m8 offset-m2 center-align">
                <form id="frmregUser">
                    <div class="input-field">
                        <input id="registerMail" type="text" required>
                        <label for="registerMail">Correo electronico</label>
                    </div>
                    <div class="input-field">
                        <input id="registerUser" type="text" required>
                        <label for="registerUser">Nombre de usuario</label>
                    </div>
                    <div class="input-field">
                        <input id="registerPass" type="password" required>
                        <label for="registerPass">Contraseña</label>
                    </div>
                    <div class="input-field">
                        <input id="registerPassRepeat" type="password" required>
                        <label for="registerPassRepeat">Repetir contraseña</label>
                    </div>
                    <div class="row">
                        <h6 class="center">Seleccione el estado del usuario:</h6>
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