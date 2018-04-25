<?php
//declarando namespace a utilizar
use Http\Controllers as Control;
use Http\Helpers as Helper;
if(!isset($ajax)){
    header("Location:../index.php");
}
?>
<link rel="stylesheet" href="css/support.css">
<!--vista de faq -->

<div class="row">
    <div class="col m10 offset-m1 card">
        <h5 class="center-align">En esta sección encontrara los inconvenientes mas comunes entre usuarios, puede ayudarnos a expandir esta lista contactándonos en la sección de "Quiénes somos?."</h5>
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
        <ul id="allFaqs" class="collapsible popout">
            <!-- INICIO DEL PAGINATE -->
            <?php
            //mostrando los datos solicitados en base al paginate
            $current_page = $page;
            $faq = new Control\FaqController();
            $paginate = new Helper\Paginate($faq->getAllActiveFaqs(),$current_page);
            foreach ($paginate->getData() as $row){
                echo "<li>
                          <div class=\"collapsible-header\"><i class=\"material-icons\">question_answer</i>".$row->getTitle()."</div>
                          <div class=\"collapsible-body\"><span>".$row->getDescription()."</span></div>
                      </li>";
            }
            ?>
            <!--FIN DE PAGINATE-->
        </ul>
        <div id="faqLinks">
            <!--INICIO DE ENLACES DE PAGINATE-->
            <?php
            //generando los links de paginacion
            echo "<div class='row center-align'>";
            for($i=1;$i<=$paginate->linksNumber();$i++){
                echo"<a class='col s1 red-text' onclick=\"attach('support' ,$i)\">$i</a>";
            }
            echo "</div>"
            ?>
        </div>
        <!--FIN DE ENLACES DE PAGINATE-->
    </div>
</div>

<script src="js/support.js"></script>