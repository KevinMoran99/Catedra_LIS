<?php
//declarando namespace a utilizar
use Http\Controllers as Control;
use Http\Helpers as Helper;
?>
<!--vista de faqs-->
<div class="wrapper">
    <div class="row search-box">
        <!--Añadir filtro para FAQS-->
        <div class="col s12 m6 offset-m3">
            <div class="card-search-box hoverable white">
                <div class="input-field">
                    <input id="faq-search" type="text" class="validate filtro" name="filtro" placeholder="Buscar FAQ">
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
                                        <span class="card-title">Gestión de Soporte Técnico</span>
                                    </div>
                                </div>
                            </div>
                            <table class="bordered highlight responsive-table" id="users">
                                <thead>
                                    <tr class="table-users">
                                        <th style="visibility: hidden; display:none;">ID</th>
                                        <th>Pregunta</th>
                                        <th>Respuesta</th>
                                        <th>Estado</th>
                                        <th>Editar</th>
                                    </tr>
                                </thead>


                                <tbody id="allFaqs">
                                <!-- INICIO DEL PAGINATE -->
                                <?php
                                    //mostrando los datos solicitados en base al paginate
                                    $current_page = $page;
                                    $faq = new Control\FaqController();
                                    $paginate = new Helper\Paginate($faq->getAllFaqs(),$current_page);
                                    foreach ($paginate->getData() as $row){
                                        $checked = "";
                                        if($row->getState()==1){
                                            $checked = "checked";
                                        }
                                        echo "
                                                <tr>
                                                    <td class='id' style=\"visibility: hidden; display:none;\">".$row->getId()."</td>
                                                    <td>".$row->getTitle()."</td>
                                                    <td>".$row->getDescription()."</td>
                                                    <td>
                                                        <label>
                                                            <input type=\"checkbox\" disabled ".$checked.">
                                                            <span></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <a  href='#actualizarFaq' class=\"edit modal-trigger\">
                                                             <i class=\"material-icons tooltipped editar\" data-position=\"left\" data-delay=\"50\">mode_edit</i>
                                                         </a>
                                                     </td>
                                                </tr>
                                                    
                                                    ";
                                    }
                                ?>
                                <!--FIN DE PAGINATE-->
                            </table>
                            <br>
                            <div id="faqLinks">
                                <!--INICIO DE ENLACES DE PAGINATE-->
                                <?php
                                //generando los links de paginacion
                                echo "<div class='row'>";
                                for($i=1;$i<=$paginate->linksNumber();$i++){
                                    echo"<a class='col s1 red-text' onclick=\"attach('support' ,$i)\">$i</a>";
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
        <a href="#nuevaFaq" class="btn-floating btn-large light-blue darken-2 waves-effect waves-light modal-trigger" data-position="left" data-delay="50">
            <i class="material-icons">add</i>
        </a>
    </div>
</div>

<!--Modal de agregacion de clasificaciones-->
<div id="nuevaFaq" class="modal">
    <div class="modal-content">
        <div class="modal-header row blue white-text">
            <div class="col m10 s9">
                <h3 class="">Nueva FAQ</h3>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m8 offset-m2 center-align">
                <form id="frmFaq" action="#">
                    <div class="input-field">
                        <input id="faqTitle" name="title" type="text" minlength="3" maxlength="500" pattern="^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\'\.\,\:\;\¿\?\-\!]{3,500}$" title="Solo se permiten números, letras y signos de puntuación" required>
                        <label for="faqTitle">Pregunta</label>
                    </div>

                    <div class="input-field">
                        <textarea class="materialize-textarea" id="faqDescription" name="description" type="text" minlength="3" maxlength="1000" pattern="^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s \' \. \, \' \: \; \¿ \? \- \!]{3,1000}$" title="Solo se permiten números, letras y signos de puntuación" required></textarea>
                        <label for="faqDescription">Respuesta</label>
                    </div>

                    <div class="row">
                        <h6 class="center">Seleccione el estado de la FAQ:</h6>
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


<!--Modal de modificación de clasificaciones-->
<div id="actualizarFaq" class="modal">
    <div class="modal-content">
        <div class="modal-header row blue white-text">
            <div class="col m10 s9">
                <h3 class="">Actualizar FAQ</h3>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m8 offset-m2 center-align">
                <form id="frmFaqUpdate" action="#">
                    <input type="hidden" name="id" id="faqId">
                    <div class="input-field">
                        <input id="faqTitleU" name="title" type="text" minlength="3" maxlength="500" pattern="^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s \' \. \, \' \: \; \¿ \? \- \!]{3,500}$" title="Solo se permiten números, letras y signos de puntuación" required>
                        <label id="faqTitleLabelU" for="faqTitleU">Pregunta</label>
                    </div>

                    <div class="input-field">
                        <textarea class="materialize-textarea" id="faqDescriptionU" name="description" type="text" minlength="3" maxlength="1000" pattern="^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s \' \. \, \' \: \; \¿ \? \- \!]{3,1000}$" title="Solo se permiten números, letras y signos de puntuación" required></textarea>
                        <label id="faqDescriptionLabelU" for="faqDescriptionU">Respuesta</label>
                    </div>

                    <div class="row">
                        <h6 class="center">Seleccione el estado de la FAQ:</h6>
                        <div class="input-field col s6 push-s1">
                            <div class="col s12 m6 push-m5">
                                <p>
                                    <label>
                                        <input id="faqStateA" name="state" type="radio" value="1" checked />
                                        <span>Activo</span>
                                    </label>
                                </p>
                            </div>
                            <div class="col s12 m6 push-m4">
                                <p>
                                    <label>
                                        <input id="faqStateI" name="state" type="radio" value="0" />
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

<script src="js/support.js"></script>