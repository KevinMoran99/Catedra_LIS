<?php
if(!isset($ajax)){
    header("Location:../index.php");
}
?>
<link rel="stylesheet" href="css/about.css">
<!--vista de acerca de -->

<div class="row">
    <div class="col s10 offset-s1 card">
        <!--Encabezado-->
        <div id="logo" class="row center-align">
            <div class="col s6 offset-s3"><img class="responsive-img" src="../web/img/logo.png"> </div>
            <div class="col s12">
                <h4 class="center-align">Sttom xD</h4>
            </div>
            <div class="col s12">
                <h5 class="center-align deep-orange-text darken-4">"Vive para trabajar. Trabaja para jugar. Juega para vivir."</h5>
            </div>
        </div>

        <!--Historia-->
        <div class="row justify-align">
            <div class="col s12">
                <h4>Historia:</h4>
                <div class="divider"></div>
            </div>
            <div class="col s12">
                <p>Sttom, o a veces llamado Stoam, nació cuando sus creadores cursaban la materia de "Lenguajes Interpretados en el Servidor" en la Universidad Don Bosco en El Salvador. Comenzó como un simple proyecto de cátedra para la materia, pero luego
                    de concluir sus estudios, sus creadores decidieron seguir con el proyecto, el cual fue patrocinado por diversas empresas internacionales radicadas en El Salvador, como Almacenes La Bomba y Pupusería "El Buen Gusto", y que, después
                    de diez largos años de trabajo y dedicación, logró convertirse en una de las principales potencias económicas mundiales, estando un puesto bajo la banda de death metal americana, Dethklok. De esta manera, Sttom superó y adquirió los
                    derechos de todas sus compañías rivales, desde Nintendo PC y Spotify Games hasta un vil intento de plagio hacia la compañía, llamado "Steam". Con esto, Sttom logró unificar la industria de los videojuegos a formato PC solamente, aboliendo
                    la eterna guerra de consolas y acabando con el hambre en el mundo.</p>
            </div>
        </div>


        <!--Mision, vision y valores-->
        <div class="row">
            <div class="col s12">
                <h4>Ideales</h4>
                <div class="divider"></div>
            </div>
            <div class="col s12 m4">
                <div class="card grey darken-3">
                    <div class="card-content white-text">
                        <span class="card-title indigo center-align">Misión</span>
                        <p class="justify-align">Proporcionar la mejor experiencia de venta digital de videojuegos en la industria, ofreciendo a nuestros clientes los mejores juegos, con las mejores ofertas y la mejor atención.</p>
                    </div>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="card grey darken-3">
                    <div class="card-content white-text">
                        <span class="card-title indigo center-align">Visión</span>
                        <p class="justify-align">Aumentar nuestras barreras comerciales a niveles cósmicos (sí, al espacio), hacer de la comunidad gayming un lugar amigable para todas las razas, edades y denominaciones, a la vez de permitir que los videojuegos sean más accesibles
                            para todos. Y, por supuesto, acabar con la homosexualidad.</p>
                    </div>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="card grey darken-3">
                    <div class="card-content white-text center-align">
                        <span class="card-title indigo">Valores</span>
                        <ul>
                            <li>Dedicación</li>
                            <li>Superación</li>
                            <li>Compañerismo</li>
                            <li>Honestidad</li>
                            <li>Tolerancia</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="divider"></div>
        </div>

        <!--Integrantes-->
        <div class="row">
            <div class="col s12">
                <h4>El equipo:</h4>
                <div class="divider"></div>
            </div>
            <div class="col s12 m4 center-align">
                <img class="circle responsive-img" src="img/oscar.jpg">
                <h5>Oscar Méndez</h5>
                <h6>Programador</h6>
            </div>
            <div class="col s12 m4 center-align">
                <img class="circle responsive-img" src="img/kevin.jpg">
                <h5>Kevin Morán</h5>
                <h6>Programador</h6>
            </div>
            <div class="col s12 m4 center-align">
                <img class="circle responsive-img" src="img/raul.jpg">
                <h5>Raúl Alvarado</h5>
                <h6>Programador</h6>
            </div>

        </div>

        <!--Medios de contacto e información-->
        <div class="row">
            <div class="col s12">
                <h4>Contáctenos:</h4>
                <div class="divider"></div>
            </div>
            <div class="col s12 l9 offset-l3 contact">
                <i class="material-icons medium">phone</i>
                <h4>22728097</h4>
            </div>
            <div class="col s12 l9 offset-l3 contact">
                <i class="material-icons medium">email</i>
                <h4 class="truncate">expoxvi@gmail.com</h4>
            </div>
            <div class="col s12 l9 offset-l3 contact">
                <i class="material-icons medium">location_on</i>
                <h4>Avenida Aguilares, San Salvador</h4>
            </div>
        </div>
    </div>
</div>

<script src="js/about.js"></script>