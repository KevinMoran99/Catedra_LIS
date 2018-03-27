//AJAX de agregar storepage
$( "#frmStrPg" ).submit(function( event ) {
    event.preventDefault();
    var formData = new FormData(this);
    formData.append("game",$("#gameId").val());
    formData.append("method",'addPage');
    //inicializando ajax
    $.ajax({
        method: "POST",
        //seteando metodo a utilizar en controlador y seteando la data
        data: formData,
        contentType: false,
        processData: false,
        //url (?
        url: "../http/controllers/StorePageController.php",
        success: function(result) {
            var output = result.split("|");
            if (output[0] == "Éxito") {
                //si la operacion fue un exito, cerramos el modal
                $('#storePageModal').modal('close');
                //refrescamos la pagina
                attach("main", 1);
            }
            console.log(result);
            swal({title: output[0], text: output[1], icon: output[2], button: 'Aceptar', closeOnClickOutside: false, closeOnEsc: false})
        }
    });
});

//AJAX de modificar storepage
$( "#frmStrPgU" ).submit(function( event ) {
    event.preventDefault();

    var formData = new FormData(this);
    formData.append("method","updatePage");
    formData.append("id",$(".id").val());
    //Mensaje de confirmacion
    swal({
        title: '¿Desea modificar con los datos especificados?',
        icon: 'warning',
        buttons: ['Cancelar', 'Modificar']
    }).then(function (confirm) {
        if (confirm) {
            //Haciendo submit via ajax
            $.ajax({
                method: "POST",
                //seteamos el metodo a utilizar en el controlador y la data
                data: formData,
                contentType: false,
                processData: false,
                url: "../http/controllers/StorePageController.php",
                success: function (result) {
                    var output = result.split("|");
                    if (output[0] == "Éxito") {
                        //si la operacion fue un exito, cerramos el modal
                        $('#actualizarSpec').modal('close');
                        //refrescamos la pagina
                        attach("main", 1);
                    }
                    console.log(result);
                    swal({
                        title: output[0],
                        text: output[1],
                        icon: output[2],
                        button: 'Aceptar',
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    })
                }
            });
        }
    });
});

$("table").on('click', ".edit", function () {
    //obtenemos el id (OJO AGREGAR CLASE ID A TODOS LOS CAMPOS DE LAS TABLAS QUE ALMACENAN EL ID)
    var id = $(this).closest("tr").find(".id").text();
    var formData = new FormData();
    formData.append("method",'getPage');
    formData.append('id',id.toString());
    $.ajax({
        method: "POST",
        //seteando id y metodo a utilizar en el controlador
        data: formData,
        contentType: false,
        processData: false,
        url: "../http/controllers/StorePageController.php",
        success: function(result) {
            console.log(result)
            //parseamos el resultado a json
            var $data = jQuery.parseJSON(result);

            //seteamos los datos en la vista
            $("#gameDateU").val($data.releaseDate);
            $("#gamePriceU").val($data.price);
            $("#gameDiscU").val($data.discount);
            console.log("visible"+$data.visible);
            if($data.visible==="1"){
                $("#gameVis").prop("checked", true);
            }else{
                $("#gameInv").prop("checked", true);
            }

            //seteamos el id (OJO AGEREGAR INPUT TYPE HIDDEN PARA ALMACENAR EL ID)
            $("#pageId").val($data.id);
            //al setear todos los datos abrimos el modal
            $("#storePageModalU").modal('open');
        }
    });
});

$('#modPageButton').click(function () {
    var itemId = $("#gameId").val();
    $.ajax({
        method: 'POST',
        data: {'game' : itemId, 'method' : 'getPagesByGame'},
        url: "../http/controllers/StorePageController.php",
        success: function (result) {

            console.log(itemId);
            $data = jQuery.parseJSON(result);            
            //Obteniendo id con los items

            $('#allStorePages').empty();
            for(var i = 0; i < $data.length; i++) {
                $('#allStorePages').append(
                    '<tr>'+
                    '<td class="id" style=\"visibility: hidden; display:none;\">'+$data[i].id+'</td>'+
                    '<td>'+$data[i].releaseDate+'</td>'+
                    '<td>'+$data[i].price+'</td>'+
                    '<td>'+$data[i].discount+'</td>'+
                    '<td>'+
                        '<label>'+
                            '<input type=\"checkbox\" disabled '+$data[i].visible+"' />'"+
                            '<span></span>'+
                         '</label>'+
                    '</td>'+
                    '<td>'+
                        '<a  href="#storePageModalU" class=\"edit modal-trigger\">'+
                             '<i class="material-icons tooltipped editar" data-position=\"left\" data-delay=\"50\">mode_edit</i>'+
                         '</a>'+
                     '</td>'+
                     '<td>'+
                        '<a  href="#storePageSpecs" class=\"modal-trigger\">'+
                             '<i class="material-icons tooltipped editar" onclick="setId('+$data[i].id+')" data-position=\"left\" data-delay=\"50\">settings</i>'+
                         '</a>'+
                     '</td>'+
                '</tr>'
                )
            }
        }
            });

        });



