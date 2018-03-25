$(document).ready(function() {
    var image =  $("#banner");
    image.css('visibility','hidden');
    $(".gameBackground").css("background-image", "url('"+image.text()+"')");
});


$('#cartButton').click(function (e) {
    //Añadiendo id de juego a variable de sesion que contiene los ids de juegos del carrito
    $.ajax({
        method: 'POST',
        data: {'id' : gameId},
        url: "../http/controllers/CartController.php",
        success: function (result) {
            console.log(result);
        }
    });
});