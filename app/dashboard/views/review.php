<?php
/**
 * Created by PhpStorm.
 * User: oscar
 * Date: 26/03/2018
 * Time: 21:15
 */
//declarando namespace a utilizar
use Http\Controllers as Control;
use Http\Helpers as Helper;
?>

<div class="wrapper">
    <div class="row search-box">
        <!--Añadir filtro para clasificaciones-->
        <div class="col s12 m6 offset-m3">
            <div class="card-search-box hoverable white">
                    <div class="input-field">
                        <input id="review-search" type="text" class="validate filtro" name="filtro" placeholder="Buscar por juego o usuario ">
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
                                        <span class="card-title">Gestión de reviews</span>
                                    </div>
                                </div>
                            </div>
                            <table class="bordered highlight responsive-table" id="users">
                                <thead>
                                    <tr class="table-users">
                                        <th style="visibility: hidden; display:none;">ID</th>
                                        <th>Nombre de juego</th>
                                        <th>Descripcion</th>
                                        <th>Fecha</th>
                                        <th>Visible</th>
                                    </tr>
                                </thead>

                                <tbody id="allReviews">
                                <!-- INICIO DEL PAGINATE -->
                                <?php
                                //mostrando los datos solicitados en base al paginate
                                $current_page = $page;
                                $reviews = new Control\RatingController();
                                $paginate = new Helper\Paginate($reviews->getAllRatings(),$current_page);

                                foreach ($paginate->getData() as $row){
                                    $checked = "";
                                    if($row->getVisible()==1){
                                        $checked = "checked";
                                    }
                                    echo "
                                                <tr>
                                                    <td class='id' style=\"visibility: hidden; display:none;\">".$row->getId()."</td>
                                                    <td>".$row->getBillItem()->getStorePage()->getGame()->getName()."</td>
                                                    <td>".$row->getDescription()."</td>
                                                    <td>".date_format($row->getReviewDate(),'d-m-y')."</td>
                                                    <td> 
                                                        <label>
                                                            <input class='ban' type=\"checkbox\"  ".$checked." />
                                                            <span></span>
                                                         </label>
                                                    </td>
                                                </tr>
                                            
                                            ";
                                }
                                ?>
                                <!--FIN DE PAGINATE-->
                                </tbody>
                            </table>
                            <br>
                            <div id="reviewLinks">
                                <!--INICIO DE ENLACES DE PAGINATE-->
                                <?php
                                //generando los links de paginacion
                                echo "<div class='row'>";
                                for($i=1;$i<=$paginate->linksNumber();$i++){
                                    echo"<a class='col s1 red-text' onclick=\"attach('review' ,$i)\">$i</a>";
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
</div>
<script src="js/review.js"></script>