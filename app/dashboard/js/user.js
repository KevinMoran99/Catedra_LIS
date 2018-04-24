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
                url: "../http/controllers/UserController.php",
                success: function (result) {
                    var output = result.split("|");
                    if (output[0] == "Éxito") {
                        //si la operacion fue un exito, cerramos el modal
                        $('#actualizarUsuario').modal('close');
                        //refrescamos la pagina
                        attach("user", 1);
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

            $("#userTypeU").val($data.userType.id);
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
                        "<td class='alias'>"+$data[i].alias+"</td>" +
                        "<td>"+$data[i].email+"</td>" +
                        "<td>"+$data[i].userType.name+"</td>" +
                        "<td>" +
                        "<label>" +
                        "<input type=\"checkbox\" disabled " + $checked + ">" +
                        "<span></span>" +
                        "</label>" +
                        "</td>" +
                        "<td>" +
                        "<a href='#actualizarUsuario' class='edit modal-trigger'>" +
                        "<i class='material-icons tooltipped editar' data-position='left' data-delay='50' data-tooltip='Editar'>mode_edit</i>" +
                        "</a>" +
                        "</td>" +
                        "<td>" +
                        "<a href='#facturasUsuario' class='edit modal-trigger modalBillsTrigger'>" +
                        "<i class='material-icons tooltipped editar' data-position='left' data-delay='50'>local_atm</i>" +
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



//Mostrar facturas de usuario
$("table").on('click', '.modalBillsTrigger', function () {
    var id = $(this).closest("tr").find(".id").text();
    var alias = $(this).closest("tr").find(".alias").text();
    $.ajax({
        method: 'POST',
        data: {'user_id' : id, 'method' : 'getBillsByUser'},
        url: "../http/controllers/BillController.php",
        success: function (result) {
            var $data = jQuery.parseJSON(result);
            $('#billList').empty();

            //header de modal
            $('#facturasUsuario').find('h3').html("Facturas de " + alias);

            //Si el usuario no ha hecho facturas
            if ($data.length === 0) {
                $('#billList').append(
                    '<h5 class="center-align">Este usuario no tiene ninguna factura</h5>'
                );
            }

            //Si el usuario tiene facturas, las imprime
            else {
                for(var i = 0; i < $data.length; i++) {
                    $('#billList').append(
                        '<input type="hidden" value=' + $data[i].id + '/> ' +
                        '<a href="#modalBillItems" class="billBtn collection-item modal-trigger">COD#' + $data[i].id + ' - Fecha: ' + $data[i].bill_date + '</a>'
                    );
                }
            }

        }
    });
});

//Al hacer click en una de las facturas
$('#billList').on("click", "a", function () {
    var itemId = $(this).prev().val();
    $.ajax({
        method: 'POST',
        data: {'id' : itemId, 'method' : 'getBill'},
        url: "../http/controllers/BillController.php",
        success: function (result) {
            var $bill = jQuery.parseJSON(result);
            //Obteniendo id con los items
            $data = $bill.items;
            //Estableciendo header
            $('#modalBillItems').find('h3').html('COD#' + $bill.id + ' - Fecha: ' + $bill.bill_date);
            //Vaciando lista
            $('#billItemList').empty();
            //Total de gasto
            var total = 0;
            for(var i = 0; i < $data.length; i++) {
                total += $data[i].price - ($data[i].price * $data[i].discount / 100);

                $('#billItemList').append(
                    '<div class="row cardBillItem">' +
                    '<div class="col s12">' +
                    '<div class="card horizontal cart-card">' +
                    '<div class="card-image">' +
                    '<img class="responsive-img" src=' + (($data[i].storePage.game.cover).substring(3)).replace(" ", "%20") + '>' +
                    '</div>' +
                    '<div class="card-stacked">' +
                    '<div class="card-content">' +
                    '<h4>' + $data[i].storePage.game.name + '</h4>' +
                    '<div class="row">' +
                    '<div class="col s4 priceDetail">' +
                    '<label>Precio</label><br>' +
                    '<div class="chip green white-text">$' + $data[i].price + '</div>' +
                    '</div>' +
                    '<div class="col s4 priceDetail">' +
                    '<label>Descuento</label><br>' +
                    '<div class="chip red white-text">-' + $data[i].discount + '%</div>' +
                    '</div>' +
                    '<div class="col s4 priceDetail right-align">' +
                    '<label>Subtotal:</label><br>' +
                    '<div class="chip green white-text">$' + ($data[i].price - ($data[i].price * $data[i].discount / 100)).toFixed(2) + '</div>' +
                    '</div>' +
                    '</div>' +

                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>'
                );
            }

            $('#billItemList').next().find('h4').html("Total: $" + total.toFixed(2));
        }
    });
});


//Togglea la clase horizontal del card de las facturas dependiendo del ancho de la pantalla
$(function(){

    $(window).bind("resize",function(){
        if($(this).width() <500){
            $('.cardBillItem .card').removeClass('horizontal');
        }
        else{
            $('.cardBillItem .card').addClass('horizontal');
        }
    });
});
