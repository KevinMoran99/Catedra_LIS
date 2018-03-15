$(document).ready(function() {
    $('.modal').modal();
    $('.formSelect').each(function(index, element) {
        $(this).select2();
    });
});

//AJAX DE AGREGAR REGISTRO
$( "#frmUser" ).submit(function( event ) {
    event.preventDefault();

    var formData = new FormData(this);
    formData.append("method","addUser");
    //inicializando ajax
    $.ajax({
        method: "POST",
        //seteando metodo a utilizar en controlador y seteando la data
        data: formData,
        contentType: false,
        processData: false,
        url: "../http/controllers/UserController.php",
        success: function(result) {
            var output = result.split("|");
            if (output[0] == "Éxito") {
                //si la operacion fue un exito, cerramos el modal
                $('#nuevoUsuario').modal('close');
                //refrescamos la pagina
                attach("user", 1);
            }
            console.log(result);
            swal({title: output[0], text: output[1], icon: output[2], button: 'Aceptar', closeOnClickOutside: false, closeOnEsc: false})
        }
    });
});


//AJAX DE ACTUALIZAR REGISTRO
$( "#frmUserUpdate" ).submit(function( event ) {
    event.preventDefault();

    var formData = new FormData(this);
    formData.append("method","updateUser");
    $.ajax({
        method: "POST",
        //seteamos el metodo a utilizar en el controlador y la data
        data: formData,
        contentType: false,
        processData: false,
        url: "../http/controllers/UserController.php",
        success: function(result) {
            var output = result.split("|");
            if (output[0] == "Éxito") {
                //si la operacion fue un exito, cerramos el modal
                $('#actualizarUsuario').modal('close');
                //refrescamos la pagina
                attach("user", 1);
            }
            swal({title: output[0], text: output[1], icon: output[2], button: 'Aceptar', closeOnClickOutside: false, closeOnEsc: false})
        }
    });
});


//AL HACER CLICK EN "EDITAR" SOBRE UN REGISTRO, LOS DATOS DE ESE REGISTRO SE PASAN AL MODAL DE ACTUALIZAR
$("table").on('click', ".edit", function () {
    //obtenemos el id (OJO AGREGAR CLASE ID A TODOS LOS CAMPOS DE LAS TABLAS QUE ALMACENAN EL ID)
    var id = $(this).closest("tr").find(".id").text();

    var formData = new FormData();
    formData.append("id",id);
    formData.append("method","getUser");
    $.ajax({
        method: "POST",
        //seteando id y metodo a utilizar en el controlador
        data: formData,
        contentType: false,
        processData: false,
        url: "../http/controllers/UserController.php",
        success: function(result) {
            //parseamos el resultado a json
            var $data = jQuery.parseJSON(result);

            //seteamos los datos en la vista
            $("#userAliasU").val($data.alias);
            $("#userEmailU").val($data.email);

            $("#userTypeU").val($data.userType);
            $("#userTypeU").select2();

            if($data.state==="1"){
                $("#userStateA").prop("checked", true);
            }else{
                $("#userStateI").prop("checked", true);
            }

            //seteamos el id (OJO AGEREGAR INPUT TYPE HIDDEN PARA ALMACENAR EL ID)
            $("#userId").val($data.id);
            //Hacemos que la animacion del label se triggeree
            $("#userAliasLabelU").addClass('active');
            $("#userEmailLabelU").addClass('active');
            //al setear todos los datos abrimos el modal
            $("#actualizarUser").modal('open');
        }
    });
});


/*METODO PARA BUSCAR*/
$("#user-search").keypress( function (e) {
    //validacion para verificar si presiono enter
    if(e.which==13){

        var formData = new FormData();
        formData.append("param",$("#user-search").val());
        formData.append("method","searchUser");
        //inicializando ajax
        $.ajax({
            method: "POST",
            //seteando metodo a utilizar en controlador y seteando la data
            data: formData,
            contentType: false,
            processData: false,
            url: "../http/controllers/UserController.php",
            success: function(result) {
                //limpiando cuerpo de tabla
                $("#allUsers").empty();
                //limpiando los links de paginacion
                $("#userLinks").empty();
                //parseando resultado a json
                var $data = jQuery.parseJSON(result);

                //generando un row por registro
                for(var i=0;i<$data.length;i++){

                    var $checked = "";
                    if($data[i].state==1){
                        $checked = "checked";
                    }

                    $("#allUsers").append("<tr>" +
                        "<td  class='id' style=\"visibility: hidden; display:none;\">"+$data[i].id+"</td>" +
                        "<td>"+$data[i].alias+"</td>" +
                        "<td>"+$data[i].email+"</td>" +
                        "<td>"+$data[i].userType+"</td>" +
                        "<td>" +
                        "<label>" +
                        "<input type=\"checkbox\" disabled " + $checked + ">" +
                        "<span></span>" +
                        "</label>" +
                        "</td>" +
                        "<td>" +
                        "<a href='#actualizarUser' class='edit modal-trigger'>" +
                        "<i class='material-icons tooltipped editar' data-position='left' data-delay='50' data-tooltip='Editar'>mode_edit</i>" +
                        "</a>" +
                        "</td>");
                }
            }
        });
    }
});


$("#revert").click(function () {
    $("#allUsers").empty();
    $("#userLinks").empty();
    attach("user", 1);
});
