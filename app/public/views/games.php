<?php
//declarando namespace a utilizar
use Http\Controllers as Control;
use Http\Helpers as Helper;
if(!isset($ajax)){
    header("Location:../index.php");
}
?>
<link rel="stylesheet" href="css/games.css">

 
 <!--Feed-->
<div id="allGames" class="row">
    <!--INICIO DEL PAGINATE -->
    <?php

    //mostrando los datos solicitados en base al paginate
    $current_page = $page;
    $page = new Control\StorePageController();
    if (!isset($searchType)) {
        $paginate = new Helper\Paginate($page->getAllPagesPublic(),$current_page);
    }
    else {
        $paginate = new Helper\Paginate($page->searchPage($searchType, $param),$current_page);
    }
    foreach ($paginate->getData() as $row){
        echo '<div class="col s6 m3 l3 game">
        <a onclick="attachDatail('.$row->getId().')">
            <div class="card">
                <div class="card-image">
                    <img src="'.substr($row->getGame()->getCover(),3).'">
                    <span class="card-title">'.$row->getGame()->getName().'</span>
                </div>
            </div>
        </a>
    </div>';
    }
    ?>
</div>
<br>
<div id="gameLinks">
    <!--INICIO DE ENLACES DE PAGINATE-->
    <?php
    //generando los links de paginacion
    echo "<div class='row'>";
    for($i=1;$i<=$paginate->linksNumber();$i++){
        if (!isset($searchType)) {
            echo "<a class='col s1 red-text' onclick=\"attach('games' ,$i)\">$i</a>";
        }
        else {
            echo "<a class='col s1 red-text' onclick=\"attachGames($i,'$searchType','$param')\">$i</a>";
        }
    }
    echo "</div>"
    ?>
</div>

