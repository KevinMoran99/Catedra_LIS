<link rel="stylesheet" href="css/cart.css">
<!--vista de carro de compras de -->
<div class="navbar-fixed">
    <nav class="center-align">
        <h5>Carrito de compras</h5>
    </nav>
</div>

<div id="emptyCart" class="row">
    <div class="col s12 m10 offset-m1 center-align">
        <div class="card">
            <div class="card-content">
                <i class="material-icons large">shopping_cart</i>
                <h3>Carrito vacío</h3>
            </div>
        </div>
    </div>
</div>

<div id="cartList">
    <div class="row cartItem">
        <div class="col s10 offset-s1">
            <div class="card horizontal cart-card">
                <div class="card-image">
                    <img class="responsive-img" src="../web/img/example.png">
                </div>
                <div class="card-stacked">
                    <div class="card-content">
                        <h4>Nombre del juego</h4>
                        <div class="chip green white-text">$9.99</div>
                    </div>
                    <div class="card-action">
                        <a class="red-text delBtn" href="#">Eliminar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row cartItem">
        <div class="col s10 offset-s1">
            <div class="card horizontal cart-card">
                <div class="card-image">
                    <img class="responsive-img" src="../web/img/example.png">
                </div>
                <div class="card-stacked">
                    <div class="card-content">
                        <h4>Nombre del juego</h4>
                        <div class="chip green white-text">$9.99</div>
                    </div>
                    <div class="card-action">
                        <a class="red-text delBtn" href="#">Eliminar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row cartItem">
        <div class="col s10 offset-s1">
            <div class="card horizontal cart-card">
                <div class="card-image">
                    <img class="responsive-img" src="../web/img/example.png">
                </div>
                <div class="card-stacked">
                    <div class="card-content">
                        <h4>Nombre del juego</h4>
                        <div class="chip green white-text">$9.99</div>
                    </div>
                    <div class="card-action">
                        <a class="red-text delBtn" href="#">Eliminar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col s10 offset-s1">
        <div id="card-total" class="card ">
            <div class="card-content">
                <div class="row">
                    <h5 class="right">Total estimado: $100.00</h5>
                </div>
                <div class="row">
                    <button class="col s12 l3 btn waves-effect right">Realizar transacción</button>
                    <button class="col s12 l3 btn waves-effect blue right"><a href="/Catedra_LIS/public">Seguir buscando</a></button>
                    <button class="col s12 l3 btn waves-effect red left" onclick="emptyCart()">Vaciar carrito</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/cart.js"></script>