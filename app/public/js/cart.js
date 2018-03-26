$(document).ready( function () {

    //hack que corrije bug del contenedor de las card-image
    setTimeout(function () {
        $(".card-image").css("max-width", "none");
    }, 50)
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
        buttons: ['Cancelar', 'Modificar']
    }).then(function (confirm) {
        if (confirm) {

            $.ajax({
                method: 'POST',
                data: {'method': 'addBill'},
                url: "../http/controllers/BillController.php",
                success: function (result) {
                    console.log(result);
                    window.location.reload();
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