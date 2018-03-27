<?php
//declarando namespace a utilizar
use Http\Controllers as Control;
use Http\Helpers as Helper;
?>
<!--Banners dinamicos-->
<div class="carousel carousel-slider center" data-indicators="true">
    <?php
    //mostrando los datos solicitados en base al paginate
    $current_page = $page;
    $page = new Control\StorePageController();
    $paginate = new Helper\Paginate($page->getTop3Pages(),$current_page);
    foreach ($paginate->getData() as $row){
        echo '
                    <a onclick="attachDatail('.$row->getId().')">
                    <div class="carousel-item"  id="game1-banner">
                        <div class="carousel-fixed-item center white-text carousel-footer">
                            <h2 id="game1">'.$row->getGame()->getName().'</h2>
                            <p id="game1-developer">'.$row->getGame()->getPublisher()->getName().'</p>
                            <p id="carousel-image">'.substr($row->getGame()->getBanner(),3).'</p>
                    </div>
             </div>
             </a>';
    }
    ?>
</div>

<div id="mainBreak" class="row">
    <h4 class="left">Explora nuestros juegos</h4>
</div>
<?php include 'games.php';?>
