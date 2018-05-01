$(document).ready(function() {
    $('.modal').modal();
});

//AJAX DE AGREGAR REGISTRO
$( "#frmRegTypeUse").submit(function( event ) {
    event.preventDefault();
    var formData = new FormData(this);
    formData.append("method",'addUserType');
    //inicializando ajax
    $.ajax({
        method: "POST",
        //seteando metodo a utilizar en controlador y seteando la data
        data: formData,
        contentType: false,
        processData: false,
        //url (?
        url: "../http/controllers/UserTypeController.php",
        success: function(result) {
            var output = result.split("|");
            if (output[0] == "Éxito") {
                //si la operacion fue un exito, cerramos el modal
                $('#nuevoTipoUsuario').modal('close');
                //refrescamos la pagina
                attach("userType", 1);
            }
            console.log(result);
            swal({title: output[0], text: output[1], icon: output[2], button: 'Aceptar', closeOnClickOutside: false, closeOnEsc: false})
        }
    });
});

//AJAX DE ACTUALIZAR REGISTRO
$( "#frmUpdateRegTypeUse" ).submit(function( event ) {
    event.preventDefault();
    var formData = new FormData(this);
    formData.append("method", 'updateUserType');
    //Mensaje de confirmacion
    swal({
        title: '¿Desea modificar con los datos especificados?',
        icon: 'warning',
        buttons: ['Cancelar', 'Modificar']
    }).then(function (confirm) {
        if(confirm) {
            //Haciendo submit via ajax
            $.ajax({
                method: "POST",
                //seteamos el metodo a utilizar en el controlador y la data
                data: formData,
                contentType: false,
                processData: false,
                url: "../http/controllers/UserTypeController.php",
                success: function (result) {
                    var output = result.split("|");
                    if (output[0] == "Éxito") {
                        //si la operacion fue un exito, cerramos el modal
                        $('#actualizarTipoUsuario').modal('close');
                        //refrescamos la pagina
                        attach("userType", 1);
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


/*SE SUSTITUYO METODO ANTERIOR POR ESTE PARA SOPORTAR LOS ELEMENTOS AGREGADOS DE MANERA DINAMICA*/
$("table").on('click', ".edit", function () {
    console.log("entra");
    //obtenemos el id (OJO AGREGAR CLASE ID A TODOS LOS CAMPOS DE LAS TABLAS QUE ALMACENAN EL ID)
    var id = $(this).closest("tr").find(".id").text();
    var formData = new FormData();
    formData.append("method",'getUserType');
    formData.append("id",id.toString());
    $.ajax({
        method: "POST",
        //seteando id y metodo a utilizar en el controlador
        data: formData,
        contentType: false,
        processData: false,
        url: "../http/controllers/UserTypeController.php",
        success: function(result) {
            //parseamos el resultado a json
            var $data = jQuery.parseJSON(result);

            //seteamos los datos en la vista
            $("#userTypeUName").val($data.name);
            console.log("state"+$data.state);

            if($data.state=="1"){
                $("#userTypeStateA").prop("checked", true);
            }else{
                $("#userTypeStateI").prop("checked", false);
            }


            if($data.games==="1"){
                $("#userTypeGames").prop("checked", true);
            }
            else
            {
                $("#userTypeGames").prop("checked", false);
            }

            if($data.users==="1"){
                $("#userTypeUsers").prop("checked", true);
            }
            else
            {
                $("#userTypeUsers").prop("checked", false);
            }
            if($data.support==="1"){
                $("#userTypeSupp").prop("checked", true);
            }
            else
            {
                $("#userTypeSupp").prop("checked", false);
            }
            if($data.stadistics==="1"){
                $("#userTypeStats").prop("checked", true);
            }
            else
            {
                $("#userTypeStats").prop("checked", false);
            }
            if($data.reviews==="1"){
                $("#userTypeReview").prop("checked", true);
            }
            else
            {
                $("#userTypeReview").prop("checked", false);
            }
            if($data.esrbs==="1"){
                $("#userTypeEsrb").prop("checked", true);
            }
            else
            {
                $("#userTypeEsrb").prop("checked", false);
            }
            if($data.publishers==="1"){
                $("#userTypePublish").prop("checked", true);
            }
            else
            {
                $("#userTypePublish").prop("checked", false);
            }
            if($data.genres==="1"){
                $("#userTypeGenre").prop("checked", true);
            }
            else
            {
                $("#userTypeGenre").prop("checked", false);
            }
            if($data.specs==="1"){
                $("#userTypeSpecs").prop("checked", true);
            }
            else
            {
                $("#userTypeSpecs").prop("checked", false);
            }
            if($data.typeSpecs==="1"){
                $("#userTypeTypeSpecs").prop("checked", true);
            }
            else
            {
                $("#userTypeTypeSpecs").prop("checked", false);
            }
            if($data.userTypes==="1"){
                $("#userTypeUserType").prop("checked", true);
            }
            else
            {
                $("#userTypeUserType").prop("checked", false);
            }
            

            //seteamos el id (OJO AGEREGAR INPUT TYPE HIDDEN PARA ALMACENAR EL ID)
            $("#userTypeId").val($data.id);
            //al setear todos los datos abrimos el modal
            $("#actualizarTipoUsuario").modal('open');
        }
    });
});

/*METODO PARA BUSCAR*/
$("#userType-search").keypress( function (e) {
    //validacion para verificar si presiono enter
    if(e.which==13){
        var formData = new FormData();
        formData.append("method",'searchUserType');
        formData.append("param", $(this).val().toString());
        //inicializando ajax
        $.ajax({
            method: "POST",
            //seteando metodo a utilizar en controlador y seteando la data
            data: formData,
            contentType: false,
            processData: false,
            //url (?
            url: "../http/controllers/UserTypeController.php",
            success: function(result) {
                //limpiando cuerpo de tabla
                $("#allUserType").empty();
                //limpiando los links de paginacion
                $("#userTypeLinks").empty();
                //parseando resultado a json
                var $data = jQuery.parseJSON(result);

                //generando un row por registro
                for(var i=0;i<$data.length;i++){
                    var checked ="";
                    if($data[i].state ==1){
                        checked="checked";
                    }
                    console.log($data[i].name);
                    $("#allUserType").append("<tr>" +
                        "<td  class='id' style=\"visibility: hidden; display:none;\">"+$data[i].id+"</td>" +
                        "<td>"+$data[i].name+"</td>" +
                        "<td>"+
                        "<label>" +
                        "<input type=\"checkbox\" disabled "+checked+" />" +
                        "<span></span>\n" +
                        "</label>"+
                        "</td>"+
                        "<td>" +
                        "<a href='#actualizarTipoUsuario' class='edit modal-trigger'>" +
                        "<i class='material-icons tooltipped editar' data-position='left' data-delay='50' data-tooltip='Editar'>mode_edit</i>" +
                        "</a>" +
                        "</td>");
                }
            }
        });
    }
});

$("#revert").click(function () {
    $("#allUserType").empty();
    $("#userTypeLinks").empty();
    attach("userType", 1);
});