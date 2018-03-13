$(document).ready(function() {
    $('.modal').modal();
});


//AJAX DE AGREGAR REGISTRO
$( "#frmGenero" ).submit(function( event ) {
    event.preventDefault();
    console.log($(this).serialize());
    //inicializando ajax
    $.ajax({
        method: "POST",
        //seteando metodo a utilizar en controlador y seteando la data
        data: {
            "genre": $(this).serialize(),
            "method":"addGenre"
        },
        //url (?
        url: "../http/controllers/GenreController.php",
        success: function(result) {
            var output = result.split("|");
            if (output[0] == "Éxito") {
                //si la operacion fue un exito, cerramos el modal
                $('#nuevoGenero').modal('close');
                //refrescamos la pagina
                attach("genre", 1);
            }
            console.log(result);
            swal({title: output[0], text: output[1], icon: output[2], button: 'Aceptar', closeOnClickOutside: false, closeOnEsc: false})
        }
    });
});


//AJAX DE ACTUALIZAR REGISTRO
$( "#frmGeneroUpdate" ).submit(function( event ) {
    event.preventDefault();
    console.log($(this).serialize());
    $.ajax({
        method: "POST",
        //seteamos el metodo a utilizar en el controlador y la data
        data: {
            "genre": $(this).serialize(),
            "method":"updateGenre"
        },
        url: "../http/controllers/GenreController.php",
        success: function(result) {
            var output = result.split("|");
            if (output[0] == "Éxito") {
                //si la operacion fue un exito, cerramos el modal
                $('#actualizarGenero').modal('close');
                //refrescamos la pagina
                attach("genre", 1);
            }
            console.log(result);
            swal({title: output[0], text: output[1], icon: output[2], button: 'Aceptar', closeOnClickOutside: false, closeOnEsc: false})
        }
    });
});

$(".editar").click(function () {
    //obtenemos el id (OJO AGREGAR CLASE ID A TODOS LOS CAMPOS DE LAS TABLAS QUE ALMACENAN EL ID)
   var id = $(this).closest("tr").find(".id").text();
   console.log(id);
    $.ajax({
        method: "POST",
        //seteando id y metodo a utilizar en el controlador
        data: {
            "id": id,
            "method":"getGenre"
        },
        url: "../http/controllers/GenreController.php",
        success: function(result) {
            //parseamos el resultado a json
            var $data = jQuery.parseJSON(result);

            //seteamos los datos en la vista
            $("#genreNameU").val($data.name);
            console.log("state"+$data.state);
            if($data.state==="1"){
                $("#genreStateA").prop("checked", true);
            }else{
                $("#genreStateI").prop("checked", true);
            }

            //seteamos el id (OJO AGEREGAR INPUT TYPE HIDDEN PARA ALMACENAR EL ID)
            $("#genreId").val($data.id);
            //al setear todos los datos abrimos el modal
            $("#actualizarGenero").modal('open');
        }
    });
});