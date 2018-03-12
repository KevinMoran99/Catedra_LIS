$(document).ready(function() {
    $('.modal').modal();
});


$( "#frmGenero" ).submit(function( event ) {
    event.preventDefault();
    console.log($(this).serialize());
    $.ajax({
        method: "POST",
        data: {
            "genre": $(this).serialize(),
            "method":"addGenre"
        },
        url: "../http/controllers/GenreController.php",
        success: function(result) {
            var output = result.split("|");
            if (output[0] == "Éxito") {
                $('#nuevoGenero').modal('close');
                attach("genre", 1);
            }
            console.log(result);
            swal({title: output[0], text: output[1], icon: output[2], button: 'Aceptar', closeOnClickOutside: false, closeOnEsc: false})
        }
    });
});

$(".editar").click(function () {
   var id = $(this).closest("tr").find(".id").text();
   console.log(id);
    $.ajax({
        method: "POST",
        data: {
            "id": id,
            "method":"getGenre"
        },
        url: "../http/controllers/GenreController.php",
        success: function(result) {
            var $data = jQuery.parseJSON(result);
            $("#genreNameU").val($data.name);
            console.log("state"+$data.state);
            if($data.state==="1"){
                $("#genreStateA").prop("checked", true);
            }else{
                $("#genreStateI").prop("checked", true);
            }
            $("#actualizarGenero").modal('open');
        }
    });
});