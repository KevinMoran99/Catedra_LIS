<?php
//declarando namespace a utilizar
use Http\Controllers as Control;
use Http\Helpers as Helper;
?>
<link rel="stylesheet" href="css/games.css">

 
 <!--Feed-->
<div id="allGames" class="row">
    <!--INICIO DEL PAGINATE -->
    <?php
    //mostrando los datos solicitados en base al paginate
    $current_page = $page;
    $games = new Control\GameController();
    $paginate = new Helper\Paginate($games->getAllGamesPublic(),$current_page);
    foreach ($paginate->getData() as $row){

        echo '<div class="col s6 m3 l3 game">
        <a class="modal-trigger edit" href="#actualizarJuego">
            <div class="card">
                <div class="card-image">
                    <img src="'.substr($row->getCover(),3).'">
                    <span class="card-title">'.$row->getName().'</span>
                    <span id="gameId" class="id" style="visibility: hidden; display:none;">'.$row->getId().'</span>
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
        echo"<a class='col s1 red-text' onclick=\"attach('main' ,$i)\">$i</a>";
    }
    echo "</div>"
    ?>
</div>

