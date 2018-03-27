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

//AJAX DE OBTENER TODOS LOS REGISTROS
$('#pageSpecButton').click(function () {
    var itemId = pageId;
        $.ajax({
            method: 'POST',
            data: {'page' : itemId, 'method' : 'getSpecsByPage'},
            url: "../http/controllers/PageSpecController.php",
            success: function (itemId) {
                console.log(result);
                    $data = jQuery.parseJSON(result);            
                    //Obteniendo id con los items
        
                    $('#allPageSpecs').empty();
                    for(var i = 0; i < $data.length; i++) {
                        $('#allPageSpecs').append(
                            '<tr>'+
                            '<td class="id" style=\"visibility: hidden; display:none;\">'+$data[i].id+'</td>'+
                            '<td>'+$data[i].pageSpec+'</td>'+
                             '<td>'+
                                '<a id="eliminarSpec" href="#">'+
                                     '<i class="material-icons tooltipped editar" data-position=\"left\" data-delay=\"50\">delete</i>'+
                                 '</a>'+
                             '</td>'+
                        '</tr>'
                        )
                    }
                }
    });
        
});