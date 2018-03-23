$(document).ready(function() {
    $('.modal').modal();
});


//AJAX DE AGREGAR REGISTRO
$( "#frmGenero" ).submit(function( event ) {
    event.preventDefault();

    var formData = new FormData(this);
    formData.append("method",'addGenre');
    //inicializando ajax
    $.ajax({
        method: "POST",
        //seteando metodo a utilizar en controlador y seteando la data
        data: formData,
        contentType: false,
        processData: false,
        //url (?
        url: "../http/controllers/GenreController.php",
        success: function(result) {
            var output = result.split("|");
            if (output[0] == "Éxito") {
                //si la operacion fue un exito, cerramos el modal
                $('#nuevoGenero').modal('close');
                //refrescamos la pagina
                attach("genre", 1);
            }
            console.log(result);
            swal({title: output[0], text: output[1], icon: output[2], button: 'Aceptar', closeOnClickOutside: false, closeOnEsc: false})
        }
    });
});


//AJAX DE ACTUALIZAR REGISTRO
$( "#frmGeneroUpdate" ).submit(function( event ) {
    event.preventDefault();

    var formData = new FormData(this);
    formData.append("method",'updateGenre');

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
                url: "../http/controllers/GenreController.php",
                success: function (result) {
                    var output = result.split("|");
                    if (output[0] == "Éxito") {
                        //si la operacion fue un exito, cerramos el modal
                        $('#actualizarGenero').modal('close');
                        //refrescamos la pagina
                        attach("genre", 1);
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
    console.log(id);
    var formData = new FormData();
    formData.append("method",'getGenre');
    formData.append('id',id.toString());
    $.ajax({
        method: "POST",
        //seteando id y metodo a utilizar en el controlador
        data: formData,
        contentType: false,
        processData: false,
        url: "../http/controllers/GenreController.php",
        success: function(result) {
            //parseamos el resultado a json
            var $data = jQuery.parseJSON(result);

            //seteamos los datos en la vista
            $("#genreNameU").val($data.name);
            console.log("state"+$data.state);
            if($data.state==="1"){
                $("#genreStateA").prop("checked", true);
            }else{
                $("#genreStateI").prop("checked", true);
            }

            //seteamos el id (OJO AGEREGAR INPUT TYPE HIDDEN PARA ALMACENAR EL ID)
            $("#genreId").val($data.id);
            //al setear todos los datos abrimos el modal
            $("#actualizarGenero").modal('open');
        }
    });
});

/*METODO PARA BUSCAR*/
$("#genre-search").keypress( function (e) {
    //validacion para verificar si presiono enter
    if(e.which==13){
        var formData = new FormData();
        formData.append("method",'searchGenre');
        formData.append("param",$(this).val().toString());
        //inicializando ajax
        $.ajax({
            method: "POST",
            //seteando metodo a utilizar en controlador y seteando la data
            data: formData,
            contentType: false,
            processData: false,
            //url (?
            url: "../http/controllers/GenreController.php",
            success: function(result) {
                //limpiando cuerpo de tabla
                $("#allGenres").empty();
                //limpiando los links de paginacion
                $("#genreLinks").empty();
                //parseando resultado a json
                var $data = jQuery.parseJSON(result);

                //generando un row por registro
                for(var i=0;i<$data.length;i++){
                    console.log($data[i].name);
                    var checked ="";
                    if($data[i].state ==1){
                        checked="checked";
                    }
                    $("#allGenres").append("<tr>" +
                        "<td  class='id' style=\"visibility: hidden; display:none;\">"+$data[i].id+"</td>" +
                        "<td>"+$data[i].name+"</td>" +
                        "<td>"+
                        "<label>" +
                        "<input type=\"checkbox\" disabled "+checked+" />" +
                        "<span></span>\n" +
                        "</label>"+
                        "</td>"+
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
    $("#allGenres").empty();
    $("#genreLinks").empty();
    attach("genre", 1);
});