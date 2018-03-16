$(document).ready(function () {
    //Inicializando select2
   $('.js-example-basic-single').select2();
});

//AJAX DE AGREGAR REGISTRO
$( "#frmRegJg" ).submit(function( event ) {
    event.preventDefault();
    var formData = new FormData(this);
    formData.append("method",'addPlatform');
    //inicializando ajax
    $.ajax({
        method: "POST",
        //seteando metodo a utilizar en controlador y seteando la data
        data: formData,
        contentType: false,
        processData: false,
        //url (?
        url: "../http/controllers/PlatformController.php",
        success: function(result) {
            var output = result.split("|");
            if (output[0] == "Éxito") {
                //si la operacion fue un exito, cerramos el modal
                $('#nuevaPlataforma').modal('close');
                //refrescamos la pagina
                attach("platform", 1);
            }
            console.log(result);
            swal({title: output[0], text: output[1], icon: output[2], button: 'Aceptar', closeOnClickOutside: false, closeOnEsc: false})
        }
    });
});