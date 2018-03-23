$(document).ready( function () {
    $("#emptyCart").hide();

    //hack que corrije bug del contenedor de las card-image
    setTimeout(function () {
        $(".card-image").css("max-width", "none");
    }, 50)
});


//Botón eliminar
$(".delBtn").click( function(event) {
    $(event.target).parents(".row").remove();
});

//Vaciar carrito
function emptyCart () {
    $("#cartList").empty();
    $("#emptyCart").show();
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