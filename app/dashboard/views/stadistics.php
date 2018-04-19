<?php
//declarando namespace a utilizar
use Http\Controllers as Control;
use Http\Helpers as Helper;

?>

<!--vista de estadisticas-->
<div class="wrapper">
    <h4>Estadísticas</h4>
    <!--Gráficas de demostración-->

    <div class="row">
        <h5>Cantidad de juegos vendidos por publicador</h5>
        <div id="chartBar" class="col s12">
            <canvas id="ChartBar" width="400" height="400"></canvas>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m6 offset-m3">
            <h5>Porcentaje de juegos por género</h5>
            <canvas id="ChartPie" width="400" height="400"></canvas>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m6 offset-m3">
            <h5>Cantidad de juegos por clasificación ESRB</h5>
            <canvas id="ChartPolar" width="400" height="400"></canvas>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m8 offset-m2">
            <h5>Unidades vendidas de cada juego por año</h5>
            <div class="row">
                <div class="col s12 m6">
                    <select id="lineDate" name="lineDate" class="selectTwo" required>
                        <option value="" disabled="disabled" selected="true">Año</option>
                        <?php
                            for ($i = 2015; $i <= date("Y"); $i++) {
                                echo "<option value=" . $i . ">" . $i . "</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="col s12 m6">
                    <select id="lineGame" name="lineGame" class="selectTwo" required>
                        <option value="" disabled="disabled" selected="true">Juego</option>
                        <?php
                            $games = new Control\GameController();
                            foreach ($games->getAllGames() as $game) {
                                echo "<option value=" . $game->getId() . ">" . $game->getName() . "</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
            <canvas id="ChartLine" width="400" height="400"></canvas>
        </div>
    </div>
    
    <div class="row">
        <h5>Detalles de juego</h5>
        <div class="row">
            <div class="col s12 m6 offset-m3">
                <select id="radarGame" name="radarGame" class="selectTwo" required>
                    <option value="" disabled="disabled" selected="true">Juego</option>
                    <?php
                        $games = new Control\GameController();
                        foreach ($games->getAllGames() as $game) {
                            echo "<option value=" . $game->getId() . ">" . $game->getName() . "</option>";
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="col s12 m6">
            <canvas id="ChartBarHor" width="400" height="400"></canvas>
        </div>
        <div class="col s12 m6">
            <canvas id="ChartRadar" width="400" height="400"></canvas>
        </div>
    </div>
</div>

<script src="js/stadistics.js"></script>