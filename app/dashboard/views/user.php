<?php
//declarando namespace a utilizar
use Http\Controllers as Control;
use Http\Helpers as Helper;
?>

<link rel="stylesheet" href="css/user.css">

<!--vista de usuarios-->
<div class="wrapper">
    <div class="row search-box">
        <!--Añadir filtro para usuario-->
        <div class="col s12 m6 offset-m3">
            <div class="card-search-box hoverable white">
                <div class="input-field">
                    <input id="user-search" type="text" class="validate filtro" name="filtro" placeholder="Buscar usuario">
                </div>
            </div>
            <button class="btn light-blue darken-2" id="revert">Revertir</button>
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
                                        <th>Tipo</th>
                                        <th>Estado</th>
                                        <th>Editar</th>
                                        <th>Facturas</th>
                                    </tr>
                                </thead>

                                <tbody id="allUsers">
                                <!-- INICIO DEL PAGINATE -->
                                <?php
                                    //mostrando los datos solicitados en base al paginate
                                    $current_page = $page;
                                    $user = new Control\UserController();
                                    $paginate = new Helper\Paginate($user->getAllUsers(),$current_page);
                                    foreach ($paginate->getData() as $row){
                                        $checked = "";
                                        if($row->getState()==1){
                                            $checked = "checked";
                                        }
                                        echo "
                                                        <tr>
                                                            <td class='id' style=\"visibility: hidden; display:none;\">".$row->getId()."</td>
                                                            <td class='alias'>".$row->getAlias()."</td>
                                                            <td>".$row->getEmail()."</td>
                                                            <td>".$row->getUserType()->getName()."</td>
                                                            <td>
                                                                <label>
                                                                    <input type=\"checkbox\" disabled ".$checked.">
                                                                    <span></span>
                                                                </label>
                                                            </td>
                                                            <td>
                                                                <a  href='#actualizarUsuario' class=\"edit modal-trigger\">
                                                                     <i class=\"material-icons tooltipped editar\" data-position=\"left\" data-delay=\"50\">mode_edit</i>
                                                                 </a>
                                                             </td>
                                                            <td>
                                                                <a href='#facturasUsuario' class=\"edit modal-trigger modalBillsTrigger\">
                                                                     <i class=\"material-icons tooltipped editar\" data-position=\"left\" data-delay=\"50\">local_atm</i>
                                                                 </a>
                                                             </td>
                                                        </tr>
                                                    
                                                    ";
                                    }
                                ?>
                                <!--FIN DE PAGINATE-->
                                </tbody>
                            </table>
                            <br>
                            <div id="userLinks">
                                <!--INICIO DE ENLACES DE PAGINATE-->
                                <?php
                                //generando los links de paginacion
                                echo "<div class='row'>";
                                for($i=1;$i<=$paginate->linksNumber();$i++){
                                    echo"<a class='col s1 red-text' onclick=\"attach('user' ,$i)\">$i</a>";
                                }
                                echo "</div>"
                                ?>
                            </div>
                            <!--FIN DE ENLACES DE PAGINATE-->
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
            <div class="col s12 m8 offset-m2">
                <form id="frmUser">
                    <div class="input-field">
                        <input id="userAlias" name="alias" type="text" minlength="3" maxlength="50" pattern="^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\.]{1,50}$" title="Solo se permiten numeros y letras" required>
                        <label for="userAlias">Nombre de usuario</label>
                    </div>
                    <div class="input-field">
                        <input id="userEmail" name="email" type="email" required>
                        <label for="userEmail">Correo electronico</label>
                    </div>
                    <div class="input-field">
                        <input id="userPass" name="pass" type="password" min="6" max="50" required>
                        <label for="userPass">Contraseña</label>
                    </div>
                    <div class="input-field">
                        <input id="userPassConfirm" name="passConfirm" type="password" min="6" max="50" required>
                        <label for="userPassConfirm">Repetir contraseña</label>
                    </div>
                    <div class="input-field">
                        <select id="userType" class="formSelect" name="userType" required>
                            <option value="" selected="true" disabled="disabled">Tipo de usuario</option>
                            <?php
                            $typeSpecs = new Control\UserTypeController();
                            foreach ($typeSpecs->getAllActiveUserTypes() as $type) {
                                echo "<option value=".$type->getId().">".$type->getName()."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="row">
                        <h6 class="center">Seleccione el estado del usuario:</h6>
                        <div class="input-field col s6 push-s1">
                            <div class="col s12 m6 push-m5">
                                <p>
                                    <label>
                                <input name="state" type="radio" value="1" checked />
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
                        <button type="reset" class="btn waves-effect right modal-close">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!--Modal de actualización de usuarios-->
<div id="actualizarUsuario" class="modal">
    <div class="modal-content">
        <div class="modal-header row blue white-text">
            <div class="col m10 s9">
                <h3 class="">Actualizar usuario</h3>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m8 offset-m2">
                <form id="frmUserUpdate">
                    <input type="hidden" name="id" id="userId">
                    <div class="input-field">
                        <input id="userAliasU" name="alias" type="text" minlength="1" maxlength="50" pattern="^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\.]{1,50}$" title="Solo se permiten numeros y letras" required>
                        <label id="userAliasLabelU" for="userAliasU">Nombre de usuario</label>
                    </div>
                    <div class="input-field">
                        <input id="userEmailU" name="email" type="email" required>
                        <label id="userEmailLabelU" for="userEmailU">Correo electronico</label>
                    </div>
                    <div class="input-field">
                        <input id="userPassU" name="pass" min="6" max="50" type="password">
                        <label for="userPassU">Contraseña</label>
                    </div>
                    <div class="input-field">
                        <input id="userPassConfirmU" name="passConfirm" min="6" max="50" type="password">
                        <label for="userPassConfirmU">Repetir contraseña</label>
                    </div>
                    <div class="input-field">
                        <select id="userTypeU" class="formSelect" name="userType" required>
                            <option value="" selected="true" disabled="disabled">Tipo de usuario</option>
                            <?php
                            $typeSpecs = new Control\UserTypeController();
                            foreach ($typeSpecs->getAllActiveUserTypes() as $type) {
                                echo "<option value=".$type->getId().">".$type->getName()."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="row">
                        <h6 class="center">Seleccione el estado del usuario:</h6>
                        <div class="input-field col s6 push-s1">
                            <div class="col s12 m6 push-m5">
                                <p>
                                    <label>
                                        <input id="userStateA" name="state" type="radio" value="1" checked />
                                        <span>Activo</span>
                                    </label>
                                </p>
                            </div>
                            <div class="col s12 m6 push-m4">
                                <p>
                                    <label>
                                        <input id="userStateI" name="state" type="radio" value="0"/>
                                        <span>Inactivo</span>
                                    </label>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <button type="submit" class="modal-submit btn waves-effect right">Actualizar</button>
                        <button type="reset" class="btn waves-effect right modal-close">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!--Modal de facturas del usuario-->
<div id="facturasUsuario" class="modal modal-fixed-footer">
    <div class="modal-content">
        <div class="modal-header row blue white-text">
            <div class="col m10 s9">
                <h3 class="">Facturas de</h3>
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
        <div class="modal-header row blue white-text">
            <div class="col m10 s9">
                <h3 class=""></h3>
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

<script src="js/select.js"></script>
<script src="js/user.js"></script>