var pageId;
function setId(id) {
    pageId = id;
}

//AJAX DE AGREGAR REGISTRO
$( "#frmStorePageSpecAdd" ).submit(function( event ) {
    event.preventDefault();

    var formData = new FormData(this);
    formData.append("method","addPageSpec");
    formData.append("storePage",pageId);
    //inicializando ajax
    $.ajax({
        method: "POST",
        //seteando metodo a utilizar en controlador y seteando la data
        data: formData,
        contentType: false,
        processData: false,
        url: "../http/controllers/PageSpecController.php",
        success: function(result) {
            var output = result.split("|");
            if (output[0] == "Éxito") {
                //si la operacion fue un exito, cerramos el modal
                $('#StorePageSpecAdd').modal('close');
            }
            console.log(result);
            swal({title: output[0], text: output[1], icon: output[2], button: 'Aceptar', closeOnClickOutside: false, closeOnEsc: false})
        }
    });
});
