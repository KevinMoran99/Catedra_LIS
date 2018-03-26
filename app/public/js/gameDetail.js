$(document).ready(function() {
    var image =  $("#banner");
    image.css('visibility','hidden');
    $(".gameBackground").css("background-image", "url('"+image.text()+"')");
});


$('#cartButton').click(function (e) {
    //Añadiendo id de juego a variable de sesion que contiene los ids de juegos del carrito
    $.ajax({
        method: 'POST',
        data: {'id' : gameId, 'method' : 'addItem'},
        url: "../http/controllers/CartController.php",
        success: function (result) {
            attach('cart');
            $(".menu-item").removeClass("selected-item");
            $(".menu-item").find("li").removeClass("selected-item");
            $("#menu-cart").addClass("selected-item");
        }
    });
});