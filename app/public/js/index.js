$(document).ready(function() {
    $('.dropdown-trigger').dropdown();
    $('.sidenav').sidenav();
    $('.modal').modal();
    var elem = document.querySelector('select');
    //var instance = M.FormSelect.init(elem);
    $('.button-collapse').sidenav();
    $('#filter-container').hide();
    $('.js-example-basic-single').select2();
    attach("main",1);

});

/*  $('.dropdown-content').on('click', function(event) {
    event.stopPropagation();
});*/

//Cambia el color del item seleccionado del sidenav
$(".menu-item").click(function(event) {

    var triggerer = $(event.target)
    var parent = triggerer.parents("li");
    var title = $("#nav-title");
    var filter = $("#filter-container");

    //Si se hace click sobre un li que redirige a games, debe color solamente el li padre
    if (parent.hasClass("menu-trigger")) {
        if (parent.hasClass("item-game")) {
            $(".menu-item").removeClass("selected-item");
            $(".menu-item").find("li").removeClass("selected-item");
            $("#menu-games").addClass("selected-item");
        }
    }
    //Si se hace click en cualquier otro li, ocurre el comportamiento normal
    else {
        $(".menu-item").removeClass("selected-item");
        $(".menu-item").find("li").removeClass("selected-item");
        parent.addClass("selected-item");
    }

    //Actualizando navbar según el item seleccionado
    if (parent.is("#menu-support")) {
        title.html("Soporte Técnico");
        filter.hide();
    } else if (parent.is("#menu-about")) {
        title.html("Quiénes somos");
        filter.hide();
    } else if (parent.is("#menu-cart")) {
        title.html("Carrito de compras");
        filter.hide();
    } else if (parent.is("#game-all")) {
        title.html("Todos los juegos:");
        filter.show();
    } else if (parent.is("#game-offer")) {
        title.html("Ofertas:");
        filter.show();
    } else if (parent.is("#game-platform")) {
        title.html("Buscar por plataforma:");
        filter.show();
    } else if (parent.is("#game-publisher")) {
        title.html("Buscar por publicador:");
        filter.show();
    } else if (parent.is("#game-genre")) {
        title.html("Buscar por género:");
        filter.show();
    } else if (parent.is("#game-rating")) {
        title.html("Buscar por ratings:");
        filter.show();
    } else if (parent.is("#game-esrb")) {
        title.html("Buscar por clasificación:");
        filter.show();
    } else if (parent.is("#game-date")) {
        title.html("Buscar por fecha de lanzamiento:");
        filter.show();
    }
});

//login
$('#frmSignIn').submit(function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    formData.append("method","login");
    $.ajax({
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        url: "../http/controllers/UserController.php",
        success: function (result) {
            var output = result.split("|");
            if (output[0] == "Éxito") {
                if (output[1] == "admin")
                    window.location.replace("../dashboard/index.php");
                else
                    window.location.replace("index.php");
            }
            else
                swal({title: output[0], text: output[1], icon: output[2], button: 'Aceptar', closeOnClickOutside: false, closeOnEsc: false})
        }
    });
});

//Registrarse
$('#frmSignUp').submit(function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    formData.append("method","signUp");
    $.ajax({
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        url: "../http/controllers/UserController.php",
        success: function (result) {
            var output = result.split("|");
            console.log(result);
            if (output[0] == "Éxito") {
                swal({title: output[0], text: output[1], icon: output[2], button: 'Aceptar', closeOnClickOutside: false, closeOnEsc: false})
                    .then(function (confirm) {
                        window.location.replace("index.php");
                    }
                );
            }
            else
                swal({title: output[0], text: output[1], icon: output[2], button: 'Aceptar', closeOnClickOutside: false, closeOnEsc: false})
        }
    });
});

$('#logout').click(function() {
    var formData = new FormData();
    formData.append("method","logout");
    $.ajax({
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        url: "../http/controllers/UserController.php",
        success: function (result) {
            window.location.reload();
        }
    });
});


//Al hacer click en 'Editar información'
$('#modalUserTrigger').click(function () {
    //La variable alias esta definida en sidenav.php
   $('#userName').val(alias);
   $('#userNameLabel').addClass('active');
});


//Submit de editar perfil
$('#frmUser').submit(function (event) {
    event.preventDefault();

    var formData = new FormData(this);
    formData.append("method","updateProfile");

    //Mensaje de confirmacion
    swal({
        title: '¿Desea modificar sus datos?',
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
                        $('#modalUser').modal('close');
                        //refrescamos el modal
                        alias = $('#userName').val();
                        $('#userName').val("");
                        $('#userPass').val("");
                        $('#userConfirm').val("");
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

//Al hacer click en "Ver mis facturas"
$('#modalBillsTrigger').click(function () {
    $.ajax({
        method: 'POST',
        data: {'method' : 'getClientBills'},
        url: "../http/controllers/BillController.php",
        success: function (result) {
            var $data = jQuery.parseJSON(result);
            $('#billList').empty();
            for(var i = 0; i < $data.length; i++) {
                $('#billList').append(
                    '<input type="hidden" value=' + $data[i].id + '/> ' +
                    '<a href="#modalBillItems" class="billBtn collection-item modal-trigger">' + $data[i].bill_date + '</a>'
                );
            }
        }
    });
});

//Al hacer click en una de las facturas
$('#billList').on("click", "a", function () {
    var itemId = $(this).prev().val();
    $.ajax({
        method: 'POST',
        data: {'id' : itemId, 'method' : 'getBillForClient'},
        url: "../http/controllers/BillController.php",
        success: function (result) {
            var $bill = jQuery.parseJSON(result);
            //Obteniendo id con los items
            $data = $bill.items;
            $('#billItemList').empty();
            for(var i = 0; i < $data.length; i++) {
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
                                        '<div class="row">' +
                                            '<div class="col s12 priceDetail">' +
                                                '<label>key:</label><br>' +
                                                '<h5>' + $data[i].gameKey + '</h5>' +
                                            '</div>' +
                                        '</div>' +

                                    '</div>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                    '</div>'
                );
            }
        }
    });
});

//Al dar aceptar en el modal de términos y condiciones
$('#termsAgree').click(function() {
    $('#signUpTerms').attr('checked', 'checked');
});

function attach(id,page) {
    $.ajax({
        method: "POST",
        url: "../routing/PublicRouting.php",
        data: "control=" + id+"&current="+page,
        success: function(html) {
            $("#container").empty();
            $("#container").append(html);
            if (id === "main") {

                startCarousel();
            }
            //window.history.pushState("Stoam", "Stoam", window.location.pathname+url);
        }
    });
}

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

function attachDatail(detailId) {
    var container = $("#container");
    var progress = $('#progressModal');
    progress.modal('open');
    $.ajax({
        method: "POST",
        url: "../routing/PublicRouting.php",
        data: "control=gameDetail&id="+detailId,
        success: function(html) {
            container.empty();
            container.append(html);
            progress.modal('close');
            //window.history.pushState("Stoam", "Stoam", window.location.pathname+url);
        }
    });
}