<?php
//declarando namespace a utilizar
use Http\Controllers as Control;
use Http\Helpers as Helper;
?>

<div id="genre"class="wrapper">
    <div class="row search-box">
        <!--Añadir filtro para generos-->
        <div class="col s12 m6 offset-m3">
            <div class="card-search-box hoverable white">
                <form action="" method="GET" id="form-filtro">
                    <div class="input-field">
                        <input id="icon_prefix" type="text" class="validate filtro" name="filtro" placeholder="Buscar genero">
                    </div>
                </form>
            </div>
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
                                        <span class="card-title">Gestión de Generos</span>
                                    </div>
                                </div>
                            </div>
                            <table class="bordered highlight responsive-table" id="users">
                                <thead>
                                    <tr class="table-users">
                                        <th style="visibility: hidden; display:none;">ID</th>
                                        <th>Nombre de genero</th>
                                        <th>Editar</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                        //mostrando los datos solicitados en base al paginate
                                        $current_page = $page;
                                        $genres = new Control\GenreController();
                                        $paginate = new Helper\Paginate($genres->getAllGenres(),$current_page);
                                        foreach ($paginate->getData() as $row){
                                            echo "
                                                <tr>
                                                    <td style=\"visibility: hidden; display:none;\">".$row->getId()."</td>
                                                    <td>".$row->getName()."</td>
                                                    <td>
                                                        <a href=\"#nuevoGenero\" onclick=\"\" class=\"edit modal-trigger\">
                                                             <i class=\"material-icons tooltipped editar\" data-position=\"left\" data-delay=\"50\">mode_edit</i>
                                                         </a>
                                                     </td>
                                                </tr>
                                            
                                            ";
                                        }
                                    ?>
                                </tbody>
                            </table>
                            <br>
                            <?php
                            //generando los links de paginacion
                            echo "<div class='row'>";
                            for($i=1;$i<=$paginate->linksNumber();$i++){
                                echo"<a class='col s1 red-text' onclick=\"attach('genre' ,$i)\">$i</a>";
                            }
                            echo "</div>"
                            ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="fixed-action-btn horizontal click-to-toggle">
        <a href="#nuevoGenero" class="btn-floating btn-large light-blue darken-2 waves-effect waves-light modal-trigger" data-position="left" data-delay="50">
            <i class="material-icons">add</i>
        </a>
    </div>
</div>

<!--Modal de agregacion de clasificaciones-->
<div id="nuevoGenero" class="modal">
    <div class="modal-content">
        <div class="modal-header row blue white-text">
            <div class="col m10 s9">
                <h3 class="">Nuevo genero</h3>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m8 offset-m2 center-align">
                <form id="frmRegEsrb">
                    <div class="input-field">
                        <input id="registerUser" type="text" required>
                        <label for="registerUser">Nombre de genero</label>
                    </div>

                    <div class="row">
                        <h6 class="center">Seleccione el estado del genero:</h6>
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