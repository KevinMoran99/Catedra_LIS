<!DOCTYPE html>
<html>
    <head>
        <title>Buscar juego</title>

        <?php include 'templates/styles.html';?>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        
        <!--menu-->
        <?php include 'templates/navbar.html';?>
        
        <div class="row">
            <div class="col m10 offset-m1">

                <div class="row">
                    <div class="nav-wrapper">
                        <div class="input-field col s12">
                            <input id="search" type="search">
                            <label class="label-icon" for="search"><i class="material-icons">search</i></label>
                            <i class="material-icons">close</i>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="input-field col s12">
                        <select multiple>
                        <option value="" disabled selected>Categoría o algo</option>
                        <option value="1">Option 1</option>
                        <option value="2">Option 2</option>
                        <option value="3">Option 3</option>
                        </select>
                        <label>Categoría o algo</label>
                    </div>
                    
                </div>
                
                
                <div class="row">
                    <div class="col s12">
                        <div class="card horizontal">
                            <div class="card-image">
                                <img src="https://picsum.photos/240/180">
                            </div>
                            <div class="card-stacked">
                                <div class="card-content">
                                    <p>Info del jueguito lindo</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <div class="card horizontal">
                            <div class="card-image">
                                <img src="https://picsum.photos/240/180">
                            </div>
                            <div class="card-stacked">
                                <div class="card-content">
                                    <p>Info del jueguito lindo</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <div class="card horizontal">
                            <div class="card-image">
                                <img src="https://picsum.photos/240/180">
                            </div>
                            <div class="card-stacked">
                                <div class="card-content">
                                    <p>Info del jueguito lindo</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        
    </body>
    <?php include 'templates/scripts.html';?>
</html>