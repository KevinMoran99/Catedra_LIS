$(document).ready(function() {
    var image =  $("#banner");
    $(".modal").modal();
    image.css('visibility','hidden');
    $(".gameBackground").css("background-image", "url('"+image.text()+"')");
    $("body").css("background-color","rgba("+$("#dominantColor").text()+",0.8)");
    $("nav.center-align").css("background-color","rgba("+$("#dominantColor").text()+")")
});


$('#cartButton').click(function (e) {
    //Añadiendo id de juego a variable de sesion que contiene los ids de juegos del carrito
    $.ajax({
        method: 'POST',
        data: {'id' : gameId, 'method' : 'addItem'},
        url: "../http/controllers/CartController.php",
        success: function (result) {
            console.log(result);
            attach('cart');
            $(".menu-item").removeClass("selected-item");
            $(".menu-item").find("li").removeClass("selected-item");
            $("#menu-cart").addClass("selected-item");
        }
    });
});

//AJAX DE AGREGAR REGISTRO
$( "#frmReview" ).submit(function( event ) {
    event.preventDefault();
    var formData = new FormData(this);
    var id = $("#myReviewId").val();
    if(id == 0){
        formData.append("method",'addRating');
    }else{
        formData.append("method",'updateRating');
        formData.append("id",id);
    }
    //inicializando ajax
    $.ajax({
        method: "POST",
        //seteando metodo a utilizar en controlador y seteando la data
        data: formData,
        contentType: false,
        processData: false,
        //url (?
        url: "../http/controllers/RatingController.php",
        success: function(result) {
            var output = result.split("|");
            if (output[0] == "Éxito") {
                //si la operacion fue un exito, cerramos el modal
                $('#review-modal').modal('close');
                //refrescamos la pagina
                attachDatail(gameId);
            }
            console.log(result);
            swal({title: output[0], text: output[1], icon: output[2], button: 'Aceptar', closeOnClickOutside: false, closeOnEsc: false})
        }
    });
});