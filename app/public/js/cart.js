$(document).ready( function () {

    //hack que corrije bug del contenedor de las card-image
    setTimeout(function () {
        $(".card-image").css("max-width", "none");
    }, 50);

    $('#modalCartItems').modal({
        onCloseStart :  function() { window.location.reload(); }
    });
});

//Previniendo entrada de texto en input type number
$(".quantity").keypress(function (evt) {
    evt.preventDefault();
});

$(".quantity").change(function () {
    //Obteniendo id del juego
    var $caller = $(this);
    var id = $caller.closest(".cartItem").find(".pageId").val();
    var quant = $caller.val();
    $.ajax({
        method: 'POST',
        data: {'id' : id, 'quant' : quant, 'method' : 'addQuant'},
        url: "../http/controllers/CartController.php",
        success: function (result) {
            var $data = jQuery.parseJSON(result);

            $caller.closest(".cartItem").find(".subtotal").html('$' + $data[0]);
            $('.total').html('Total estimado: $' + $data[1]);
        }
    });
});

$(".delBtn").click(function () {
    //Obteniendo id del juego
    var $caller = $(this);
    var id = $caller.closest(".cartItem").find(".pageId").val();
    $.ajax({
        method: 'POST',
        data: {'id' : id, 'method' : 'delItem'},
        url: "../http/controllers/CartController.php",
        success: function (result) {
            $caller.closest(".cartItem").remove();
            $('.total').html('Total estimado: $' + result);

            //Si el carrito queda vacío muestra un div que indica eso
            if($.trim($('#cartList').html()).length === 0) {
                $('#cartList').append(
                    '<div id="emptyCart" class="row">' +
                        '<div class="col s12 m10 offset-m1 center-align">' +
                            '<div class="card">' +
                                '<div class="card-content">' +
                                    '<i class="material-icons large">shopping_cart</i>' +
                                    '<h3>Carrito vacío</h3>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                    '</div>');
            }
        }
    });
});


//Vaciar carrito
function emptyCart () {
    $.ajax({
        method: 'POST',
        data: {'method' : 'clearCart'},
        url: "../http/controllers/CartController.php",
        success: function (result) {
            attach('cart');
        }
    });
}


//Generar factura con contenido actual del carrito
function submitBill () {

    swal({
        title: '¿Desea realizar esta transacción?',
        icon: 'warning',
        buttons: ['Cancelar', 'Aceptar']
    }).then(function (confirm) {
        if (confirm) {

            $.ajax({
                method: 'POST',
                data: {'method': 'addBill'},
                url: "../http/controllers/BillController.php",
                success: function (result) {

                    var output = result.split("|");
                    if (output[0] == "Éxito") {

                        var $bill = jQuery.parseJSON(output[1]);
                        //Obteniendo id con los items
                        $data = $bill.items;
                        //Vaciando lista
                        $('#cartItemList').empty();
                        //Total de gasto
                        var total = 0;
                        for (var i = 0; i < $data.length; i++) {
                            total += $data[i].price - ($data[i].price * $data[i].discount / 100);

                            $('#cartItemList').append(
                                '<div class="row cardBillItem">' +
                                '<div class="col s12">' +
                                '<div class="card horizontal cart-card">' +
                                '<div class="card-image">' +
                                '<img class="responsive-img" src=' + (($data[i].storePage.game.cover).substring(3)).replace(" ", "%20") + '>' +
                                '</div>' +
                                '<div class="card-stacked">' +
                                '<div class="card-content">' +
                                '<h4>' + $data[i].storePage.game.name + '</h4>' +
                                '<div class="row">' +
                                '<div class="col s4 priceDetail">' +
                                '<label>Precio</label><br>' +
                                '<div class="chip green white-text">$' + $data[i].price + '</div>' +
                                '</div>' +
                                '<div class="col s4 priceDetail">' +
                                '<label>Descuento</label><br>' +
                                '<div class="chip red white-text">-' + $data[i].discount + '%</div>' +
                                '</div>' +
                                '<div class="col s4 priceDetail right-align">' +
                                '<label>Subtotal:</label><br>' +
                                '<div class="chip green white-text">$' + ($data[i].price - ($data[i].price * $data[i].discount / 100)).toFixed(2) + '</div>' +
                                '</div>' +
                                '</div>' +
                                '<div class="row">' +
                                '<div class="col s12 priceDetail">' +
                                '<label>key:</label><br>' +
                                '<h5>' + $data[i].gameKey + '</h5>' +
                                '</div>' +
                                '</div>' +

                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>'
                            );
                        }

                        $('#cartItemList').next().find('h4').html("Total: $" + total.toFixed(2));

                        $('#modalCartItems').modal('open');
                    }

                    else {
                        swal({title: output[0], text: output[1], icon: output[2], button: 'Aceptar', closeOnClickOutside: false, closeOnEsc: false});
                    }
                }
            });
        }
    });
}


//Togglea la clase horizontal del card dependiendo del ancho de la pantalla
$(function(){

    $(window).bind("resize",function(){
        if($(this).width() <500){
            $('.card').removeClass('horizontal');
        }
        else{
            $('.card').addClass('horizontal');
        }
    });
});