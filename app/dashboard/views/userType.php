<?php
//declarando namespace a utilizar
use Http\Controllers as Control;
use Http\Helpers as Helper;

if(!isset($ajax)){
    header("Location:../index.php");
}
?>

<div class="wrapper">
    <div class="row search-box">
        <!--Añadir filtro para clasificaciones-->
        <div class="col s12 m6 offset-m3">
            <div class="card-search-box hoverable white">
                    <div class="input-field">
                        <input id="userType-search" type="text" class="validate filtro" name="filtro" placeholder="Buscar por nombre o estado">
                    </div>
            </div>
            <button class="btn light-blue darken-2" id="revert">Revertir</button>
        </div>
    </div>
    <!--tabla de visualizacion de datos-->
    <div id="tabla-datos">
        <div class="row">
            <div class="divtab col s12 m10 offset-m1  black-text">
                <div class="tabla z-depth-3">
                    <div class="card white">
                        <div class="card-content">
                            <div class="row">
                                <div class="col s12">
                                    <div class="card-title-inline">
                                        <span class="card-title">Gestión de tipos de usuarios:</span>
                                    </div>
                                </div>
                            </div>
                            <table class="bordered highlight responsive-table" id="users">
                                <thead>
                                    <tr class="table-users">
                                        <th style="visibility: hidden; display:none;">ID</th>
                                        <th>Nombre de tipo de usuario</th>
                                        <th>Estado</th>
                                        <th>Editar</th>
                                    </tr>
                                </thead>

                                <tbody id="allUserType">
                                <!-- INICIO DEL PAGINATE -->
                                <?php
                                //mostrando los datos solicitados en base al paginate
                                $current_page = $page;
                                $userType = new Control\userTypeController();
                                $paginate = new Helper\Paginate($userType->getAllUserTypes(),$current_page);

                                foreach ($paginate->getData() as $row){
                                    $checked = "";
                                    if($row->getState()==1){
                                        $checked = "checked";
                                    }
                                    echo "
                                                <tr>
                                                    <td class='id' style=\"visibility: hidden; display:none;\">".$row->getId()."</td>
                                                    <td>".$row->getName()."</td>
                                                    <td> 
                                                        <label>
                                                            <input type=\"checkbox\" disabled ".$checked." />
                                                            <span></span>
                                                         </label>
                                                    </td>
                                                    <td>
                                                        <a  href='#actualizarTipoUsuario' class=\"edit modal-trigger\">
                                                             <i class=\"material-icons tooltipped editar\" data-position=\"left\" data-delay=\"50\">mode_edit</i>
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
                            <div id="userTypeLinks">
                                <!--INICIO DE ENLACES DE PAGINATE-->
                                <?php
                                //generando los links de paginacion
                                echo "<div class='row'>";
                                for($i=1;$i<=$paginate->linksNumber();$i++){
                                    echo"<a class='col s1 red-text' onclick=\"attach('userType' ,$i)\">$i</a>";
                                }
                                echo "</div>"
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="fixed-action-btn horizontal click-to-toggle">
        <a href="#nuevoTipoUsuario" class="btn-floating btn-large light-blue darken-2 waves-effect waves-light modal-trigger" data-position="left" data-delay="50">
            <i class="material-icons">add</i>
        </a>
    </div>
</div>

<!--Modal de agregacion de clasificaciones-->
<div id="nuevoTipoUsuario" class="modal">
    <div class="modal-content">
        <div class="modal-header row blue white-text">
            <div class="col m10 s9">
                <h3 class="">Nuevo tipo de usuario</h3>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m8 offset-m2 center-align">
                <form id="frmRegTypeUse" autocomplete="off">
                    <div class="input-field">
                        <input id="nombreClasificacion" name="name" type="text" minlength="1" maxlength="50" pattern="^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\.]{1,50}$" title="Solo se permiten números y letras" required>
                        <label for="nombreClasificacion">Nombre de tipo de usuario</label>
                    </div>
                    <div class="row">
                    <div class="col s12 m6 l5 input-field">
                    <p>
                                    <label>
                                <input name="games" value="1" type="checkbox" />
                                <span>Juegos</span>
                            </label>
                                </p>
                                <p>
                                    <label>
                                <input name="users" value="1" type="checkbox"  />
                                <span>Usuarios</span>
                            </label>
                                </p>
                                <p>
                                    <label>
                                <input name="support" value="1" type="checkbox"  />
                                <span>Soporte</span>
                            </label>
                                </p>
                                <p>
                                    <label>
                                <input name="stadistics" value="1" type="checkbox"  />
                                <span>Estadisticas</span>
                            </label>
                                </p>
                                <p>
                                    <label>
                                <input name="reviews" value="1" type="checkbox"  />
                                <span>Review</span>
                            </label>
                                </p>

                    </div>
                    <div class="col s12 m6 l6 input-field">
                    <p>
                                    <label>
                                <input name="esrbs" value="1" type="checkbox" />
                                <span>Clasificaciones</span>
                            </label>
                                </p>
                                <p>
                                    <label>
                                <input name="publishers" value="1" type="checkbox"  />
                                <span>Publicadores</span>
                            </label>
                                </p>
                                <p>
                                    <label>
                                <input name="genres" value="1" type="checkbox"  />
                                <span>Generos</span>
                            </label>
                                </p>
                                <p>
                                    <label>
                                <input name="specs" value="1" type="checkbox"  />
                                <span>Especificaciones</span>
                            </label>
                                </p>
                                <p>
                                    <label>
                                <input name="typeSpecs" value="1" type="checkbox"  />
                                <span>Tipo especificaciones</span>
                            </label>
                                </p>
                                

                    </div>
                    <p>
                                    <label>
                                <input name="userTypes" value="1" type="checkbox"  />
                                <span>Tipo de usuarios</span>
                            </label>
                                </p>
                    </div>


                    <div class="row">
                        <h6 class="center">Seleccione el estado de tipo de usuario:</h6>
                        <div class="input-field col s6 push-s1">
                            <div class="col s12 m6 push-m5">
                                <p>
                                    <label>
                                <input name="state" value="1" type="radio" checked />
                                <span>Activo</span>
                            </label>
                                </p>
                            </div>
                            <div class="col s12 m6 push-m4">
                                <p>
                                    <label>
                                <input name="state" value="0" type="radio" />
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


<!--Actualizar Esrb-->
<div id="actualizarTipoUsuario" class="modal">
    <div class="modal-content">
        <div class="modal-header row blue white-text">
            <div class="col m10 s9">
                <h3 class="">Actualizar tipo de usuario</h3>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m8 offset-m2 center-align">
                <form id="frmUpdateRegTypeUse" autocomplete="off">
                <input type="hidden" name="id" id="userTypeId">
                    <div class="input-field">
                        <input id="userTypeUName" name="name" type="text" minlength="1" maxlength="50" pattern="^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\.]{1,50}$" title="Solo se permiten números y letras" required>
                        <label for="userTypeUName">Nombre de tipo de usuario</label>
                    </div>
                    <div class="row">
                    <div class="col s12 m6 l5 input-field">
                    <p>
                                    <label>
                                <input id="userTypeGames" name="games" value="1" type="checkbox" />
                                <span>Juegos</span>
                            </label>
                                </p>
                                <p>
                                    <label>
                                <input id="userTypeUsers" name="users" value="1" type="checkbox"  />
                                <span>Usuarios</span>
                            </label>
                                </p>
                                <p>
                                    <label>
                                <input id="userTypeSupp" name="support" value="1" type="checkbox"  />
                                <span>Soporte</span>
                            </label>
                                </p>
                                <p>
                                    <label>
                                <input id="userTypeStats" name="stadistics" value="1" type="checkbox"  />
                                <span>Estadisticas</span>
                            </label>
                                </p>
                                <p>
                                    <label>
                                <input id="userTypeReview" name="reviews" value="1" type="checkbox"  />
                                <span>Review</span>
                            </label>
                                </p>

                    </div>
                    <div class="col s12 m6 l6 input-field">
                    <p>
                                    <label>
                                <input id="userTypeEsrb" name="esrbs" value="1" type="checkbox" />
                                <span>Clasificaciones</span>
                            </label>
                                </p>
                                <p>
                                    <label>
                                <input id="userTypePublish" name="publishers" value="1" type="checkbox"  />
                                <span>Publicadores</span>
                            </label>
                                </p>
                                <p>
                                    <label>
                                <input id="userTypeGenre" name="genres" value="1" type="checkbox"  />
                                <span>Generos</span>
                            </label>
                                </p>
                                <p>
                                    <label>
                                <input id="userTypeSpecs" name="specs" value="1" type="checkbox"  />
                                <span>Especificaciones</span>
                            </label>
                                </p>
                                <p>
                                    <label>
                                <input id="userTypeTypeSpecs" name="typeSpecs" value="1" type="checkbox"  />
                                <span>Tipo especificaciones</span>
                            </label>
                                </p>
                                

                    </div>
                    <p>
                                    <label>
                                <input id="userTypeUserType" name="userTypes" value="1" type="checkbox"  />
                                <span>Tipo de usuarios</span>
                            </label>
                                </p>
                    </div>


                    <div class="row">
                        <h6 class="center">Seleccione el estado de tipo de usuario:</h6>
                        <div class="input-field col s6 push-s1">
                            <div class="col s12 m6 push-m5">
                                <p>
                                    <label>
                                <input name="state"  id="userTypeStateA" value="1" type="radio" checked />
                                <span>Activo</span>
                            </label>
                                </p>
                            </div>
                            <div class="col s12 m6 push-m4">
                                <p>
                                    <label>
                                <input name="state" id="userTypeStateI" value="0" type="radio" />
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

<script src="js/userType.js"></script>
