<link rel="stylesheet" href="css/games.css">

 
 <!--Feed-->

 <div class="row">
 <?php
 $url = "attach('gameDetail');";
 for($i = 0; $i<=10; $i++){
     echo '<div class="col s6 m3 l3">
             <div class="card">
                 <div class="card-image">
                     <img src="../web/img/example.png" onclick="'.$url.'">
                     <span class="card-title">Nombre Juego</span>
                 </div>
             </div>
         </div>';
 } ?> 
</div>
