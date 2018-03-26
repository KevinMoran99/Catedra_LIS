//AJAX de agregar storepage
$( "#frmRegJg" ).submit(function( event ) {
    event.preventDefault();
    var formData = new FormData(this);
    var files = $('#image').prop('files')[0];
    var files2 = $('#image2').prop('files')[0];
    formData.append('cover',files);
    formData.append('banner',files2);
    formData.append("method",'addGame');
    //inicializando ajax
    $.ajax({
        method: "POST",
        //seteando metodo a utilizar en controlador y seteando la data
        data: formData,
        contentType: false,
        processData: false,
        //url (?
        url: "../http/controllers/GameController.php",
        success: function(result) {
            var output = result.split("|");
            if (output[0] == "Éxito") {
                //si la operacion fue un exito, cerramos el modal
                $('#nuevoJuego').modal('close');
                //refrescamos la pagina
                attach("main", 1);
            }
            console.log(result);
            swal({title: output[0], text: output[1], icon: output[2], button: 'Aceptar', closeOnClickOutside: false, closeOnEsc: false})
        }
    });
});