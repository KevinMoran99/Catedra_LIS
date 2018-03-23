$(document).ready(function() {
    $('.modal').modal();
});

//AJAX DE AGREGAR REGISTRO
$( "#frmFaq" ).submit(function( event ) {
    event.preventDefault();

    var formData = new FormData(this);
    formData.append("method","addFaq");
    //inicializando ajax
    $.ajax({
        method: "POST",
        //seteando metodo a utilizar en controlador y seteando la data
        data: formData,
        contentType: false,
        processData: false,
        url: "../http/controllers/FaqController.php",
        success: function(result) {
            var output = result.split("|");
            if (output[0] == "Éxito") {
                //si la operacion fue un exito, cerramos el modal
                $('#nuevaFaq').modal('close');
                //refrescamos la pagina
                attach("support", 1);
            }
            console.log(result);
            swal({title: output[0], text: output[1], icon: output[2], button: 'Aceptar', closeOnClickOutside: false, closeOnEsc: false})
        }
    });
});


//AJAX DE ACTUALIZAR REGISTRO
$( "#frmFaqUpdate" ).submit(function( event ) {
    event.preventDefault();

    var formData = new FormData(this);
    formData.append("method","updateFaq");

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
                url: "../http/controllers/FaqController.php",
                success: function (result) {
                    var output = result.split("|");
                    if (output[0] == "Éxito") {
                        //si la operacion fue un exito, cerramos el modal
                        $('#actualizarFaq').modal('close');
                        //refrescamos la pagina
                        attach("support", 1);
                    }

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
    formData.append("method","getFaq");
    $.ajax({
        method: "POST",
        //seteando id y metodo a utilizar en el controlador
        data: formData,
        contentType: false,
        processData: false,
        url: "../http/controllers/FaqController.php",
        success: function(result) {
            //parseamos el resultado a json
            var $data = jQuery.parseJSON(result);

            //seteamos los datos en la vista
            $("#faqTitleU").val($data.title);
            $("#faqDescriptionU").val($data.description);
            M.textareaAutoResize($("#faqDescriptionU"));

            if($data.state==="1"){
                $("#faqStateA").prop("checked", true);
            }else{
                $("#faqStateI").prop("checked", true);
            }

            //seteamos el id (OJO AGEREGAR INPUT TYPE HIDDEN PARA ALMACENAR EL ID)
            $("#faqId").val($data.id);
            //Hacemos que la animacion del label se triggeree
            $("#faqTitleLabelU").addClass('active');
            $("#faqDescriptionLabelU").addClass('active');
            //al setear todos los datos abrimos el modal
            $("#actualizarFaq").modal('open');
        }
    });
});

/*METODO PARA BUSCAR*/
$("#faq-search").keypress( function (e) {
    //validacion para verificar si presiono enter
    if(e.which==13){

        var formData = new FormData();
        formData.append("param",$("#faq-search").val());
        formData.append("method","searchFaq");
        //inicializando ajax
        $.ajax({
            method: "POST",
            //seteando metodo a utilizar en controlador y seteando la data
            data: formData,
            contentType: false,
            processData: false,
            url: "../http/controllers/FaqController.php",
            success: function(result) {
                //limpiando cuerpo de tabla
                $("#allFaqs").empty();
                //limpiando los links de paginacion
                $("#faqLinks").empty();
                //parseando resultado a json
                var $data = jQuery.parseJSON(result);

                //generando un row por registro
                for(var i=0;i<$data.length;i++){

                    var $checked = "";
                    if($data[i].state==1){
                        $checked = "checked";
                    }

                    $("#allFaqs").append("<tr>" +
                        "<td  class='id' style=\"visibility: hidden; display:none;\">"+$data[i].id+"</td>" +
                        "<td>"+$data[i].title+"</td>" +
                        "<td>"+$data[i].description+"</td>" +
                        "<td>" +
                        "<label>" +
                        "<input type=\"checkbox\" disabled " + $checked + ">" +
                        "<span></span>" +
                        "</label>" +
                        "</td>" +
                        "<td>" +
                        "<a href='#actualizarFaq' class='edit modal-trigger'>" +
                        "<i class='material-icons tooltipped editar' data-position='left' data-delay='50' data-tooltip='Editar'>mode_edit</i>" +
                        "</a>" +
                        "</td>");
                }
            }
        });
    }
});

$("#revert").click(function () {
    $("#allFaqs").empty();
    $("#faqLinks").empty();
    attach("support", 1);
});