$(document).ready(function() {
    $('.modal').modal();
});


//AJAX DE AGREGAR REGISTRO
$( "#frmPublisher" ).submit(function( event ) {
    event.preventDefault();
    console.log($(this).serialize());
    //inicializando ajax
    $.ajax({
        method: "POST",
        //seteando metodo a utilizar en controlador y seteando la data
        data: {
            "publisher": $(this).serialize(),
            "method":"addPublisher"
        },
        //url (?
        url: "../http/controllers/PublisherController.php",
        success: function(result) {
            var output = result.split("|");
            if (output[0] == "Éxito") {
                //si la operacion fue un exito, cerramos el modal
                $('#nuevoPublicador').modal('close');
                //refrescamos la pagina
                attach("publisher", 1);
            }
            console.log(result);
            swal({title: output[0], text: output[1], icon: output[2], button: 'Aceptar', closeOnClickOutside: false, closeOnEsc: false})
        }
    });
});


//AJAX DE ACTUALIZAR REGISTRO
$( "#frmUpdatePublisher" ).submit(function( event ) {
    event.preventDefault();
    console.log($(this).serialize());
    $.ajax({
        method: "POST",
        //seteamos el metodo a utilizar en el controlador y la data
        data: {
            "publisher": $(this).serialize(),
            "method":"updatePublisher"
        },
        url: "../http/controllers/PublisherController.php",
        success: function(result) {
            var output = result.split("|");
            if (output[0] == "Éxito") {
                //si la operacion fue un exito, cerramos el modal
                $('#actualizarPublicador').modal('close');
                //refrescamos la pagina
                attach("publisher", 1);
            }
            console.log(result);
            swal({title: output[0], text: output[1], icon: output[2], button: 'Aceptar', closeOnClickOutside: false, closeOnEsc: false})
        }
    });
});


/*SE SUSTITUYO METODO ANTERIOR POR ESTE PARA SOPORTAR LOS ELEMENTOS AGREGADOS DE MANERA DINAMICA*/
$("table").on('click', ".edit", function () {
    console.log("entra");
    //obtenemos el id (OJO AGREGAR CLASE ID A TODOS LOS CAMPOS DE LAS TABLAS QUE ALMACENAN EL ID)
    var id = $(this).closest("tr").find(".id").text();
    console.log(id);
    $.ajax({
        method: "POST",
        //seteando id y metodo a utilizar en el controlador
        data: {
            "id": id,
            "method":"getPublisher"
        },
        url: "../http/controllers/PublisherController.php",
        success: function(result) {
            //parseamos el resultado a json
            var $data = jQuery.parseJSON(result);

            //seteamos los datos en la vista
            $("#publisherUName").val($data.name);
            console.log("state"+$data.state);
            if($data.state==="1"){
                $("#publisherStateA").prop("checked", true);
            }else{
                $("#publisherStateI").prop("checked", true);
            }

            //seteamos el id (OJO AGEREGAR INPUT TYPE HIDDEN PARA ALMACENAR EL ID)
            $("#publisherId").val($data.id);
            //al setear todos los datos abrimos el modal
            $("#actualizarPublicador").modal('open');
        }
    });
});

/*METODO PARA BUSCAR*/
$("#publisher-search").keypress( function (e) {
    //validacion para verificar si presiono enter
    if(e.which==13){

        //inicializando ajax
        $.ajax({
            method: "POST",
            //seteando metodo a utilizar en controlador y seteando la data
            data: {
                "param": $("#publisher-search").val(),
                "method":"searchPublisher"
            },
            //url (?
            url: "../http/controllers/PublisherController.php",
            success: function(result) {
                console.log(result)
                //limpiando cuerpo de tabla
                $("#allPublishers").empty();
                //limpiando los links de paginacion
                $("#publisherLinks").empty();
                //parseando resultado a json
                var $data = jQuery.parseJSON(result);

                //generando un row por registro
                for(var i=0;i<$data.length;i++){
                    console.log($data[i].name);
                    $("#allPublishers").append("<tr>" +
                        "<td  class='id' style=\"visibility: hidden; display:none;\">"+$data[i].id+"</td>" +
                        "<td>"+$data[i].name+"</td>" +
                        "<td>" +
                        "<a href='#actualizarGenero' class='edit modal-trigger'>" +
                        "<i class='material-icons tooltipped editar' data-position='left' data-delay='50' data-tooltip='Editar'>mode_edit</i>" +
                        "</a>" +
                        "</td>");
                }
            }
        });
    }
});

$("#revert").click(function () {
    $("#allPublishers").empty();
    $("#publisherLinks").empty();
    attach("publisher", 1);
});