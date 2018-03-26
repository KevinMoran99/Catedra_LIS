
<?php
//declarando namespace a utilizar
use Http\Controllers as Control;
use Http\Helpers as Helper;
?>
<link rel="stylesheet" href="css/cart.css">
<!--vista de carro de compras de -->



<!--Lista de objetos en carrito-->
<div id="cartList">
    <?php
        session_start();

        //Si el carrito esta vacío
        if (empty($_SESSION['cart'])) {
            echo '<div id="emptyCart" class="row">
                    <div class="col s12 m10 offset-m1 center-align">
                        <div class="card">
                            <div class="card-content">
                                <i class="material-icons large">shopping_cart</i>
                                <h3>Carrito vacío</h3>
                            </div>
                        </div>
                    </div>
                </div>';
        }

        else {
            $total = 0;
            foreach ($_SESSION['cart'] as $item) {
                $id = $item[0]->getId();
                $name = $item[0]->getGame()->getName();
                $cover = str_replace(' ', '%20',substr($item[0]->getGame()->getCover(),3));
                $price = $item[0]->getPrice();
                $discount = $item[0]->getDiscount();
                $quantity = $item[1];

                $subtotal = ($price - ($price * $discount / 100)) * $quantity;

                $total += $subtotal;

                echo '<div class="row cartItem">
                        <input class="pageId" type="hidden" value="'.$id.'">
                        <div class="col s10 offset-s1">
                            <div class="card horizontal cart-card">
                                <div class="card-image">
                                    <img class="responsive-img" src='.$cover.'>
                                </div>
                                <div class="card-stacked">
                                    <div class="card-content">
                                        <h4>'.$name.'</h4>
                                        <div class="row">
                                            <div class="col s6 m3 priceDetail">
                                                <label>Precio</label><br>
                                                <div class="chip green white-text">$'.number_format($price,2).'</div>
                                            </div>
                                            <div class="col s6 m3 priceDetail">
                                                <label>Descuento</label><br>
                                                <div class="chip red white-text">-'.$discount.'%</div>
                                            </div>
                                            <div class="col s6 m3 priceDetail">
                                                <label>Cantidad</label>
                                                <input class="quantity" type="number" value="'.$quantity.'" min="1" max="20">
                                            </div>
                                            <div class="col s6 m3 priceDetail right-align">
                                                <label>Subtotal</label><br>
                                                <div class="chip green white-text subtotal">$'.number_format($subtotal,2).'</div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="card-action">
                                        <a class="red-text delBtn" href="#">Eliminar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
            }
        }
    ?>
</div>


<!--Controles-->
<div class="row">
    <div class="col s10 offset-s1">
        <div id="card-total" class="card ">
            <div class="card-content">
                <div class="row">
                    <?php
                        $totalPrint = isset($total) ? number_format($total,2) : "0.00";
                        echo '<h5 class="right total">Total estimado: $'.$totalPrint.'</h5>'
                    ?>
                </div>
                <div class="row">
                    <?php
                        if (!(empty($_SESSION['user']) || empty($_SESSION['cart']))) {
                            echo '<button class="col s12 l3 btn waves-effect right" onclick="submitBill()">Realizar transacción</button>';
                        }
                    ?>
                    <button class="col s12 l3 btn waves-effect blue right"><a href="/Catedra_LIS/app/public">Seguir buscando</a></button>
                    <button class="col s12 l3 btn waves-effect red left" onclick="emptyCart()">Vaciar carrito</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/cart.js"></script>