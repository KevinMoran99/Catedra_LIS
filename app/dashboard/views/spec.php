<?php
//declarando namespace a utilizar
use Http\Controllers as Control;
use Http\Helpers as Helper;
?>

<!--vista de especificaciones-->
<div class="wrapper">
    <div class="row search-box">
        <!--Añadir filtro para especificaciones-->
        <div class="col s12 m6 offset-m3">
            <div class="card-search-box hoverable white">
                <div class="input-field">
                    <input id="spec-search" type="text" class="validate filtro" name="filtro" placeholder="Buscar publicador">
                </div>
            </div>
            <button class="btn light-blue darken-2" id="revert">Revertir</button>
        </div>
    </div>

    <!--visualizacion de datos-->
    <div id="tabla-datos">
        <div class="row">
            <div class="divtab col s12 m10 offset-m1  black-text">
                <div class="tabla z-depth-3">
                    <div class="card white">
                        <div class="card-content">
                            <div class="row">
                                <div class="col s12">
                                    <div class="card-title-inline">
                                        <span class="card-title">Gestión de especificaciones</span>
                                    </div>
                                </div>
                            </div>
                            <table class="bordered highlight responsive-table" id="users">
                                <thead>
                                    <tr class="table-users">
                                        <th style="visibility: hidden; display:none;">ID</th>
                                        <th>Nombre de especificacion</th>
                                        <th>Tipo de especificacion</th>
                                        <th>Estado</th>
                                        <th>Editar</th>
                                    </tr>
                                </thead>

                                <tbody id="allSpecs">
                                <!-- INICIO DEL PAGINATE -->
                                <?php
                                    //mostrando los datos solicitados en base al paginate
                                    $current_page = $page;
                                    $specs = new Control\SpecController();
                                    $paginate = new Helper\Paginate($specs->getAllSpecs(),$current_page);
                                    foreach ($paginate->getData() as $row){
                                        $checked = "";
                                        if($row->getState()==1){
                                            $checked = "checked";
                                        }
                                        echo "
                                                    <tr>
                                                        <td class='id' style=\"visibility: hidden; display:none;\">".$row->getId()."</td>
                                                        <td>".$row->getName()."</td>
                                                        <td>".$row->getTypeSpec()->getName()."</td>
                                                        <td>
                                                            <label>
                                                                <input type=\"checkbox\" disabled ".$checked.">
                                                                <span></span>
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <a  href='#actualizarSpec' class=\"edit modal-trigger\">
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
                            <div id="specLinks">
                                <!--INICIO DE ENLACES DE PAGINATE-->
                                <?php
                                //generando los links de paginacion
                                echo "<div class='row'>";
                                for($i=1;$i<=$paginate->linksNumber();$i++){
                                    echo"<a class='col s1 red-text' onclick=\"attach('spec' ,$i)\">$i</a>";
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
            <a href="#nuevoSpec" class="btn-floating btn-large light-blue darken-2 waves-effect waves-light modal-trigger" data-position="left" data-delay="50">
            <i class="material-icons">add</i>
        </a>
    </div>
</div>

<!--Modal de agregacion de clasificaciones-->
<div id="nuevoSpec" class="modal">
    <div class="modal-content">
        <div class="modal-header row blue white-text">
            <div class="col m10 s9">
                <h3 class="">Nueva especificacion</h3>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m8 offset-m2">
                <form id="frmSpec">
                    <div class="row">
                        <div class="input-field">
                            <input id="specName" name="name" type="text" minlength="1" maxlength="50" pattern="^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\.\,\'\:\;\¿\?\-\!]{1,50}$" title="Solo se permiten números, letras y signos de puntuación" required>
                            <label for="specName">Nombre de especificacion</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field">
                            <select id="specType" class="formSelect" name="typeSpec" required>
                                <option value="" selected="true" disabled="disabled">Tipo de especificación</option>
                                <?php
                                $typeSpecs = new Control\TypeSpecController();
                                foreach ($typeSpecs->getAllActiveTypeSpecs() as $type) {
                                    echo "<option value=".$type->getId().">".$type->getName()."</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <h6 class="center">Seleccione el estado de la especificacion:</h6>
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
                                        <input name="state" type="radio" value="0" />
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

<!--Modal de actualizacion de clasificaciones-->
<div id="actualizarSpec" class="modal">
    <div class="modal-content">
        <div class="modal-header row blue white-text">
            <div class="col m10 s9">
                <h3 class="">Actualizar especificación</h3>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m8 offset-m2">
                <form id="frmSpecUpdate">
                    <input type="hidden" name="id" id="specId">
                    <div class="row">
                        <div class="input-field">
                            <input id="specNameU" name="name" type="text" minlength="1" maxlength="50" pattern="^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\.]{1,50}$" title="Solo se permiten números, letras y signos de puntuación" required>
                            <label id="specNameLabelU" for="specNameU">Nombre de especificacion</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field">
                            <select id="specTypeU" class="formSelect" name="typeSpec" required>
                                <option value="" selected="true" disabled="disabled">Tipo de especificación</option>
                                <?php
                                $typeSpecs = new Control\TypeSpecController();
                                foreach ($typeSpecs->getAllActiveTypeSpecs() as $type) {
                                    echo "<option value=".$type->getId().">".$type->getName()."</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <h6 class="center">Seleccione el estado de la especificacion:</h6>
                        <div class="input-field col s6 push-s1">
                            <div class="col s12 m6 push-m5">
                                <p>
                                    <label>
                                        <input id="specStateA" name="state" value="1" type="radio" checked />
                                        <span>Activo</span>
                                    </label>
                                </p>
                            </div>
                            <div class="col s12 m6 push-m4">
                                <p>
                                    <label>
                                        <input id="specStateI" name="state" value="0" type="radio" />
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

<script src="js/select.js"></script>
<script src="js/spec.js"></script>