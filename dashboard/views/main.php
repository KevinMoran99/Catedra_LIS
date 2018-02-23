
<div class="navbar-fixed">
    <nav>
        <h5 id="nav-title">Todos los juegos:</h5>
        <div id="filter-container" class="input-field">
            <select id="filter" class="js-example-basic-single">
              <option value="" disabled selected>Todos</option>
              <option value="1">Option 1</option>
              <option value="2">Option 2</option>
              <option value="3">Option 3</option>
            </select>
        </div>
    </nav>
</div>

<div class="wrapper">
    <div class="row">
        <?php
        $url = "attach('gameDetail');";
        for($i = 0; $i<=10; $i++){
            echo '<div class="col s6 m3 l3">
                    <a class="modal-trigger" href="#MODALDEMODIFICAR">
                        <div class="card">
                            <div class="card-image">
                                <img src="../web/img/example.png">
                                <span class="card-title">Nombre Juego</span>
                            </div>
                        </div>
                    </a>
                </div>';
        } ?> 
    </div>
    <div class="fixed-action-btn">
        <a class="btn-floating btn-large waves-effect waves-light red modal-trigger" href="#MODALDEAÑADIR"><i class="material-icons">add</i></a>
    </div>
</div>

<script src="js/main.js"></script>