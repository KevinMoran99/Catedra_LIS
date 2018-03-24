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



//Al dar aceptar en el modal de términos y condiciones
$('#termsAgree').click(function() {
    $('#signUpTerms').attr('checked', 'checked');
});

function attach(id,page) {
    $("#container").empty();

    $.ajax({
        method: "POST",
        url: "../routing/PublicRouting.php",
        data: "control=" + id+"&current="+page,
        success: function(html) {
            $("#container").append(html);
            if (id === "main") {

                startCarousel();
            }
            //window.history.pushState("Stoam", "Stoam", window.location.pathname+url);
        }
    });

}