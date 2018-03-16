<?php
//declarando namespace a utilizar
use Http\Controllers as Control;
use Http\Helpers as Helper;
?>
<!--vista de plataformas-->
<div class="wrapper">
    <div class="row search-box">
        <!--Añadir filtro para plataformas-->
        <div class="col s12 m6 offset-m3">
            <div class="card-search-box hoverable white">
                    <div class="input-field">
                        <input id="platform-search" type="text" class="validate filtro" name="filtro" placeholder="Buscar por nombre o estado">
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
                                        <span class="card-title">Gestión de Plataformas</span>
                                    </div>
                                </div>
                            </div>
                            <table class="bordered highlight responsive-table" id="users">
                                <thead>
                                    <tr class="table-users">
                                        <th style="visibility: hidden; display:none;">ID</th>
                                        <th>Nombre de plataforma</th>
                                        <th>Estado</th>
                                        <th>Editar</th>
                                    </tr>
                                </thead>

                                <tbody id="allPlatforms">
                                <!-- INICIO DEL PAGINATE -->
                                <?php
                                //mostrando los datos solicitados en base al paginate
                                $current_page = $page;
                                $platforms = new Control\PlatformController();
                                $paginate = new Helper\Paginate($platforms->getAllPlatforms(),$current_page);
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
                                                        <a  href='#actualizarPlataforma' class=\"edit modal-trigger\">
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
                            <div id="platformLinks">
                                <!--INICIO DE ENLACES DE PAGINATE-->
                                <?php
                                //generando los links de paginacion
                                echo "<div class='row'>";
                                for($i=1;$i<=$paginate->linksNumber();$i++){
                                    echo"<a class='col s1 red-text' onclick=\"attach('platform' ,$i)\">$i</a>";
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
        <a href="#nuevaPlataforma" class="btn-floating btn-large light-blue darken-2 waves-effect waves-light modal-trigger" data-position="left" data-delay="50">
            <i class="material-icons">add</i>
        </a>
    </div>
</div>

<!--Modal de agregacion de clasificaciones-->
<div id="nuevaPlataforma" class="modal">
    <div class="modal-content">
        <div class="modal-header row blue white-text">
            <div class="col m10 s9">
                <h3 class="">Nueva plataforma</h3>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m8 offset-m2 center-align">
                <form id="frmPlatform">
                    <div class="input-field">
                        <input id="platformName" name="name" type="text"  minlength="3" maxlength="50" pattern="^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\.]{3,50}$" title="Solo se permiten números y letras" required>
                        <label for="platformName">Nombre de plataforma</label>
                    </div>

                    <div class="row">
                        <h6 class="center">Seleccione el estado de la plataforma:</h6>
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



<!--ACTUALIZAR -->
<!--Modal de agregacion de clasificaciones-->
<div id="actualizarPlataforma" class="modal">
    <div class="modal-content">
        <div class="modal-header row blue white-text">
            <div class="col m10 s9">
                <h3 class="">Nueva plataforma</h3>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m8 offset-m2 center-align">
                <form id="frmUpdatePlatform">
                    <input type="hidden" name="id" id="platformId">
                    <div class="input-field">
                        <input id="platformUName" name="name" type="text"  minlength="3" maxlength="50" pattern="^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\.]{3,50}$" title="Solo se permiten números y letras" required>
                        <label for="platformUName" class="active">Nombre de plataforma</label>
                    </div>

                    <div class="row">
                        <h6 class="center">Seleccione el estado de la plataforma:</h6>
                        <div class="input-field col s6 push-s1">
                            <div class="col s12 m6 push-m5">
                                <p>
                                    <label>
                                        <input name="state" value="1" type="radio" id="platformStateA" checked />
                                        <span>Activo</span>
                                    </label>
                                </p>
                            </div>
                            <div class="col s12 m6 push-m4">
                                <p>
                                    <label>
                                        <input name="state" value="0" type="radio" id="platformStateI" />
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

<script src="js/platform.js"></script>