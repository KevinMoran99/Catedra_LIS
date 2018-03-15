$(document).ready(function() {
    $('.modal').modal();
});


//AJAX DE AGREGAR REGISTRO
$( "#frmTipoSpec" ).submit(function( event ) {
    event.preventDefault();

    var formData = new FormData(this);
    formData.append("method","addTypeSpec");
    //inicializando ajax
    $.ajax({
        method: "POST",
        //seteando metodo a utilizar en controlador y seteando la data
        data: formData,
        contentType: false,
        processData: false,
        url: "../http/controllers/TypeSpecController.php",
        success: function(result) {
            var output = result.split("|");
            if (output[0] == "Éxito") {
                //si la operacion fue un exito, cerramos el modal
                $('#nuevoTipoSpec').modal('close');
                //refrescamos la pagina
                attach("typeSpec", 1);
            }
            console.log(result);
            swal({title: output[0], text: output[1], icon: output[2], button: 'Aceptar', closeOnClickOutside: false, closeOnEsc: false})
        }
    });
});

//AJAX DE ACTUALIZAR REGISTRO
$( "#frmTipoSpecUpdate" ).submit(function( event ) {
    event.preventDefault();

    var formData = new FormData(this);
    formData.append("method","updateTypeSpec");

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
                url: "../http/controllers/TypeSpecController.php",
                success: function (result) {
                    var output = result.split("|");
                    if (output[0] == "Éxito") {
                        //si la operacion fue un exito, cerramos el modal
                        $('#actualizarTipoSpec').modal('close');
                        //refrescamos la pagina
                        attach("typeSpec", 1);
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
$("table").on('click', ".edit", function () {
    //obtenemos el id (OJO AGREGAR CLASE ID A TODOS LOS CAMPOS DE LAS TABLAS QUE ALMACENAN EL ID)
    var id = $(this).closest("tr").find(".id").text();

    var formData = new FormData();
    formData.append("id",id);
    formData.append("method","getTypeSpec");
    $.ajax({
        method: "POST",
        //seteando id y metodo a utilizar en el controlador
        data: formData,
        contentType: false,
        processData: false,
        url: "../http/controllers/TypeSpecController.php",
        success: function(result) {
            //parseamos el resultado a json
            var $data = jQuery.parseJSON(result);

            //seteamos los datos en la vista
            $("#typeSpecNameU").val($data.name);
            console.log("state"+$data.state);
            if($data.state==="1"){
                $("#typeSpecStateA").prop("checked", true);
            }else{
                $("#typeSpecStateI").prop("checked", true);
            }

            //seteamos el id (OJO AGEREGAR INPUT TYPE HIDDEN PARA ALMACENAR EL ID)
            $("#typeSpecId").val($data.id);
            //Hacemos que la animacion del label se triggeree
            $("#typeSpecNameLabelU").addClass('active');
            //al setear todos los datos abrimos el modal
            $("#actualizarTipoSpec").modal('open');
        }
    });
});

/*METODO PARA BUSCAR*/
$("#typeSpec-search").keypress( function (e) {
    //validacion para verificar si presiono enter
    if(e.which==13){

        var formData = new FormData();
        formData.append("param",$("#typeSpec-search").val());
        formData.append("method","searchTypeSpec");
        //inicializando ajax
        $.ajax({
            method: "POST",
            //seteando metodo a utilizar en controlador y seteando la data
            data: formData,
            contentType: false,
            processData: false,
            url: "../http/controllers/TypeSpecController.php",
            success: function(result) {
                //limpiando cuerpo de tabla
                $("#allTypeSpecs").empty();
                //limpiando los links de paginacion
                $("#typeSpecLinks").empty();
                //parseando resultado a json
                var $data = jQuery.parseJSON(result);

                //generando un row por registro
                for(var i=0;i<$data.length;i++){

                    var $checked = "";
                    if($data[i].state==1){
                        $checked = "checked";
                    }

                    $("#allTypeSpecs").append("<tr>" +
                        "<td  class='id' style=\"visibility: hidden; display:none;\">"+$data[i].id+"</td>" +
                        "<td>"+$data[i].name+"</td>" +
                        "<td>" +
                        "<label>" +
                        "<input type=\"checkbox\" disabled " + $checked + ">" +
                        "<span></span>" +
                        "</label>" +
                        "</td>" +
                        "<td>" +
                        "<a href='#actualizarTipoSpec' class='edit modal-trigger'>" +
                        "<i class='material-icons tooltipped editar' data-position='left' data-delay='50' data-tooltip='Editar'>mode_edit</i>" +
                        "</a>" +
                        "</td>");
                }
            }
        });
    }
});

$("#revert").click(function () {
    $("#allTypeSpecs").empty();
    $("#typeSpecLinks").empty();
    attach("typeSpec", 1);
});