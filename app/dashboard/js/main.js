$(document).ready(function () {
    $('.modal').modal();
    $('#game-filter').select2();
    $('.formSelect').each(function(index, element) {
        $(this).select2();
    });

});

//AJAX DE AGREGAR REGISTRO
$( "#frmRegJg" ).submit(function( event ) {
    event.preventDefault();
    var formData = new FormData(this);
    var files = $('#image').prop('files')[0];
    formData.append('cover',files);
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


//AJAX DE ACTUALIZAR REGISTRO
$( "#frmActJg" ).submit(function( event ) {
    event.preventDefault();

    var formData = new FormData(this);
    formData.append("method","updateGame");

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
                url: "../http/controllers/GameController.php",
                success: function (result) {
                    var output = result.split("|");
                    if (output[0] == "Éxito") {
                        //si la operacion fue un exito, cerramos el modal
                        $('#actualizarJuego').modal('close');
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


//AL HACER CLICK EN "EDITAR" SOBRE UN REGISTRO, LOS DATOS DE ESE REGISTRO SE PASAN AL MODAL DE ACTUALIZAR
$(".edit").on('click', function () {
    //obtenemos el id (OJO AGREGAR CLASE ID A TODOS LOS CAMPOS DE LAS TABLAS QUE ALMACENAN EL ID)
    var id = $(this).find(".id").text();

    var formData = new FormData();
    formData.append("id",id);
    formData.append("method","getGame");
    $.ajax({
        method: "POST",
        //seteando id y metodo a utilizar en el controlador
        data: formData,
        contentType: false,
        processData: false,
        url: "../http/controllers/GameController.php",
        success: function(result) {
            //parseamos el resultado a json
            var $data = jQuery.parseJSON(result);

            //seteamos los datos en la vista
            $("#gameNameU").val($data.name);
            $("#gameDesc").val($data.description);
            M.textareaAutoResize($("#gameDesc"));

            $("#EsrbSelectU").val($data.esrb);
            $("#EsrbSelectU").select2();

            $("#genreSelectU").val($data.genre);
            $("#genreSelectU").select2();

            $("#platformSelectU").val($data.platform);
            $("#platformSelectU").select2();

            $("#publisherSelectU").val($data.publisher);
            $("#publisherSelectU").select2();

            if($data.state==="1"){
                $("#gameStateActU").prop("checked", true);
            }else{
                $("#gameStateIncU").prop("checked", true);
            }

            //seteamos el id (OJO AGEREGAR INPUT TYPE HIDDEN PARA ALMACENAR EL ID)
            $("#gameId").val($data.id);
            //Hacemos que la animacion del label se triggeree
            $("#gameNameLabelU").addClass('active');
            $("#gameDescLabelU").addClass('active');
            //al setear todos los datos abrimos el modal
            $("#actualizarJuego").modal('open');
        }
    });
});


/*METODO PARA BUSCAR*/
$("#game-search").keypress( function (e) {
    //validacion para verificar si presiono enter
    if(e.which==13){

        var formData = new FormData();
        formData.append("param",$("#game-search").val());
        formData.append("method","searchGame");
        //inicializando ajax
        $.ajax({
            method: "POST",
            //seteando metodo a utilizar en controlador y seteando la data
            data: formData,
            contentType: false,
            processData: false,
            url: "../http/controllers/GameController.php",
            success: function(result) {
                //limpiando cuerpo de tabla
                $("#allGames").empty();
                //limpiando los links de paginacion
                $("#gameLinks").empty();
                //parseando resultado a json
                var $data = jQuery.parseJSON(result);

                //generando un row por registro
                for(var i=0;i<$data.length;i++){

                    var $checked = "";
                    if($data[i].state==1){
                        $checked = "checked";
                    }

                    $("#allGames").append("<div class='col s6 m3 l3'>"+
                    "<a class='modal-trigger edit' href='#actualizarJuego'>"+
                        "<div class='card'>"+
                            "<div class='card-image'>"+
                                "<img src='"+substr($data[i].cover,3)+"'>"+
                                "<span class='card-title'>'"+$data[i].name()+"'</span>"+
                                "<span id='gameId' class='id' style='visibility: hidden; display:none;'>'"+$row[i].id()+"</span>"+
                            "</div>"+
                        "</div>"+
                    "</a>"+
                "</div>");
                }
            }
        });
    }
});


$("#revert").click(function () {
    $("#allGames").empty();
    $("#gameLinks").empty();
    attach("main", 1);
});