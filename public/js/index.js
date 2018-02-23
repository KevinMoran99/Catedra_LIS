$(document).ready(function() {
    $('.dropdown-trigger').dropdown();
    $('.sidenav').sidenav();
    $('.modal').modal();
    var elem = document.querySelector('select');
    var instance = M.FormSelect.init(elem);
    $('.button-collapse').sidenav();
    $('#menu-user').hide();
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
    attach("main");
});

/*  $('.dropdown-content').on('click', function(event) {
    event.stopPropagation();
});*/

//Cambia el color del item seleccionado del sidenav
$(".menu-item").click(function (event) {

    var triggerer = $(event.target)

    //Si se hace click sobre un li que redirige a games, debe color solamente el li padre
    if (triggerer.parents("li").hasClass("menu-trigger")) {
        if(triggerer.parents("li").hasClass("item-game")) {
            $(".menu-item").removeClass("selected-item");
            $(".menu-item").find("li").removeClass("selected-item");
            $("#menu-games").addClass("selected-item");
        }
    }
    //Si se hace click en cualquier otro li, ocurre el comportamiento normal
    else {
        $(".menu-item").removeClass("selected-item");
        $(".menu-item").find("li").removeClass("selected-item");
        triggerer.parents("li").addClass("selected-item");
    }
});

//Código de login provisional
$('form').submit(function(e) {
    e.preventDefault();
    //Reemplazamos link de Iniciar Sesion por el de Cuenta 
    $('#menu-login').toggle();
    $('#menu-user').toggle();
});

$('.logout').click(function() {
    location.reload();
});


//Al dar aceptar en el modal de términos y condiciones
$('#termsAgree').click(function() {
    $('#signUpTerms').attr('checked', 'checked');
});

function attach(id) {
    $("#container").empty();

    $.ajax({
        method: "POST",
        url: "backend/AjaxControl.php",
        data: "control=" + id,
        success: function(html) {
            $("#container").append(html);
            startCarousel();
            //window.history.pushState("Stoam", "Stoam", window.location.pathname+url);
        }
    });

}